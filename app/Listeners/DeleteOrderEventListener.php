<?php

namespace App\Listeners;

use App\Events\OrderCancelEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class DeleteOrderEventListener
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
        Log::info("Delete Order Event: " . $event->orderId);
    }
}
