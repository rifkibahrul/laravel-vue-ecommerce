<?php

namespace App\Http\Controllers;

use App\Helpers\Cart;
use App\Models\Order;
use Ramsey\Uuid\Uuid;
use App\Models\Payment;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Enums\OrderStatus;
use Illuminate\Support\Arr;
use App\Enums\PaymentStatus;
use Hidehalo\Nanoid\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    // Fungsi mendapatkan data user, customer, dan customeraddress
    private function getUserData(Request $request)
    {
        $user = $request->user();
        $customer = $user->customer;
        $customerAddress = $customer->customerAddress ?? null;

        // Cek apakah user sudah melengkapi informasi data diri
        if (!$customer || !$customerAddress) {
            return redirect()->route('profile.edit')->with('error', 'Please complete your address before checkout');
        }

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

        if ($userData instanceof \Illuminate\Http\RedirectResponse) {
            return $userData;
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
        $client = new Client();
        $nanoid = $client->generateId(10);
        $timestamp = time();
        $uniqueId = $timestamp . '_' . $nanoid;
        $transactionDetails = [
            'order_id' => 'ID_' . $uniqueId,
            'gross_amount' => $total,
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
            'email' => $userData['user']->email,
            'phone' => $userData['customer']->phone,
        ];

        // Detail alamat pengiriman
        $shipping_address = [
            'first_name' => $userData['customer']->first_name,
            'last_name' => $userData['customer']->last_name,
            'phone' => $userData['customer']->phone,
            'email' => $userData['user']->email,
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
    public function finish(Request $request)
    {
        // Mengambil data diri user yang sedang login
        $userData = $this->getUserData($request);

        $result = json_decode($request->input('result-data'), true);

        // Mengambil ongkir dan jenis kurir
        $deliveryCost = $request->input('delivery-cost');
        $deliveryService = $request->input('delivery-service');

        if (array_key_exists('pdf_url', $result)) {
            $url = $result['pdf_url'];
        } else {
            $url = '';
        }

        // Mendapatkan data produk dan cart item
        list($products, $cartItems) = Cart::getProductsAndCartItems();

        // Membuat orde data
        $orderData = [
            'total_price' => $result['gross_amount'],
            'status' => $result['transaction_status'],
            'created_by' => $userData['user']->id,
            'updated_by' => $userData['user']->id,
        ];
        $order = Order::create($orderData);

        // Membuat Order Item
        foreach ($products as $product) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $cartItems[$product->id]['quantity'],
                'unit_price' => $product->price
            ]);
        }

        // Membuat data payment
        $paymentData = [
            'order_id' => $order->id,
            'transaction_id' => $result['transaction_id'],
            'total_price' => $result['gross_amount'],
            'transaction_status' => $result['transaction_status'],
            // 'transaction_status' => PaymentStatus::Pending->value,
            'serial_number' => $result['order_id'],
            'payment_type' => $result['payment_type'],
            'pdf_url' => $url,
            'delivery_cost' => (int)$deliveryCost,
            'delivery_service' => $deliveryService
        ];

        if ($result['payment_type'] == 'bank_transfer') {
            $paymentData['payment_code'] = $result['va_numbers'][0]['va_number'];
        } else {
            $paymentData['payment_code'] = '';
        }

        Payment::create($paymentData);

        // Hapus item pada keranjang
        CartItem::where(['user_id' => $userData['user']->id])->delete();

        return redirect()->route('home')->with("success", "Order Created");
    }

    // Notifikasi Midtrans
    public function notification()
    {
        \Midtrans\Config::$serverKey    = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;

        try {
            $notif = new \Midtrans\Notification();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challange') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    Payment::where('serial_number', $order_id)->update(['transaction_status' => 'Challenge by FDS']);
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    Payment::where('serial_number', $order_id)->update(['transaction_status' => 'Success']);
                }
            }
        } else if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            Payment::where('serial_number', $order_id)->update(['transaction_status' => 'Settlement']);
        } else if ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            Payment::where('serial_number', $order_id)->update(['transaction_status' => 'Pending']);
        } else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            Payment::where('serial_number', $order_id)->update(['transaction_status' => 'Denied']);
        } else if ($transaction == 'expire') {
            // TODO set payment status in merchant's database to 'expire'
            Payment::where('serial_number', $order_id)->update(['transaction_status' => 'Expire']);
        } else if ($transaction == 'cancel') {
            // TODO set payment status in merchant's database to 'Denied'
            Payment::where('serial_number', $order_id)->update(['transaction_status' => 'Canceled']);
        }

        return response()->json(['order_id' => $order_id, 'transaction_status' => $transaction]);
    }

    // Fungsi untuk mendapatkan data keranjang
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
        return 'Rp ' . number_format($total, 2, ',', '.');
    }

    // Fungsi untuk mendapatkan ongkir dan kurir 
    private function getDeliveryCosts($customerAddress)
    {
        // Mengirimkan request ke API Raja ongkir
        $res = Http::withHeaders([
            'key' => env('RAJAONGKIR_API_KEY'),
        ])->post('https://api.rajaongkir.com/starter/cost', [
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
