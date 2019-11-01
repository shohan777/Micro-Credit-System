<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table;
    protected $fillable = ['accountNo', 'servicename', 'serviceno', 'status'];
}
