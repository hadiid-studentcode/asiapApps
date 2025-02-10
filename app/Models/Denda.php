<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Denda extends Model
{
    protected $table = 'denda';

    protected $primaryKey = 'id';

    protected $guarded = ['id'];
}
