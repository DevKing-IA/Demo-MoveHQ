<?php

namespace MovehqApp\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string name
 * @property string description
 *
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 *
 */
class Product extends AbstractModel
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    protected $hidden = [];
}
