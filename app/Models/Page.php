<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    // в закрытом свойстве $fillable указываем список полей, разрешенных к автозаполнению
    protected $fillable = ['name','text','alias','images'];
}
