<?php

namespace App\Listeners;

use App\Events\OrderPlaceEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class OrderPlaceNotifyListener
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
    public function handle(OrderPlaceEvent $event): void
    {
        $order = $event->orderDTO;
        Log::info("notifying user: ". $order->customerName);
    }
}
