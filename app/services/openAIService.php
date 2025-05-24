<?php
namespace app\services;

class OpenAIService
{
    private $apiKey = "";
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
