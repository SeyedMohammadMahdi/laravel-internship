<?php
namespace App\Services\Notification;

class SMSNotificationService implements NotificationInterface {
    public function send(string $recipient, string $message): array {
        return [
            "type" => "sms",
            "recipient" => $recipient,
            "message" => $message,
        ];
    }
}
