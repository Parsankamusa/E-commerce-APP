<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart; 
class WishlistController extends Controller
{
            public function getWishlistedProducts()
        {
            $items = Cart::instance("wishlist")->content();
            return view('wishlist',['items'=>$items]);
        }

                public function addProductsToWishList()
                {
                    Cart::instance("wishlist")->add(request()->name, request()->quantity, request()->price)->associate("App\Models\Product");
                    return view('wishlist', ['items' => $items]);
                }
                
            
}
