<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $latestProducts = Product::where('published', '=', 1)->latest()->take(4)->get();

        return view('home', [
            "latestProducts" => $latestProducts
        ]);
    }
}
