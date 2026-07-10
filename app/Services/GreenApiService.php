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

        $response = Http::post($url, [
            'chatId' => $chatId,
            'message' => $message,
        ]);

        return $response->successful();
    }
}
