<?php

namespace App\Listeners;

use App\Events\OrderCancelEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class DeleteOrderNotifierListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderCancelEvent $event): void
    {
        Log::info("NOTIFICATION: Dear Customer your Order with id of " . $event->orderId . " is deleted.");
    }
}
