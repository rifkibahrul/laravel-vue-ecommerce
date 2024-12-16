<?php

namespace App\Http\Controllers;

use App\Helpers\Cart;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    function get_token(Request $request)
    {
        \Midtrans\Config::$serverKey    = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;

        list($products, $cartItems) = Cart::getProductsAndCartItems();

        // Ambi total harga dari request 
        $cartTotal = $request->input('cart_total');

        $transactionDetails = [
            'order_id' => 'ID_' . rand(),
            'gross_amount' => $cartTotal
        ];
        // dd($transactionDetails);

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
        // dd($itemDetails);

        $customer = $request->user()->customer;
        
        $customerDetails = [
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'phone' => $customer->phone,
        ];
        
        $customerAddress = $customer->customerAddress;
        $shippingAdress = [
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'phone' => $customer->phone,
            'address' => $customerAddress->address,
            'city_id' => $customerAddress->city_id,
            'province_id' => $customerAddress->province_id,
            'zipcode' => $customerAddress->zipcode,
        ];

        $customerDetails['shippingAdress'] = $shippingAdress;

        $transaction = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
        ];
        
        // Mendapatkan token transkasi
        // $snapToken = \Midtrans\Snap::getSnapToken($transaction);
        // return response()->json(['token' => $snapToken]);

        // Redirect ke halaman midtrans
        $snapResponse = \Midtrans\Snap::createTransaction($transaction);

        return redirect()->to($snapResponse->redirect_url);
    }

    // function 
}
