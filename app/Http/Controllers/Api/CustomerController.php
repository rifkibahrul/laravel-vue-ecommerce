<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerListResource;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');

        $query = Customer::query()
            ->select('customers.*', 'users.email') // Memilih kolom dari tabel users
            ->join('users', 'customers.user_id', '=', 'users.id') // Join tabel users
            ->orderBy("customers.$sortField", $sortDirection);
        if ($search) {
            $query
                ->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$search}%")
                ->orWhere('users.email', 'like', "%{$search}%")
                ->orWhere('customers.phone', 'like', "%{$search}%")
            ;
        }

        $paginator = $query->paginate($perPage);

        return CustomerListResource::collection($paginator);
    }
    /**
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        try {
            $customer->load(['user', 'customerAddress']);
            return new CustomerResource($customer);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal mengambil data customer'], 500);
        }
    }
}
