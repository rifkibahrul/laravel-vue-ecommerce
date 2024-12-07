<?php

namespace App\Http\Controllers;

use App\Helpers\Cart;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    // Metode untuk menampilkan halamn keranjang
    public function index()
    {
        // Ambil semua item pada keranjang (dari DB atau cookie) menggunakan helper
        $cartItems = Cart::getCartItems();

        // Ambil semua 'product_id' dari item keranjang untuk mengambil detail produk dari DB
        $ids = Arr::pluck($cartItems, 'product_id');

        // Ambil data produk dari DB berdasarkan 'product_id' yang ada di keranjang
        $products = Product::query()->whereIn('id', $ids)->get();

        // Mengubah array item ke keranjang menjadi asosiasi dengan 'product_id' sebagai kunci
        $cartItems = Arr::keyBy($cartItems, 'product_id');
        $total = 0;

        // Loop menghitung total harga
        foreach ($products as $product) {
            // Menambahkan harga produk yang dikalikan dengan kuantitasnya ke total
            $total += $product->price * $cartItems[$product->id]['quantity'];
        }

        // Mengembalikan tampilan halaman ke index keranjang dengan data 
        return view('cart.index', compact('cartItems', 'products', 'total'));
    }

    // Metode untuk menambah produk ke keranjang
    public function add(Request $request, Product $product)
    {
        // Mendapatkan jumlah kuantitasnya yang akan ditambahkan, defaultnya adalah 1
        $quantity = $request->post('quantity', 1);

        // Mendapatkan data pengguna yang sedang login
        $user = $request->user();
        if ($user) {
            // Cari item keranjang bebrdasarkan 'user_id' dan 'product_id'
            $cartItem = CartItem::where(['user_id' => $user->id, 'product_id' => $product->id])->first();

            // Jika item sudah dikeranjang
            if ($cartItem) {

                // Tambahkan kuantitas ke item keranjang
                $cartItem->quantity += $quantity;

                // Simpan ke DB
                $cartItem->update();
            } else {
                // Jika item bbelum ada di keranjang, buat data baru untuk item keranjang
                $data = [
                    'user_id' => $request->user()->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                ];

                // Tambahkan item baru ke DB
                CartItem::create($data);
            }
            // Kembalikan jumlah total item di keranjang sebagai respon
            return response([
                'count' => Cart::getCartItemsCount()
            ]);
            
        } else {        // Jika pengguna tidak login

            // Ambil data keranjang dari cookie dan decode ke array
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
            
            // Inisialisasi variabel untuk memeriksa apakaj produk sudah ada di keranjang
            $productFound = false;

            // Loop melalui item di keranjang cookie
            foreach ($cartItems as $item) {
                if ($item['product_id'] === $product->id) {
                    // Tambahkan kuantitas jika produk ditemukan
                    $item['quantity'] += $quantity;
                    $productFound = true;
                    break;
                }
            }

            // Jika produk belum ada dikeranjang
            if (!$productFound) {
                // Tambahkan produk baru ke array keranjang
                $cartItems[] = [
                    'user_id' => null,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ];
            }

            // Simpan kembali data keranjang ke cookie dengan durasi 30 hari
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);

            // Kembalikan jumlah total item di keranjang sebagai respon 
            return response(['count' => Cart::getCountFromItems($cartItems)]);
        }
    }

    // Metode untuk menghapus produk dari keranjang
    public function remove(Request $request, Product $product)
    {
        // Mendapatkan data pengguna yang sedang login
        $user = $request->user();

        if ($user) {
            // Jika pengguna login, cari item keranjang berdasarkan 'user_id' dan 'product_id'
            $cartItem = CartItem::query()->where(['user_id' => $user->id, 'product_id' => $product->id])->first();
            
            if ($cartItem) {
                $cartItem->delete();
                // Hapus item dari DB
            }

            // Kembalikan jumlah total item di keranjang sebagai respon
            return response([
                'count' => Cart::getCartItemsCount(),
            ]);
        } else {
            // Jika belum login, ambil data keranjang dari cookie dan decode ke array
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
            foreach ($cartItems as $i => $item) {

            // Loop melalui item di keranjang cookie
                if ($item['product_id'] === $product->id) {
                    array_splice($cartItems, $i, 1);
                    // Hapus item dari array jika ditemukan
                    break;
                }
            }
            // Simpan kembali data keranjang ke cookie dengan durasi 30 hari
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);

            // Kembalikam jumlah total item di keranjang sebagai respon
            return response(['count' => Cart::getCountFromItems($cartItems)]);
        }
    }

    // Metode untuk memperbarui kuantitas produk di keranjang
    public function updateQuantity(Request $request, Product $product)
    {
        // Mendapatkan kuantitas baru dari request
        $quantity = (int)$request->post('quantity');
        
        $user = $request->user();
        if ($user) {
            // Jika sudah login, perbarui kuantitas di DB
            CartItem::where(['user_id' => $request->user()->id, 'product_id' => $product->id])->update(['quantity' => $quantity]);

            // Kembalikan jumlah total item di keranjang sebagai respon
            return response([
                'count' => Cart::getCartItemsCount(),
            ]);
        } else {
            // Jika belum login, Ambil data keranjang dari cookie dan decode ke array.
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);
            foreach ($cartItems as &$item) {
                if ($item['product_id'] === $product->id) {
                    // Perbarui kuantitas item di keranjang
                    $item['quantity'] = $quantity;
                    break;
                }
            }

            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);

            return response(['count' => Cart::getCountFromItems($cartItems)]);
        }
    }
}
