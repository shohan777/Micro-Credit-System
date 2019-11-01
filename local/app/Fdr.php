<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fdr extends Model
{
    protected $table;
    protected $fillable = ['accountNo', 'fdrno', 'tranxid', 'fdramount', 'totalamount', 'dueamount', 'profitrate', 'fdrterms', 'monthlyamount', 'numberofyear', 'serviceenddate', 'nextwithdrawdate', 'fdrpermission', 'fdrstatus'];
}
