<?php

namespace App\Services;

use App\Models\ConversacionChatbot;
use App\Models\Notificacion;
use App\Models\Oficina;
use App\Models\Tarea;
use App\Models\Usuario;

class ChatbotService
{
    protected GreenApiService $greenApi;

    public function __construct(GreenApiService $greenApi)
    {
        $this->greenApi = $greenApi;
    }

    public function handle(string $numero, string $mensaje, ?string $nombreRemitente = null): void
    {
        $conversacion = ConversacionChatbot::firstOrCreate(
            ['numero_whatsapp' => $numero],
            ['estado' => 'inicio', 'datos_temp' => []]
        );

        $texto = mb_strtolower(trim($mensaje));

        match ($conversacion->estado) {
            'inicio' => $this->estadoInicio($conversacion, $texto, $nombreRemitente),
            'esperando_nombre' => $this->esperandoNombre($conversacion, $mensaje),
            'esperando_oficina' => $this->esperandoOficina($conversacion, $mensaje),
            'confirmar_oficina' => $this->confirmarOficina($conversacion, $texto),
            'esperando_descripcion' => $this->esperandoDescripcion($conversacion, $mensaje),
            'esperando_confirmacion' => $this->esperandoConfirmacion($conversacion, $texto),
            default => $this->estadoInicio($conversacion, $texto, $nombreRemitente),
        };
    }

    protected function estadoInicio(ConversacionChatbot $conv, string $texto, ?string $nombreRemitente): void
    {
        if (in_array($texto, ['1', 'solicitud', 'nueva solicitud', 'quiero hacer una solicitud'])) {
            $usuarioExistente = Usuario::where('telefono', $conv->numero_whatsapp)->first();

            if ($usuarioExistente) {
                $nombreCompleto = trim($usuarioExistente->nombres.' '.$usuarioExistente->apellidos);
                $datos = ['nombres' => $nombreCompleto];

                if ($usuarioExistente->oficina_id) {
                    $oficina = Oficina::find($usuarioExistente->oficina_id);
                    $datos['oficina'] = $oficina?->nombre ?? '—';
                    $datos['oficina_id'] = $oficina?->id;
                    $conv->update(['estado' => 'confirmar_oficina', 'datos_temp' => $datos]);
                    $this->responder($conv->numero_whatsapp,
                        "Hola de nuevo *{$nombreCompleto}* 🙌\n\n".
                        "Veo que sos de la oficina de *{$datos['oficina']}*.\n".
                        '¿Es correcto? Respondé *Sí* o *No*'
                    );
                } else {
                    $conv->update(['estado' => 'esperando_oficina', 'datos_temp' => $datos]);
                    $this->responder($conv->numero_whatsapp,
                        "Hola de nuevo *{$nombreCompleto}* 🙌\n\n".
                        "¿En qué *oficina* trabajás?\n".
                        '(ej: Alcaldía, Secretaría General, RRHH, Tesorería, Imagen)'
                    );
                }
            } else {
                $conv->update(['estado' => 'esperando_nombre', 'datos_temp' => []]);
                $this->responder($conv->numero_whatsapp, '✍️ Por favor, escribí tu *nombre completo*:');
            }
        } else {
            $usuarioExistente = Usuario::where('telefono', $conv->numero_whatsapp)->first();
            $nombreDb = $usuarioExistente ? trim($usuarioExistente->nombres.' '.$usuarioExistente->apellidos) : null;
            $saludo = $nombreDb ? "¡Hola de nuevo *{$nombreDb}*! 👋\n\n" : "¡Hola! 👋\n\n";
            $this->responder($conv->numero_whatsapp,
                "{$saludo}Te has comunicado con *Mesa de Ayuda - OGTI* 🤖\n".
                "Sistema de Gestión de Soporte Técnico.\n\n".
                "📋 *Opciones:*\n".
                "1️⃣ Hacer una nueva solicitud de soporte\n\n".
                "Respondé *1* o *'Nueva solicitud'* para comenzar."
            );
        }
    }

