<?php
namespace App\Services\Notification;

interface NotificationInterface {
    public function send(string $recipient, string $message): array;
}
