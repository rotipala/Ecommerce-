<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        // checks id the user is logged in and which user acess they have
        $group_ids = Auth::check() ? Auth::user()->getGroups() : [1];


        $data = Product::singleProduct($id)->withPrices()->get()->first();


        return view('pages.testing.detailspage', compact('data'));
    }
}
