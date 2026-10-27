<?php
namespace App\Services\Notification;
class NotificationDispatcher
{
    public function dispatch(string $type, string $recipient, string $message) : array {
        try {
            $notificationBackend = match ($type) {
                "sms" => new SMSNotificationService(),
                "email" => new EmailNotificationService(),
                default => throw new \Exception("Unsupported notification type"),
            };
            return $notificationBackend->send($recipient, $message);
        } catch (\Exception $exception) {
            return [
                "message" => $exception->getMessage(),
            ];
        }
    }
}
