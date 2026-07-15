<?php

namespace App\Console\Commands;

use App\Models\ConversacionChatbot;
use App\Services\ChatbotService;
use App\Services\GreenApiService;
use Illuminate\Console\Command;

class SimularChatbot extends Command
{
    protected $signature = 'chatbot:simular
        {numero? : Número simulado (p.ej. 51900000000)}
        {--reset : Borra la conversación previa de ese número antes de empezar}
        {--mensajes=* : Mensajes predefinidos para recorrer el flujo sin preguntar}';

    protected $description = 'Simula el flujo del chatbot de WhatsApp por consola, sin depender de Green API ni de otra persona.';

    public function handle()
    {
        // Reemplazamos GreenApiService por un mock que solo imprime la respuesta
        app()->bind(GreenApiService::class, function () {
            return new class extends GreenApiService {
                public function sendMessage(string $chatId, string $message): bool
                {
                    echo "\n🤖 BOT → {$message}\n";

                    return true;
                }
            };
        });

        $numero = $this->argument('numero') ?? '51900000000';

        if ($this->option('reset')) {
            ConversacionChatbot::where('numero_whatsapp', $numero)->delete();
            $this->warn("Conversación previa de {$numero} eliminada.");
        }

        $this->info("Simulando chatbot para el número {$numero}. Escribí 'salir' para terminar.");
        $this->line('');

        $chatbot = app(ChatbotService::class);

        $mensajes = $this->option('mensajes');
        if (! empty($mensajes)) {
            foreach ($mensajes as $m) {
                $this->line("<fg=cyan>👤 TÚ:</> {$m}");
                $chatbot->handle($numero, $m, 'Tester');
            }

            $this->line('');
            $this->info('Flujo scripted terminado.');

            return self::SUCCESS;
        }

        while (true) {
            $texto = $this->ask('👤 TÚ');
            if ($texto === null || strtolower($texto) === 'salir') {
                break;
            }
            $chatbot->handle($numero, $texto, 'Tester');
        }

        return self::SUCCESS;
    }
}
