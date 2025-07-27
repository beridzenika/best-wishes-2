<?php namespace Capart\Cart\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class Carts extends Controller
{
    public $implement = [    ];
    
    public function addToCart(Request $request)
    {
        $this->addProductToCard($request->post('product_id'), $request->post('quantity', 1));
        $From = explode('/', $request->post('from'));
        if ($From[0] == 'shop') {
            return Redirect::to($request->post('from').'/?cat_id='.$request->post('cat_id').'&color_id='.$request->post('color_id').'&sort='.$request->post('sort'));
        }
        return Redirect::to($request->post('from').'/'.$request->post('product_id'));
    }

    public function buyNow(Request $request)
    {
        $this->addProductToCard($request->post('product_id'), $request->post('quantity', 1));
        return Redirect::to('/cart');
    }

    public function removeFromCart(Request $request)
    {
        $CartItems = Cookie::get('cart_items') ? json_decode(Cookie::get('cart_items'), true) : [];
        if (isset($CartItems[$request->product_id])) {
            unset($CartItems[$request->product_id]);
        }
        setcookie('cart_items', json_encode($CartItems), time() + (7 * 24 * 60 * 60), "/");
        return Redirect::to('/cart');
    }

    public function updateItemQuantity(Request $request)
    {
        $CartItems = Cookie::get('cart_items') ? json_decode(Cookie::get('cart_items'), true) : [];
        if (isset($CartItems[$request->product_id]) && $request->quantity > 0) {
            $CartItems[$request->product_id] = $request->quantity;
        }
        setcookie('cart_items', json_encode($CartItems), time() + (7 * 24 * 60 * 60), "/");
        return Redirect::to('/cart');
    }

    private function addProductToCard($product_id, $quantity)
    {
        $CartItems = Cookie::get('cart_items') ? json_decode(Cookie::get('cart_items'), true) : [];
        $exists = false;

        foreach ($CartItems AS $key => &$value) {
            if ($key == $product_id) {
                $value += $quantity;
                $exists = true;
                break;
            }
        }
        if (!$exists) {
            $CartItems[$product_id] = $quantity;
        }
        setcookie('cart_items', json_encode($CartItems), time() + (7 * 24 * 60 * 60), "/");
    }
}