    protected function esperandoNombre(ConversacionChatbot $conv, string $nombre): void
    {
        $textoLimpio = mb_strtolower(trim($nombre));
        $invalidos = ['hola', 'hello', 'hi', 'buenas', 'que tal', 'que onda', 'hey', 'ok', 'si', 'no', 'sí', 'gracias', 'bien', 'mal'];

        if (strlen($textoLimpio) < 3 || in_array($textoLimpio, $invalidos)) {
            $this->responder($conv->numero_whatsapp,
                'Ese parece un saludo 😅. Por favor, escribí tu *nombre y apellido* para continuar:'
            );

            return;
        }

        $datos = $conv->datos_temp;
        $datos['nombres'] = $nombre;

        $usuarioExistente = Usuario::where('telefono', $conv->numero_whatsapp)->first();

        if ($usuarioExistente?->oficina_id) {
            $oficina = Oficina::find($usuarioExistente->oficina_id);
            $datos['oficina'] = $oficina?->nombre ?? '—';
            $datos['oficina_id'] = $oficina?->id;
            $conv->update(['estado' => 'confirmar_oficina', 'datos_temp' => $datos]);
            $this->responder($conv->numero_whatsapp,
                "Gracias *{$nombre}* 🙌\n\n".
                "Veo que eres de la oficina de *{$datos['oficina']}*.\n".
                '¿Es correcto? Respondé *Sí* o *No*'
            );
        } else {
            $conv->update(['estado' => 'esperando_oficina', 'datos_temp' => $datos]);
            $this->responder($conv->numero_whatsapp,
                "Gracias *{$nombre}* 🙌\n\n".
                "¿En qué *oficina* trabajás?\n".
                '(ej: Alcaldía, Secretaría General, RRHH, Tesorería, Imagen)'
            );
        }
    }

    protected function esperandoOficina(ConversacionChatbot $conv, string $oficina): void
    {
        $oficinaDb = Oficina::whereRaw('LOWER(nombre) = LOWER(?)', [trim($oficina)])->first();

        if (! $oficinaDb) {
            $oficinaDb = Oficina::create(['nombre' => trim($oficina)]);
        }

        $datos = $conv->datos_temp;
        $datos['oficina'] = $oficinaDb->nombre;
        $datos['oficina_id'] = $oficinaDb->id;
        $conv->update(['estado' => 'confirmar_oficina', 'datos_temp' => $datos]);

        $usuarioExistente = Usuario::where('telefono', $conv->numero_whatsapp)->first();
        if ($usuarioExistente) {
            $usuarioExistente->update(['oficina_id' => $oficinaDb->id]);
        }

        $this->responder($conv->numero_whatsapp,
            "La oficina es *{$oficinaDb->nombre}*, ¿es correcto?\n".
            'Respondé *Sí* o *No*'
        );
    }

    protected function confirmarOficina(ConversacionChatbot $conv, string $texto): void
    {
        if (in_array($texto, ['si', 'sí', 's', 'yes', 'ok', 'dale', 'correcto'])) {
            $datos = $conv->datos_temp;

            $usuarioExistente = Usuario::where('telefono', $conv->numero_whatsapp)->first();
            if ($usuarioExistente && ! empty($datos['oficina_id'])) {
                $usuarioExistente->update(['oficina_id' => $datos['oficina_id']]);
            }

            $conv->update(['estado' => 'esperando_descripcion']);
            $this->responder($conv->numero_whatsapp,
                "Perfecto ✅\n\n".
                "Describí el *problema técnico* que tenés:\n".
                '¿qué equipo es, qué pasa, desde cuándo?'
            );
        } else {
            $conv->update(['estado' => 'esperando_oficina']);
            $this->responder($conv->numero_whatsapp,
                "OK, ¿En qué *oficina* trabajás?\n".
                '(ej: Alcaldía, Secretaría General, RRHH, Tesorería, Imagen)'
            );
        }
    }

