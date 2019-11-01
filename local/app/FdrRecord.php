<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FdrRecord extends Model
{
    protected $table;
    protected $fillable = ['accountNo', 'fdrno', 'trnxNo', 'fdrterms', 'withdrawdate', 'nextdate', 'monthlyamount', 'paymentstatus'];
}
