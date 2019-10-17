<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    // переопределение скрытого свойства
    protected $table = 'peoples';
}
