<?php

namespace App\Jobs;

use App\DTOs\Order\OrderCreateDTO;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendOrderNotification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public $tries = 3;
    public $backoff= ["5", "10", "15"];
    public function __construct(
        public string $customerName,
        public float $totalPrice,

    )
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("JOB EXECUTED: Order placed. customer name: " . $this->customerName . " total price: " . $this->totalPrice);
    }
}
