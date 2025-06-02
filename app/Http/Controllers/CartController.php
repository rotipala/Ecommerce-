<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Displays all the produts the user adds to the cart
     */
    public function index()
    {
        //checks to see if the user is logged in
        $group_ids = Auth::check() ? Auth::user()->getGroups() : [1];

        //gets who the user is
        $user = Auth::user();

        //gets all the products that the user adds to the class
        $cart_data = $user->products()->withPrices()->get();

        //gets the total price of all the products in the cart
        $cart_data->calculateSubtotal();

        //returns the information to the front end
        return view('pages.default.cartpage', compact('cart_data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $request->product_id],
            ['quantity' => DB::raw('quantity + ' . $request->quantity), 'updated_at' => now()]
        );

        // redirect user to the cart page
        return redirect()->route('cart.index')->with('message', 'Product added to cart');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Cart::destroy($id);

        return redirect()->route('cart.index')->with('message', 'Product removed from cart');
    }

    /**
     * Add to cart from a differnet page
     */

    public function addToCartFromStore(Request $request)
    {
        Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $request->id],
            ['quantity' => DB::raw('quantity + ' . 1), 'updated_at' => now()]
        );

        // redirect user to the cart page
        return redirect()->route('cart.index')->with('message', 'Product added to cart');
    }
}
