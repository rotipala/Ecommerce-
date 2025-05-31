<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Displays all the produts the user adds to the cart
     */
    public function index()
    {
        $group_ids = Auth::check() ? Auth::user()->getGroups() : [1];

        $user = Auth::user();

        $cart_data = $user->products()->withPrices()->get();

        if ($cart_data->isEmpty()) {
            return redirect()->route('cart.index')->with('message', 'Your cart is empty. Please select an item to checkout.');
        }

        $cart_data->calculateSubtotal();

        return view('pages.testing.checkoutpage', compact('cart_data'));
    }
}
