<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{
    public function index()
    {
        return view('cart');
    }//

    public function create_cart(Request $key)
    {
        $cart = new Cart();

        $cart->user_id = $key->get('user_id');
        $cart->article_title = $key->get('product_id');
        $cart->article_price = $key->get('price');
        $cart->item_quantity = 1;
        $cart->save();

        return redirect()->back();
    }

    public function display_cart()
    {
        $display_cart = DB::table('cart')->where('user_id', Auth::user()->id)->get();
        return view('cart',['display_cart' => $display_cart]);
    }

    public function update_quantity(Request $key)
    {
        $product = cart::find($key->get('id'));

        if ($key->get('update_quantity') != NULL) {
            $product->title = $key->get('update_quantity');
        }
    }

    public function delete_cart(Request $key)
    {
        cart::select('select * from cart')->where('id', '=', $key->get('id'))->delete();
        return redirect()->back();

    }
}
