<?php namespace Database\Tester\Models;

use Model;

class User extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'database_tester_users';

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    /**
     * @var array Relations
     */
    public $hasOne = [
        'author' => [
            'Database\Tester\Models\Author',
        ]
    ];

    public $hasOneThrough = [
        'phone' => [
            'Database\Tester\Models\Phone',
            'through' => 'Database\Tester\Models\Author',
        ],
    ];

    public $attachOne = [
        'avatar' => 'System\Models\File'
    ];

    public $attachMany = [
        'photos' => 'System\Models\File'
    ];

}

class SoftDeleteUser extends User
{
    use \Winter\Storm\Database\Traits\SoftDelete;
}

class UserWithAuthor extends User
{
    public $hasOne = [
        'author' => ['Database\Tester\Models\Author', 'key' => 'user_id', 'delete' => true],
    ];
}

class UserWithSoftAuthor extends User
{
    public $hasOne = [
        'author' => ['Database\Tester\Models\SoftDeleteAuthor', 'key' => 'user_id', 'softDelete' => true],
    ];
}

class UserWithAuthorAndSoftDelete extends UserWithAuthor
{
    use \Winter\Storm\Database\Traits\SoftDelete;
}

class UserWithSoftAuthorAndSoftDelete extends UserWithSoftAuthor
{
    use \Winter\Storm\Database\Traits\SoftDelete;
}
