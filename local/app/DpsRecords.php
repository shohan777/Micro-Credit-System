<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DpsRecords extends Model
{
    protected $table;
    protected $fillable = ['accountNo', 'trnxNo', 'terms', 'date', 'nextdate', 'late', 'monthlyamount', 'monthlyinterest', 'monthlytotal'];
}
