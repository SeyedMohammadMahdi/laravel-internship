<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Order_Items;
use App\Repositories\Order\OrderRepository;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class OrderRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(OrderRepositoryInterface::class, function ($app) {
            $table = new Order()->getTable();
            $order_items_table = new Order_Items()->getTable();
            return new OrderRepository($table, $order_items_table);
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
