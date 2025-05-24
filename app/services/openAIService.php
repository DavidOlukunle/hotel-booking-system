<?php
namespace app\services;

class OpenAIService
{
    private $apiKey = "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";
    public function sendToOpenAI($message)
    {
        $url = 'https://api.openai.com/v1/chat/completions';

        $postData = json_encode([
            'model' => 'gpt-3.5-turbo',
            'messages' => [['role' => 'user', 'content' => $message]],
        ]);

        $headers = [
            "Authorization: Bearer {$this->apiKey}",
            "Content-Type: application/json",
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            return 'Error: ' . curl_error($ch);
        }

        curl_close($ch);

        $decoded = json_decode($result, true);
        return $decoded['choices'][0]['message']['content'] ?? 'Error: Unexpected API response';
    }
}
