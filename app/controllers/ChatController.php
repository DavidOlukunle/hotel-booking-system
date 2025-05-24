<?php
namespace app\controllers;
 require_once __DIR__ . '/../Models/ChatBot.php';
 require_once __DIR__ . '/../services/OpenAIService.php';
 use app\models\ChatBot;




class ChatController
{

    public function __construct(){
        
    }
    

    public function getReply()
    {
        header('Content-Type: application/json');

        $message = $_POST['message'] ?? '';

        if (empty($message)) {
            echo json_encode(['error' => 'No message provided']);
            exit;
        }

        $bot = new ChatBot();
        $response = $bot->getResponse($message);

        echo json_encode(['response' => $response]);
    }
}
