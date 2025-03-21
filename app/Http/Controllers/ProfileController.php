<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Enums\AddressType;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Customer;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        // Mengambil data pengguna yang sedang login
        $user = $request->user();

        // Mengambil data customer berdasarkan user id, atau membuat objek kosong jika tidak ada
        $customer = $user->customer ?? (object) [
            'first_name' => '',
            'last_name' => '',
            'phone' => '',
        ];

        // Mengambil data alamat berdasarkan customer id, atau membuat objek kosong jika tidak ada
        $customerAddress = $customer->customerAddress ?? (object) [
            'address' => '',
            'zipcode' => '',
            'province_name' => '',
            'city_name' => '',
            'province_id' => '',
            'city_id' => '',
        ];

        // Mengambil data API RajaOngkir
        $provRes = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY'),
        ])->get('https://api.rajaongkir.com/starter/province');

        if ($provRes->failed()) {
            return abort(404);
        }

        // Mengubah respon API menjadi array
        $provData = $provRes->json();

        // Mengambil daftar provinsi
        $listProvince = $provData['rajaongkir']['results'];

        $cityRes = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY'),
        ])->get('https://api.rajaongkir.com/starter/city', [
            'province' => $customerAddress->province_id
        ]);

        if ($cityRes->failed()) {
            return abort(404);
        }

        $cityData = $cityRes->json();
        $cityList = $cityData['rajaongkir']['results'];

        $selectedCity = collect($cityList)->firstWhere('city_id', $customerAddress->city_id);

        return view('profile.edit', compact('user', 'customer', 'customerAddress', 'listProvince', 'selectedCity'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request)
    {
        // Validasi data dari form
        $validatedData = $request->validated();

        // Update data user
        $request->user()->fill([
            'name' => $validatedData['name'],
            'email' => $validatedData['email']
        ]);

        // Chek perubahan email
        if ($request->user()->isDirty('email')) {
            // Kirim verifikasi jika email berubah
            $request->user()->email_verified_at = null;
        }

        $request->user()->save(); // Menyimpan perubahan user

        // Update data Customer
        $customer = $request->user()->customer;
        if (!$customer) {       // Cek jika belum ada data customer, buat customer baru
            $customer = new Customer();
            $customer->user()->associate($request->user());
        }
        $customer->fill([
            'first_name' => $request->input('first_name', $customer->first_name ?? ''),
            'last_name' => $request->input('last_name', $customer->last_name ?? ''),
            'phone' => $request->input('phone', $customer->phone ?? ''),
            'status' => $request->input('status', $customer->status ?? ''),
        ]);
        $customer->save();
        // dd($customer);

        // Update data CustomerAddress
        $customerAddress = $customer->customerAddress;
        if (!$customerAddress) {        // Cek jika belum ada data CustomerAddress, buat CustomerAddress baru
            $customerAddress = new CustomerAddress();
            $customerAddress->customer()->associate($customer);
        }
        $provinceName = $request->input('province_name', $customerAddress->province_name ?? '');
        $cityName = $request->input('city_name', $customerAddress->city_name ?? '');

        $customerAddress->fill([
            'address' => $request->input('address', $customerAddress->address ?? ''),
            'province_id' => $request->input('province_id', $customerAddress->province_id ?? ''),
            'city_id' => $request->input('city_id', $customerAddress->city_id ?? ''),
            'province_name' => $provinceName,
            'city_name' => $cityName,
            'zipcode' => $request->input('zipcode', $customerAddress->zipcode ?? ''),
        ]);
        $customerAddress->save();
        // dd($customerAddress);

        // $request->session()->flash('flash_message', 'Profile was successfully updated.');

        return Redirect::route('profile.edit')->with('flash_message', 'Profile was successfully updated.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }


    public function get_cities(Request $request)
    {
        $province_id = $request->input('province_id');
        $listCity = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY'),
        ])->get('https://api.rajaongkir.com/starter/city', [
            'province' => $province_id
        ]);

        if ($listCity->failed()) {
            return response('Failed', 404);
        }

        $data = $listCity->json();

        // dd($listCity = $data['rajaongkir']['result']);
        $listCity = $data['rajaongkir']['results'];
        // dd($listCity);
        return response()->json($listCity);
    }
}
