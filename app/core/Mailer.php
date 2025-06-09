<?php
namespace app\core;
require_once __DIR__ . "/../config/config.php";
use app\config\config;

class Mailer{
    private $apiKey;
    private $configModel;

    public function __construct()
    {
       $this->configModel = new config();
       $configArray = $this->configModel->config();
       $this->apiKey = $configArray['resend_api_key'];

    }


    public function sendInvite($toEmail, $toName, $inviteLink){
        $data = [
            "from"=>"Hotel Booking <onboarding@resend.dev>",
            "to"=>[$toEmail],
            "subject"=> "You are invited to confirm Booking",
            "html"=> "<p>Hello <strong>{$toName}</strong>, </p>
            <p>You have been invited to paradise hotel please confirm booking.</p>
            <p><a href = '{$inviteLink}' style='padding: 10px 15px; background-color: #2563eb; color: white; text-decoration: none; border-radius: 5px;'>Accept Invite</a></p>"
        ];

        $ch = curl_init('https://api.resend.com/emails');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return "Error sending email: $error";
        }

        $result = json_decode($response, true);
        return isset($result['id']) ? true : false;
    }

    public function sendResetEmail($toEmail, $resetLink){
         $data = [
        "from"=>"Hotel Booking <onboarding@resend.dev>",
        'to' => $toEmail,
        'subject' => 'Reset your password',
        'html' => "<p>Click to reset your password:</p><a href='$resetLink'>$resetLink</a>"
    ];

      $ch = curl_init('https://api.resend.com/emails');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return "Error sending email: $error";
        }

        $result = json_decode($response, true);
        return isset($result['id']) ? true : false;
    }
   
}
    
