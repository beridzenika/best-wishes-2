<?php namespace Capart\Offers\Models;

use Model;

/**
 * Model
 */
class Offer extends Model
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
    public $table = 'capart_offers_';

    public $attachMany = [
        'photos'   =>   \System\Models\File::class
    ];

    public function scopeMainPage($query, $value)
    {
        return $query->where('main_page', 1)->where('status_id', 1);
    }

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var array Attribute names to encode and decode using JSON.
     */
    public $jsonable = [];
}
