<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dps extends Model
{
    protected $table;
    protected $fillable = ['accountNo', 'monthlyamount', 'numberofyear'];
}
