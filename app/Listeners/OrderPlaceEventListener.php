<?php

namespace App\Listeners;

use App\DTOs\Order\OrderCreateDTO;
use App\Events\OrderPlaceEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class OrderPlaceEventListener
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
        $orderDTO = $event->orderDTO;
        Log::info("Order placed. customer name: " . $orderDTO->customerName);
    }
}
