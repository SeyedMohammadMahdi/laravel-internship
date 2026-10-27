<?php
namespace App\Services\Notification;

class EmailNotificationService implements NotificationInterface {
    public function send(string $recipient, string $message): array {
        return [
            "type" => "email",
            "recipient" => $recipient,
            "message" => $message,
        ];
    }
}
