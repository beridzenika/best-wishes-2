<?php namespace Capart\Products\Models;

use Model;

/**
 * Model
 */
class Colors extends Model
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
    public $table = 'capart_products_colors';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    public $jsonable = [];


    public function scopeActive($query)
    {
        return $query->where('status_id', 1);
    }
}
