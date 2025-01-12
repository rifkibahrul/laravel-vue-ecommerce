<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\CustomerResource;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Resources\CustomerListResource;

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

    /**
     * Update specified resource in storage
     * 
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileUpdateRequest $request, Customer $customer)
    {
        $validatedData = $request->validated();

        // Update data user
        $request->user()->fill([
            'name' => $validatedData['name'],
            'email' => $validatedData['email']
        ]);

        $request->user()->save(); // Menyimpan perubahan user

        // Perbarui data customer
        $customer->fill([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'phone' => $validatedData['phone'],
            'status' => $validatedData['status'],
        ])->save();

        // Perbarui atau buat data alamat customer
        $customerAddress = $customer->customerAddress ?? new CustomerAddress();
        $customerAddress->fill([
            'address' => $validatedData['address'],
            'province_id' => $validatedData['province_id'],
            'province_name' => $validatedData['province_name'],
            'city_id' => $validatedData['city_id'],
            'city_name' => $validatedData['city_name'],
            'zipcode' => $validatedData['zipcode'],
        ]);
        $customerAddress->customer()->associate($customer);
        $customerAddress->save();

        // Kembalikan hasil update menggunakan CustomerResource
        return new CustomerResource($customer->load('customerAddress'));
    }

    /**
     * Remove the specified resource
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->noContent();
    }

    // Mengambil daftar provinsi dari API RajaOngkir
    public function getProvinces()
    {
        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY'),
        ])->get('https://api.rajaongkir.com/starter/province');

        if ($response->failed()) {
            return response()->json(['error' => 'Gagal mengambil data provinsi'], 500);
        }

        return response()->json($response->json()['rajaongkir']['results']);
    }

    // Mengambil daftar kota berdasarkan provinsi
    public function getCities(Request $request)
    {
        $provinceId = $request->input('province_id');

        $response = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY'),
        ])->get('https://api.rajaongkir.com/starter/city', [
            'province' => $provinceId,
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Gagal mengambil data kota'], 500);
        }

        return response()->json($response->json()['rajaongkir']['results']);
    }
}
