<?php namespace Capart\Products\Models;

use Capart\Categories\Models\Category;
use Illuminate\Support\Facades\Cookie;
use Model;
use Winter\Storm\Database\Traits\Sortable;

/**
 * Model
 */
class Product extends Model
{
    use \Winter\Storm\Database\Traits\Validation;
    use Sortable;

    public $attachMany = [
        'photos'   =>   \System\Models\File::class
    ];



    /**
     * @var string The database table used by the model.
     */
    public $table = 'capart_products_';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    public $jsonable = [];

    public $belongsTo = [
        'Category'    => [Category::class, 'key' => 'category_id', 'otherKey' => 'id'],
        'Color'       => [Colors::class, 'key' => 'color_id', 'otherKey' => 'id']
    ];

    public function scopeBestSeller($query, $value)
    {
         return $query->where('best_seller', 1)->where('status_id', 1);
    }

    public function scopeActive($query)
    {
        return $query->where('status_id', 1);
    }

    public function scopeCategory($query, $value)
    {
        return $query->where('category_id', $value);
    }

    public function scopeColor($query, $value)
    {
        return $query->where('color_id', $value);
    }

    public function scopeCartProducts($query, $value)
    {
        $CartItems = isset($_COOKIE['cart_items']) ? json_decode($_COOKIE['cart_items'], true) : [];
        $CartItems = array_keys($CartItems);
        return $query->whereIn('id', $CartItems);
    }

    public function scopekeyword($query, $value)
    {
        return $query->where('title', 'like', '%'.$value.'%');
    }

}
