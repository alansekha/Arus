<?php

namespace Modules\Queue\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class user_counter extends Model
{

    use SoftDeletes;
    protected $fillable = ['user_id', 'counter_id', 'queue_number', 'is_processed', 'date'];
    protected $dates = ['deleted_at'];
}
