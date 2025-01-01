<?php

namespace App\Http\Controllers;

use App\Helpers\Cart;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    // Fungsi mendapatkan data user, customer, dan customeraddress
    private function getUserData(Request $request)
    {
        $user = $request->user();
        $customer = $user->customer;
        $customerAddress = $customer->customerAddress;

        return [
            'user' => $user,
            'customer' => $customer,
            'customerAddress' => $customerAddress
        ];
    } 

    // Metode untuk menampilkan halaman checkout
    public function index(Request $request)
    {
        // Mengambil data diri user yang sedang login
        $userData = $this->getUserData($request);

        // Cek apakah user sudah melengkapi informasi data diri
        if (!$userData['customer'] || !$userData['customerAddress']) {
            return redirect()->route('profile.edit')->with('error', 'Please complete your address before checkout');
        }

        // Mengambil data pada keranjang
        $cartData = $this->getCartData();

        // Format harga total ke IDR
        $formattedTotal = $this->formatTotal($cartData);

        // Mengambil data biaya pengiriman
        $deliveryCosts = $this->getDeliveryCosts($userData['customerAddress']);
        
        return view('orders.index', [
            'formattedTotal' => $formattedTotal,
            'listCost' => $deliveryCosts,
            'subtotal' => $cartData['total'],
            'user' => $userData['user'],
            'customer' => $userData['customer'],
            'customerAddress' => $userData['customerAddress'],
        ]);
    }

    // Metode untuk mendapatkan token transaksi midtrans
    public function get_token(Request $request)
    {
        // Mengambil data diri user yang sedang login
        $userData = $this->getUserData($request);

        // Konfigurasi midtrans
        \Midtrans\Config::$serverKey    = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;

        // Mendapatkan data produk dan cart item
        list($products, $cartItems) = Cart::getProductsAndCartItems();

        // Ambi total harga dari request 
        $total = $request->input('cart_total');

        // Detail transaksi
        $transactionDetails = [
            'order_id' => 'ID_' . rand(),
            'gross_amount' => $total
        ];

        // Detail item
        $itemDetails = [];
        foreach ($products as $product) {
            $item = [
                "id" => $product->id,
                "name" => $product->title,
                "quantity" => $cartItems[$product->id]['quantity'],
                "price" => $product->price,
            ];
            array_push($itemDetails, $item);
        }

        // Detail pelanggan
        $customer_details = [
            'first_name' => $userData['customer']->first_name,
            'last_name' => $userData['customer']->last_name,
            'phone' => $userData['customer']->phone,
        ];

        // Detail alamat pengiriman
        $shipping_address = [
            'first_name' => $userData['customer']->first_name,
            'last_name' => $userData['customer']->last_name,
            'phone' => $userData['customer']->phone,
            'address' => $userData['customerAddress']->address,
            'city' => $userData['customerAddress']->city_name,
            'postal_code' => $userData['customerAddress']->zipcode,
            'country_code' => "IDN",
        ];

        // Menambahkan detail alamat pengiriman ke detail pelanggan
        $customer_details['shipping_address'] = $shipping_address;

        // Mengambil ongkir dan jenis kurir
        $deliveryCost = $request->input('deliveryCost');
        $deliveryService = $request->input('deliveryService');

        // Menambahkan ongkir ke detail item 
        array_push($itemDetails, [
            "id" => "DELIVERY_" . rand(),
            "price" => (int)$deliveryCost,
            "quantity" => 1,
            "name" => "JNE " . $deliveryService . ' to ' . $userData['customerAddress']->city_name,
        ]);
        
        // Membuat transaksi
        $transaction = [
            'transaction_details' => $transactionDetails,
            'customer_details' => $customer_details,
            'item_details' => $itemDetails,
        ];

        // Mendapatkan token transkasi midtrans
        $snapToken = \Midtrans\Snap::getSnapToken($transaction);
        return response()->json(['token' => $snapToken]);
    }

    // Metode untuk mendapatkan data transaksi
    public function finish()
    {
        
    }

    // FUngsi untuk mendapatkan data keranjang
    private function getCartData()
    {
        // Mendapatkan data produk dan cart item
        list($products, $cartItems) = Cart::getProductsAndCartItems();
        $total = 0;

        // Loop menghitung total harga
        foreach ($products as $product) {
            // Menambahkan harga produk yang dikalikan dengan kuantitasnya ke total
            $total += $product->price * $cartItems[$product->id]['quantity'];
        }
        
        return [
            'products' => $products,
            'cartItems' => $cartItems,
            'total' => $total,
        ];
    }

    // Fungsi untuk memformat total harga ke IDR
    private function formatTotal($cartData)
    {
        $total = $cartData['total'];
        return 'Rp '. number_format($total, 2, ',', '.');
    }

    // Fungsi untuk mendapatkan ongkir dan kurir 
    private function getDeliveryCosts($customerAddress)
    {
        // Mengirimkan request ke API Raja ongkir
        $res = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY'),
        ])->post('https://api.rajaongkir.com/starter/cost',[
            'origin' => env('RAJAONGKIR_ORIGIN_KEY'),
            'destination' => $customerAddress->city_id,
            'weight' => 1000,
            'courier' => 'jne'
        ]);

        if ($res->failed() || !isset($res['rajaongkir']['results'][0]['costs'])) {
            return [];
        }
        return $res['rajaongkir']['results'][0]['costs'];
    }
}
