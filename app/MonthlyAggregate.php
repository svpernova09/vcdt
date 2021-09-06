<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonthlyAggregate extends Model
{
    protected $fillable = [
        'label',
        'data',
    ];
}
