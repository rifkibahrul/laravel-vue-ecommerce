<?php

namespace App\Http\Controllers\Api;

use App\Enums\CustomerStatus;
use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\OrderResource;
use App\Traits\ReportTrait;

class DashboardController extends Controller
{
    use ReportTrait;
    
    public function activeCustomers()
    {
        return Customer::where('status', CustomerStatus::Active->value)->count();
        // return Customer::count();
    }

    public function publishedProducts()
    {
        return Product::where('published', '=', 1)->count();
    }

    public function ordersPayment()
    {
        $fromDate = $this->getFromDate();
        // $query = Order::query()->where('status', '=', 'Settlement');
        $query = Order::query()->where('status', OrderStatus::Settlement->value);

        if ($fromDate) {
            $query->where('created_at', '>', $fromDate);
        }

        return $query->count();
    }

    public function totalIncome()
    {
        $fromDate = $this->getFromDate();
        $query = Order::query()->where('status', OrderStatus::Settlement->value);

        if ($fromDate) {
            $query->where('created_at', '>', $fromDate);
        }

        return round($query->sum('total_price'));
    }

    public function ordersByCities()
    {
        $fromDate = $this->getFromDate();
        $query = Order::query()
            ->select(['customer_addresses.city_name', DB::raw('count(orders.id) as count')])
            ->join('users', 'orders.created_by', '=', 'users.id')
            ->join('customer_addresses', 'users.id', '=', 'customer_addresses.user_id')
            ->where('orders.status', OrderStatus::Settlement->value)
            ->groupBy('customer_addresses.city_name');

        if ($fromDate) {
            $query->where('orders.created_at', '>', $fromDate);
        }

        return $query->get();
    }

    public function latestCustomers()
    {
        return Customer::query()
            ->select([
                'users.id',
                'customers.first_name',
                'customers.last_name',
                'users.email',
                'customers.phone',
                'users.created_at as user_created_at'
            ])
            ->join('users', 'users.id', '=', 'customers.user_id')
            ->where('customers.status', CustomerStatus::Active->value)
            ->orderBy('users.created_at', 'desc')
            ->limit(5)
            ->get();
    }

    public function latestOrders()
    {
        return OrderResource::collection(
            Order::query()
                ->select([
                    'orders.id',
                    'orders.total_price',
                    'orders.created_at',
                    DB::raw('COUNT(orders.id) AS items'),
                    'customers.user_id',
                    'customers.first_name',
                    'customers.last_name',
                ])
                ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->join('customers', 'customers.user_id', '=', 'orders.created_by')
                ->where('orders.status', OrderStatus::Settlement->value)
                ->limit(10)
                ->orderBy('orders.created_at', 'desc')
                ->groupBy('orders.id', 'orders.total_price', 'orders.created_at', 'customers.user_id', 'customers.first_name', 'customers.last_name')
                ->get()
        );
    }
}
