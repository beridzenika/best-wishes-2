<?php namespace Capart\Orders\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Capart\Orders\Models\Order;
use Capart\Orders\Models\Location;
use Capart\Orders\Models\OrderProduct;
use Capart\Payments\Models\Payment;
use Capart\Products\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use skillset\Marketplace\Models\Application;

class Orders extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController', 'Backend\Behaviors\RelationController'  ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Capart.Orders', 'orders');
    }


    public function paymentOrder(Request $request)
    {
        $rules =  [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'location_id' => 'required|exists:capart_orders_locations,id', // Validate location_id against locations table
            'id_number' => 'required|digits:11',
            'address' => 'required|string|max:255',
            'phone_number' => 'required|regex:/^\+?\d{1,3}(\s?\d{2,3}){2,5}$/',
            'second_phone_number' => 'nullable',
            'comment' => 'nullable|string|max:500'
        ];

        $data = $request->only(array_keys($rules));

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response(
                $validator->getMessageBag(),
                408
            );
        }

        $validatedData = $request->validate($rules);
        $OrderPorducts = $this->getOrderProducts();
        if (empty($OrderPorducts)) {
            return false;
        }
        $locData = Location::find($validatedData['location_id'])->toArray();
        $validatedData['price'] = array_sum(array_column($OrderPorducts, 'price'));
        $validatedData['delivery_price'] = Arr::get($locData, 'delivery_price');
        $validatedData['total_price'] =$validatedData['price'] + $validatedData['delivery_price'];
        $Order = (new Order($validatedData));
        $Order->save();
        $this->saveOrderProducts($OrderPorducts, $Order->id);
        $Payment = (new Payment)->makePayment($Order->id, $OrderPorducts, $validatedData['delivery_price'], $validatedData['total_price']);
        setcookie('cart_items', json_encode([]), time() + (7 * 24 * 60 * 60), "/");
        return Redirect::to(Arr::get($Payment, '_links.redirect.href'));
//        redirect()->to(Arr::get($Payment, 'redirect'));
    }

    private function getOrderProducts()
    {
        $CartItems = Cookie::get('cart_items') ? json_decode(Cookie::get('cart_items'), true) : [];
        if (empty($CartItems)) {
            return [];
        }
        return Product::whereIn('id', array_keys($CartItems))->get()->map(function($item) use ($CartItems){
            $item = $item->toArray();
            $quantity = Arr::get($CartItems, Arr::get($item, 'id'));
            return [
                'product_id' => Arr::get($item, 'id'),
                'quantity'   => $quantity,
                'price'      => $quantity * Arr::get($item, 'price'),
                'title'      => Arr::get($item, 'title'),
            ];
        })->toArray();
    }

    private function saveOrderProducts(array $OrderPorducts, $OrderID)
    {
        foreach ($OrderPorducts AS $orderProduct) {
            $orderProduct['order_id'] = $OrderID;
            (new OrderProduct($orderProduct))->save();
        }
    }
}
