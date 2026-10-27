<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Notification\NotificationDispatcher;
use App\Http\Requests\NotificationRequest;
class NotificationController extends Controller
{
    private NotificationDispatcher $dispatcher;
    public function __construct()
    {
        $this->dispatcher = new NotificationDispatcher();
    }

    function sendNotification(NotificationRequest $request): JsonResponse {
        $body = $request->validated();

        return response()->json($this->dispatcher->dispatch($body["type"], $body["recipient"], $body["message"]), 200);
    }
}
