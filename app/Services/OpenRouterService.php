<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenRouterService
{
    protected $apiKey;
    protected $baseUrl = "https://openrouter.ai/api/v1";

    public function __construct()
    {
        $this->apiKey = env('API_KEY');
    }

    public function chat($messages, $tools = null)
    {
        $body = [
            "model" => "tngtech/tng-r1t-chimera:free",
            "messages" => $messages,
        ];

        if ($tools) {
            $body["tools"] = $tools;
            $body["tool_choice"] = "auto";
        }

        return Http::withoutVerifying() 
            ->withHeaders([
                "Authorization" => "Bearer {$this->apiKey}",
                "Content-Type" => "application/json",
            ])
            ->timeout(120)
            ->post("$this->baseUrl/chat/completions", $body)
            ->json();
    }
}
