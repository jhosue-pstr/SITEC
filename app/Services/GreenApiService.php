<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GreenApiService
{
    protected string $idInstance;

    protected string $apiToken;

    protected string $baseUrl;

    public function __construct()
    {
        $this->idInstance = config('greenapi.id_instance');
        $this->apiToken = config('greenapi.api_token');
        $this->baseUrl = config('greenapi.api_url');
    }

    public function sendMessage(string $chatId, string $message): bool
    {
        $url = "{$this->baseUrl}/waInstance{$this->idInstance}/sendMessage/{$this->apiToken}";

        try {
            $response = Http::timeout(10)->post($url, [
                'chatId' => $chatId,
                'message' => $message,
            ]);

            if (! $response->successful()) {
                \Log::error("Green API error sending to {$chatId}", [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return false;
            }

            return true;
        } catch (\Exception $e) {
            \Log::error("Green API connection error sending to {$chatId}", [
                'message' => $e->getMessage(),
            ]);

            return false;
        }
    }
}
