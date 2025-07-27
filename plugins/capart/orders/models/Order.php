<?php namespace Capart\Orders\Models;

use Model;

/**
 * Model
 */
class Order extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    

    /**
     * @var string The database table used by the model.
     */
    public $table = 'capart_orders_';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    protected $fillable = [
        'first_name', 'last_name', 'location_id', 'id_number', 'address', 'phone_number', 'second_phone_number', 'comment', 'price', 'delivery_price', 'total_price', 'status_id'
    ];
    
    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    public $jsonable = [];

    public $belongsTo = [
        'Location'    => [Location::class, 'key' => 'location_id', 'otherKey' => 'id']

    ];

    public $hasMany = [
        'OrderProducts' => [
            'Capart\Orders\Models\OrderProduct',
            'table' => 'capart_orders_products',
            'order' => 'id'
        ]
    ];

//    public function OrderProducts()
//    {
//        return $this->hasMany(OrderProduct::class);
//    }
}
