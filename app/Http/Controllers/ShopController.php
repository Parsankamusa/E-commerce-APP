<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 

class ShopController extends Controller
{
    public function index(Request $request)
{       
      $page = $request->query("page");
      $size = $request->query("size");
      if(!$page)
            $page = 1;
      if(!$size)
            $size = 12;

      $order = $request->query("order");
      if(!$order)
      $order = -1;
      $o_column = "";
      $o_order = "";
      switch($order)
      {
      case 1:
            $o_column = "created_at";
            $o_order = "DESC";
            break;
      case 2:
            $o_column = "created_at";
            $o_order = "ASC";
            break;
      case 3:
            $o_column = "regular_price";
            $o_order = "ASC";
            break;  
      case 4:
            $o_column = "regular_price";
            $o_order = "DESC";
            break;
      default:
            $o_column = "id";
            $o_order = "DESC";

      } 
    //   $brands = Brand::orderBy('name','ASC')->get();    
    //   return view('shop',['products'=>$products,'page'=>$page,'size'=>$size, 'order'=>$order,'products'=>$products, 'brands'=>$brands]);   
      $products = Product::orderBy('created_at','DESC')->orderBy($o_column,$o_order)->paginate($size);
      return view('shop',['products'=>$products,'page'=>$page,'size'=>$size, 'order'=>$order]);
}   
    public function productDetails($slug)
{
    $product = Product::where('slug', $slug)->first();

    // Check if the product exists
    if ($product === null) {
        // Handle the case where the product does not exist
        // For example, redirect to a 404 page or show an error message
        abort(404, 'Product not found.');
    }

    // Fetch related products
    $rproducts = Product::where('category_id', $product->category_id)
                        ->where('id', '!=', $product->id)
                        ->take(4) // Limit the number of related products
                        ->get();

    // Pass the products to the view
    return view('details', ['product' => $product, 'rproducts' => $rproducts]);
}

}
