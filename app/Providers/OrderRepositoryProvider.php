<?php

namespace App\Providers;

use App\Models\Order;
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
            return new OrderRepository($table);
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
