<?php

namespace MovehqApp\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpDocs\Eloquent;

/**
 * @mixin Eloquent
 *
 * Properties
 * @property int $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class AbstractModel extends Model
{
    use HasFactory;
}
