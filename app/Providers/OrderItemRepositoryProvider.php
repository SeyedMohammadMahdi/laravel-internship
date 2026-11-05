<?php

namespace App\Providers;

use App\Models\Order_Items;
use App\Repositories\OrderItem\OrderItemRepository;
use App\Repositories\OrderItem\OrderItemRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class OrderItemRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(OrderItemRepositoryInterface::class, function ($app) {
            $table = new Order_Items()->getTable();
            return new OrderItemRepository($table);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
