<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $table;
    protected $fillable = ['loanno', 'loanapplytranxid', 'accountNo', 'loandate', 'loanamount', 'loantotal', 'loandue', 'loaninterest', 'loanterms', 'loanending', 'loanfailcount', 'loanstatus', 'loanpermission'];
}
