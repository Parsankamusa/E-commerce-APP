<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cart; 
class WishlistController extends Controller
{
            // listing the products added to the wishlist
            public function getWishlistedProducts()
        {
            $items = Cart::instance("wishlist")->content();
            return view('wishlist',['items'=>$items]);
        }
            //  adding the product to the wishlist
              public function addProductsToWishList(Request $request)
                {
                    Cart::instance("wishlist")->add($request->id, $request->name,1, $request->price)->associate("App\Models\Product");
                    return response()->json(['status'=>200, 'message'=>'successfully added to the wish list']);
                }
            //   removing a product in a wishlist
                public function removeProductFromWishlist(Request $request)
                {
                    $rowId = $request->rowId;
                    Cart::instance("wishlist")->remove($rowId);
                    return redirect()->route('wishlist.list');
                }
                // clearing the wishlist
                public function clearWishlist()
                {
                    Cart::instance("wishlist")->destroy();
                    return redirect()->route('wishlist.list');
                }
        //  moving products from wish list to cart
                public function moveToCart(Request $request)
                    {
                        $item = Cart::instance('wishlist')->get($request->rowId);
                        Cart::instance('wishlist')->remove($request->rowId);
                        Cart::instance('cart')->add($item->model->id, $item->model->name, 1, $item->model->regular_price)->associate('App\Models\Product');
                        return redirect()->route('wishlist.list');
                    }
}
