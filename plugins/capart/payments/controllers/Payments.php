<?php namespace Capart\Payments\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Capart\Orders\Models\Order;
use Capart\Orders\Models\OrderProduct;
use Capart\Payments\Models\Payment;
use Capart\Products\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class Payments extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController'    ];

    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Capart.Payments', 'payments');
    }

    public function paymentOrderCallBack(Request $request)
    {
        $params = $request->all();
        tracelog('callback');
        traceLog($request->all());
        $PaymentOrderID = Arr::get($params, 'body.order_id');
        if (!$PaymentOrderID) {
            traceLog('cannot get payment order ID');
            return response(['message' => 'cannot get payment order ID'], 400);
        }


//         additional check of status (if fake request)
        $PaymentDetails = (new Payment)->paymentDetails($PaymentOrderID);
        $Status = Arr::get($PaymentDetails, 'order_status.key');
        $OrderID = Arr::get($PaymentDetails, 'external_order_id');




        if ($Status != 'completed') {
            Payment::where('payment_order_id', $PaymentOrderID)->first()->update(['status' => $Status, 'reject_reason' => Arr::get($PaymentDetails, 'reject_reason')]);
            traceLog('Not completed order');
            traceLog($PaymentDetails);
            return response(['message' => 'Not completed order'], 400);
        }

        Payment::where('payment_order_id', $PaymentOrderID)->first()->update(['status' => $Status]);
        Order::find($OrderID)->update(['status_id' => 1]);
        $OrderProducts = OrderProduct::where('order_id', $OrderID)->get()->toArray();

        foreach ($OrderProducts AS $orderProduct) {
            Product::where('id', Arr::get($orderProduct, 'product_id'))
                ->update([
                    'quantity' => DB::raw('GREATEST(quantity - '.Arr::get($orderProduct, 'quantity').', 0)')
                ]);
        }


        return response(['message' => 'paid'], 200);


    }
}
