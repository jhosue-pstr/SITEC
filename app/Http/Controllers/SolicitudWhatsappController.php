<?php

namespace App\Http\Controllers;

use App\Models\SolicitudWhatsapp;
use App\Services\ChatbotService;
use Illuminate\Http\Request;

class SolicitudWhatsappController extends Controller
{
    public function index()
    {
        $solicitudes = SolicitudWhatsapp::with('tarea')->orderByDesc('created_at')->get();

        return view('solicitudes-whatsapp.index', compact('solicitudes'));
    }

    public function store(Request $request, ChatbotService $chatbot)
    {
        \Log::debug('WhatsApp webhook received', $request->all());

        // --- WhatsApp Cloud API verification ---
        if ($request->has('hub_challenge')) {
            return response($request->hub_challenge);
        }

        // --- WhatsApp Cloud API payload ---
        if ($request->has('entry')) {
            foreach ($request->input('entry', []) as $entry) {
                foreach ($entry['changes'] ?? [] as $change) {
                    $value = $change['value'] ?? [];
                    $messages = $value['messages'] ?? [];

                    foreach ($messages as $msg) {
                        $numero = $msg['from'] ?? null;
                        $texto = $msg['text']['body'] ?? '';
                        $nombre = $value['contacts'][0]['profile']['name'] ?? null;

                        SolicitudWhatsapp::create([
                            'numero_whatsapp' => $numero,
                            'mensaje_original' => $texto,
                            'estado_conversacion' => 'recibido',
                            'external_message_id' => $msg['id'] ?? null,
                        ]);

                        if ($numero) {
                            $chatbot->handle($numero, $texto, $nombre);
                        }
                    }
                }
            }

            return response()->json(['status' => 'ok']);
        }

        // --- Green API webhook payload (v3: sin wrapper 'body') ---
        $typeWebhook = $request->input('typeWebhook');

        // Solo procesamos mensajes entrantes de texto
        if ($typeWebhook === 'incomingMessageReceived') {
            $messageData = $request->input('messageData', []);
            $senderData = $request->input('senderData', []);

            if (! in_array($messageData['typeMessage'] ?? '', ['textMessage', 'extendedTextMessage'])) {
                return response()->json(['status' => 'ignored']);
            }

            $textMessage = match ($messageData['typeMessage']) {
                'extendedTextMessage' => $messageData['extendedTextMessageData']['text'] ?? '',
                default => $messageData['textMessageData']['textMessage'] ?? '',
            };
            $chatId = $senderData['chatId'] ?? '';
            $senderName = $senderData['senderName'] ?? '';
            $numero = str_replace('@c.us', '', $chatId);

            if (! $numero) {
                return response()->json(['status' => 'ignored']);
            }

            SolicitudWhatsapp::create([
                'numero_whatsapp' => $numero,
                'mensaje_original' => $textMessage,
                'estado_conversacion' => 'recibido',
            ]);

            $chatbot->handle($numero, $textMessage, $senderName);

            return response()->json(['status' => 'ok']);
        }

        // --- Green API v2 (con wrapper 'body') ---
        $body = $request->input('body');
        if ($body) {
            $messageData = $body['messageData'] ?? [];
            $senderData = $body['senderData'] ?? [];
            if (! in_array($messageData['typeMessage'] ?? '', ['textMessage', 'extendedTextMessage'])) {
                return response()->json(['status' => 'ignored']);
            }

            $textMessage = match ($messageData['typeMessage']) {
                'extendedTextMessage' => $messageData['extendedTextMessageData']['text'] ?? '',
                default => $messageData['textMessageData']['textMessage'] ?? '',
            };
            $chatId = $senderData['chatId'] ?? '';
            $senderName = $senderData['senderName'] ?? '';
            $numero = str_replace('@c.us', '', $chatId);

            if (! $numero) {
                return response()->json(['status' => 'ignored']);
            }

            SolicitudWhatsapp::create([
                'numero_whatsapp' => $numero,
                'mensaje_original' => $textMessage,
                'estado_conversacion' => 'recibido',
            ]);

            if ($numero) {
                $chatbot->handle($numero, $textMessage, $senderName);
            }

            return response()->json(['status' => 'ok']);
        }

        return response()->json(['status' => 'ignored']);
    }
}
