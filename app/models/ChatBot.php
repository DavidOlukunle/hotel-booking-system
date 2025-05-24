<?php

namespace app\models;




class ChatBot
{
    public function getResponse($message)
    {
        $message = strtolower(trim($message));

        $responses = [
            'hello|hi|hey' => 'Hello! Welcome to our hotel. How can I assist you today?',
            'room rates|price|cost' => 'Our room rates start at $99 per night. Would you like to know about specific room types?',
            'amenities|facilities' => 'We offer free WiFi, swimming pool, fitness center, and 24/7 room service.',
            'check in|check-in' => 'Check-in time is at 3 PM. Early check-in may be available upon request.',
            'check out|check-out' => 'Check-out time is at 11 AM. Late check-out may be arranged with additional fee.',
            'breakfast' => 'We serve complimentary breakfast from 6:30 AM to 10:30 AM in our dining area.',
            'contact|phone|number' => 'You can reach us at +1-555-123-4567 or frontdesk@yourhotel.com',
            'default' => 'I\'m sorry, I didn\'t understand that. Could you please rephrase or ask about our rooms, amenities, or services?'
        ];

       foreach ($responses as $keywords => $response) {
            if ($keywords === 'default') continue;
            if (preg_match('/'.str_replace('|', '|', $keywords).'/', $message)) {
                return $response;
            }
        }
        
        return $responses['default'];
    }
}
