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
            'esperando_descripcion' => $this->esperandoDescripcion($conversacion, $mensaje),
            'esperando_telefono' => $this->esperandoTelefono($conversacion, $mensaje),
            'esperando_confirmacion' => $this->esperandoConfirmacion($conversacion, $texto),
            default => $this->estadoInicio($conversacion, $texto, $nombreRemitente),
        };
    }

    protected function estadoInicio(ConversacionChatbot $conv, string $texto, ?string $nombreRemitente): void
    {
        if (in_array($texto, ['1', 'hola', 'solicitud', 'nueva solicitud', 'quiero hacer una solicitud', 'si', 'sí'])) {
            $conv->update(['estado' => 'esperando_nombre', 'datos_temp' => []]);
            $this->responder($conv->numero_whatsapp, 'Por favor, escribí tu *nombre completo*:');
        } else {
            $saludo = $nombreRemitente ? "Hola *{$nombreRemitente}*! 👋\n\n" : "Hola! 👋\n\n";
            $this->responder($conv->numero_whatsapp,
                "{$saludo}Soy el asistente virtual de soporte técnico.\n\n".
                "📋 *Opciones:*\n".
                "1️⃣ Hacer una nueva solicitud de soporte\n\n".
                "Respondé *1* o *'Nueva solicitud'* para comenzar."
            );
        }
    }

    protected function esperandoNombre(ConversacionChatbot $conv, string $nombre): void
    {
        $datos = $conv->datos_temp;
        $datos['nombres'] = $nombre;
        $conv->update(['estado' => 'esperando_oficina', 'datos_temp' => $datos]);

        $this->responder($conv->numero_whatsapp, "Gracias *{$nombre}*.\n\n¿En qué *oficina* trabajás? (ej: Secretaría General, Alcaldía, RRHH)");
    }

    protected function esperandoOficina(ConversacionChatbot $conv, string $oficina): void
    {
        $oficinaDb = Oficina::whereRaw('LOWER(nombre) LIKE ?', ['%'.mb_strtolower($oficina).'%'])->first();
        $oficinaNombre = $oficinaDb?->nombre ?? $oficina;

        $datos = $conv->datos_temp;
        $datos['oficina'] = $oficinaNombre;
        $datos['oficina_id'] = $oficinaDb?->id;
        $conv->update(['estado' => 'esperando_descripcion', 'datos_temp' => $datos]);

        $this->responder($conv->numero_whatsapp, "Anotado: *{$oficinaNombre}*.\n\nAhora describí el *problema técnico* que tenés (qué equipo, qué pasa, desde cuándo):");
    }

    protected function esperandoDescripcion(ConversacionChatbot $conv, string $descripcion): void
    {
        $datos = $conv->datos_temp;
        $datos['descripcion'] = $descripcion;
        $conv->update(['estado' => 'esperando_telefono', 'datos_temp' => $datos]);

        $this->responder($conv->numero_whatsapp, "Entendido. Por último, ¿un *teléfono de contacto*? (opcional, escribí 'ninguno' si no querés)");
    }

    protected function esperandoTelefono(ConversacionChatbot $conv, string $telefono): void
    {
        $datos = $conv->datos_temp;
        $datos['telefono'] = in_array(mb_strtolower($telefono), ['ninguno', 'no', 'n/a', '-', '']) ? null : $telefono;
        $conv->update(['estado' => 'esperando_confirmacion', 'datos_temp' => $datos]);

        $resumen =
            "📋 *Resumen de tu solicitud:*\n\n".
            "👤 *Nombre:* {$datos['nombres']}\n".
            "🏢 *Oficina:* {$datos['oficina']}\n".
            "🔧 *Problema:* {$datos['descripcion']}\n".
            ($datos['telefono'] ? "📞 *Teléfono:* {$datos['telefono']}\n" : '').
            "\n¿Está todo correcto? Respondé *Sí* para confirmar o *No* para empezar de nuevo.";

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
            ['telefono' => $datos['telefono'] ?? $numero],
            [
                'nombres' => explode(' ', $datos['nombres'])[0] ?? $datos['nombres'],
                'apellidos' => count(explode(' ', $datos['nombres'])) > 1
                    ? implode(' ', array_slice(explode(' ', $datos['nombres']), 1))
                    : '—',
                'correo' => 'whatsapp_'.str_replace(['@', '.', '-'], '_', $numero).'@sitec.local',
                'rol' => 'solicitante',
                'activo' => true,
                'password' => bcrypt('changeme'),
            ]
        );

        $lastTask = Tarea::latest('id')->first();
        $nextNumber = $lastTask ? (int) substr($lastTask->codigo, 2) + 1 : 1;
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
