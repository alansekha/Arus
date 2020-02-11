<?php

namespace Modules\Queue\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Counter extends Model
{

    use SoftDeletes;

    protected $fillable = ['name'];
    protected $dates = ['deleted_at'];
}
