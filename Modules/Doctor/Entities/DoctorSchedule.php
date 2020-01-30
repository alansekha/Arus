<?php

namespace Modules\Doctor\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class doctor_schedule extends Model
{
    use SoftDeletes;

    protected $fillable = ['doctor_id', 'day', 'time'];
    protected $dates = ['deleted_at'];
}
