<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // checks id the user is logged in and which user acess they have
        $group_ids = Auth::check() ? Auth::user()->getGroups() : [1];

        // pulls the product information from the database
        $product_data = Product::withPrices()->get();

        // takes the product information retrieved and passes it to the views or frontend
        return view('pages.testing.productspage', compact('product_data'));
    }
}
