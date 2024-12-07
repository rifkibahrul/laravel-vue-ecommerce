<?php

namespace App\Helpers;

use App\Models\CartItem;

class Cart
{
    // Method untuk menampilkan jumlah item di keranjang pada navbar/navigation 
    public static function getCartItemsCount(): int
    {
        // Mendapatkan request data dari user saat ini
        $request = \request();

        // Mengambil data user dari request 
        $user = $request->user();

        // Memeriksa apakah pengguna sudah login
        if ($user) {

            // Mengambil data item dari keranjang milik user dari DB berdasarkan 'user_id' 
            // dan menghitung total 'quantity' dari semua item
            return CartItem::where('user_id', $user->id)->sum('quantity');
        } else {
            // Ambil item dari cookie jika user belum login
            $cartItems = self::getCookieCartItems();

            // Menghitung jumlah total item dalam cart berdasarkan 'quantity' dari item di cookie 
            return array_reduce(
                $cartItems,         // Array item cart pada cookie
                fn($carry, $item) => $carry + $item['quantity'],        // Menjumlahkan 'quantity' setiap item dalam array ke total
                0       // Nilai awal jumlah total
            );
        }
    }

    // Metode untuk mendapatkan array item dari keranjang belanja
    public static function getCartItems()
    {
        // Mendapatkan request data dari user saat ini
        $request = \request();

        // Mengambil informasi user dari request 
        $user = $request->user();

        // Memeriksa apakah pengguna sudah login
        if ($user) {
            /*
             * Perintah untuk mengembalikan nilai dalam bentuk asosiatif array
             * Ambil semua item dari DB untuk user saat ini
             * lalu ubah format data menjadi array asosiatif dengan 'product_id' dan 'user_id'
            */
            return CartItem::where('user_id', $user->id)->get()->map(
                fn($item) => ['product_id' => $item->product_id, 'quantity' => $item->quantity]
            );
        } else {
            // Jika belum login ambil dari cookie
            return self::getCookieCartItems();
        }
    }

    // Metode untuk mengambil item keranjang dari cookie
    public static function getCookieCartItems()
    {
        // Mendapatkan request data dari user saat ini
        $request = \request();

        // Mengambil data dari cookie 'cart_items' dan men-dekode-nya dari JSON ke array PHP
        // Jika cookie tidak ditemukan, gunakan array kosong sebagai default
        return json_decode($request->cookie('cart_items', '[]'), true);
    }

    // Metode untuk menghitung total item dari array item keranjang (bisa dari cookie atau DB)
    public static function getCountFromItems($cartItems)
    {
        // Menghitung jumlah total item dalam cart berdasarkan 'quantity' dari item di cookie 
        return array_reduce(
            $cartItems,         // Array item di keranjang
            fn($carry, $item) => $carry + $item['quantity'],        // Menambhakan quantity tiap item ke total
            0       // Nilai awal jumlah total
        );
    }

    // Metode untuk memindahkan item keranjang dari cookie ke DB
    public static function moveCartItemsIntoDb()
    {
        // Mendapatkan request data dari user saat ini
        $request = \request();

        // Mengambil item dari cookie
        $cartItems = self::getCookieCartItems();

        // Mengambil item keranjang dari DB untuk user saat ini dan mengelompokan berdasarkan 'product_id'
        // keyBy akan mengubah koleksi menjadi array dengan 'product_id' sebagai key  
        $dbCartItems = CartItem::where(['user_id' => $request->user()->id])->get()->keyBy('product_id');

        $newCartItems = [];
        foreach ($cartItems as $cartItem) {
            if (isset($dbCartItems[$cartItem['product_id']])) {
                continue;
            }

            $newCartItems = [
                'user_id' => $request->user()->id,
                'product_id' => $cartItem['product_id'],
                'quantity' => $cartItem['quantity'],
            ];
        }

        if (!empty($newCartItems)) {
            CartItem::insert($newCartItems);
        }
    }
}
