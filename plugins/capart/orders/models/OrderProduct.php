<?php namespace Capart\Orders\Models;

use Model;

/**
 * Model
 */
class OrderProduct extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'capart_orders_products';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    protected $fillable = ['product_id', 'quantity', 'price', 'title', 'order_id'];
}
