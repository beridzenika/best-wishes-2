<?php namespace Capart\Payments\Models;

use Model;
use October\Rain\Support\Arr;

/**
 * Model
 */
class Payment extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'capart_payments_';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    protected $fillable = [
        'payment_hash','payment_order_id','order_id','status','price','ip','payment_type', 'reject_reason'
    ];




    public function makePayment($OrderID, $OrderProducts, $DeliveryPrice, $TotalPrice)
    {
//        $TotalPrice = round($TotalPrice, 2);
        $Request = [
            "callback_url"          => config('app.url')."/payment-order-callback",
            "external_order_id"     => $OrderID,
            "purchase_units"        => [
                'currency'      => 'GEL',
                'total_amount'  => $TotalPrice,
                'delivery'      => [
                    'amount'    => $DeliveryPrice,
                ],
                'basket'        => []
            ],
            'redirect_urls'         => [
                'fail'      => config('app.url')."/payment-response?order_id=".$OrderID.'&response=0',
                'success'   => config('app.url')."/payment-response?order_id=".$OrderID.'&response=1',
            ],
//            'payment_method' => 'card'
        ];

        foreach ($OrderProducts as $product)
        {
            $Request['purchase_units']['basket'][] = [
                "quantity" => Arr::get($product, 'quantity'),
                "unit_price" => Arr::get($product, 'price'),
                "product_id" => Arr::get($product, 'product_id'),
            ];
        }

        $Response = $this->sendCurl(config('order.payments.bog.order_url'), 'POST', [
            'Authorization: Bearer '.$this->getToken(),
            'Content-Type: application/json',
            'Accept-Language: ka'
        ], $Request, 'json');

        self::create([
            'payment_order_id'     => Arr::get($Response, 'id'),
            'order_id'             => $OrderID,
            'status'               => 'created',
            'price'                => $TotalPrice,
            'ip'                   => $_SERVER['REMOTE_ADDR']
        ]);

        return $Response;
    }

    public function paymentDetails($PaymentOrderID)
    {
        return $this->sendCurl(sprintf(config('order.payments.bog.order_details'), $PaymentOrderID), 'GET', [
            'Authorization: Bearer '.$this->getToken(),
            'Content-Type: application/json',
            'Accept-Language: ka'
        ]);
    }
    public function getToken()
    {
        $Response = $this->sendCurl(config('order.payments.bog.auth_url'), 'POST', [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Basic '.base64_encode(config('order.payments.bog.client_id').':'.config('order.payments.bog.secret_key'))
        ], [
            'grant_type'  => 'client_credentials',
        ]);
        if (!$Response) {
            return false;
        }
        return Arr::get($Response, 'access_token');
    }

    public function sendCurl($url, $requestType = 'GET', $headers = [], $data = [], $dataType = 'form-data')
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL,$url);
        if ($requestType == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $dataType == 'json' ? json_encode($data) : http_build_query($data));
        }
        tracelog($dataType == 'json' ? json_encode($data) : http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close ($ch);
        if (!$response) {
            return false;
        }
        if (!$Json = json_decode($response, true)) {
            return false;
        }
        return $Json;
    }


}
