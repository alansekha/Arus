<?php

namespace Modules\Doctor\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class doctor extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['user_id', 'doctor_category_id'];
    protected $dates = ['deleted_at'];

}
