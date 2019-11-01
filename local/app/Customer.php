<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['accountNo', 'balance', 'fullname', 'fathername', 'mothername', 'presentaddress', 'permanentaddress', 'occupation', 'nationality', 'nidno', 'age','mobile', 'introducername', 'introducerpermanentaddress', 'nomname', 'nomfathername', 'nommothername', 'nompresentaddress', 'nompermanentaddress', 'nomoccupation', 'relationship', 'nomnidno', 'nomage', 'nommobile', 'field', 'opening_date'];
}