    protected function esperandoDescripcion(ConversacionChatbot $conv, string $descripcion): void
    {
        $datos = $conv->datos_temp;
        $datos['descripcion'] = $descripcion;
        $conv->update(['estado' => 'esperando_confirmacion', 'datos_temp' => $datos]);

        $resumen =
            "📋 *Resumen de tu solicitud:*\n\n".
            "👤 *Nombre:* {$datos['nombres']}\n".
            "🏢 *Oficina:* {$datos['oficina']}\n".
            "🔧 *Problema:* {$datos['descripcion']}\n\n".
            '¿Está todo correcto? Respondé *Sí* para confirmar o *No* para empezar de nuevo.';

        $this->responder($conv->numero_whatsapp, $resumen);
    }

    protected function esperandoConfirmacion(ConversacionChatbot $conv, string $texto): void
    {
        if (in_array($texto, ['si', 'sí', 's', 'yes', 'confirmar', 'ok', 'vale', 'dale'])) {
            $this->crearTarea($conv);
        } else {
            $conv->update(['estado' => 'inicio', 'datos_temp' => []]);
            $this->responder($conv->numero_whatsapp, "OK, empecemos de nuevo.\n\n📋 Decí *'Nueva solicitud'* para comenzar.");
        }
    }

    protected function crearTarea(ConversacionChatbot $conv): void
    {
        $datos = $conv->datos_temp;
        $numero = $conv->numero_whatsapp;

        $usuario = Usuario::firstOrCreate(
            ['telefono' => $numero],
            [
                'nombres' => explode(' ', $datos['nombres'])[0] ?? $datos['nombres'],
                'apellidos' => count(explode(' ', $datos['nombres'])) > 1
                    ? implode(' ', array_slice(explode(' ', $datos['nombres']), 1))
                    : '—',
                'correo' => null,
                'rol' => 'solicitante',
                'activo' => true,
                'password' => bcrypt('changeme'),
            ]
        );

        if ($usuario->wasRecentlyCreated && ! empty($datos['oficina_id'])) {
            $usuario->update(['oficina_id' => $datos['oficina_id']]);
        } elseif (! $usuario->oficina_id && ! empty($datos['oficina_id'])) {
            $usuario->update(['oficina_id' => $datos['oficina_id']]);
        }

        $maxCode = Tarea::where('codigo', 'like', 'T-%')->max('codigo');
        if ($maxCode && preg_match('/^T-(\d+)$/', $maxCode, $m)) {
            $nextNumber = (int) $m[1] + 1;
        } else {
            $nextNumber = Tarea::where('codigo', 'like', 'T-%')->count() + 1;
        }
        $codigo = 'T-'.str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        $tarea = Tarea::create([
            'codigo' => $codigo,
            'titulo' => 'Solicitud WhatsApp - '.$datos['nombres'],
            'descripcion' => $datos['descripcion'],
            'tipo_soporte' => 'otro',
            'prioridad' => 'media',
            'estado' => 'pendiente',
            'solicitante_id' => $usuario->id,
            'oficina_id' => $datos['oficina_id'] ?? null,
        ]);

        $conv->tarea_id = $tarea->id;
        $conv->estado = 'completado';
        $conv->save();

        Notificacion::create([
            'usuario_id' => Usuario::where('rol', 'jefe')->first()?->id,
            'tarea_id' => $tarea->id,
            'titulo' => 'Nueva solicitud por WhatsApp',
            'mensaje' => "{$datos['nombres']} solicitó soporte desde WhatsApp: {$tarea->codigo}",
        ]);

        $this->responder($numero,
            "✅ *Solicitud creada con éxito!*\n\n".
            "📌 *Código:* {$codigo}\n".
            "📝 *Problema:* {$datos['descripcion']}\n\n".
            'Un técnico se pondrá en contacto pronto. Gracias!'
        );
    }

    protected function responder(string $numero, string $mensaje): void
    {
        $chatId = str_contains($numero, '@c.us') ? $numero : $numero.'@c.us';
        $this->greenApi->sendMessage($chatId, $mensaje);
    }
}
