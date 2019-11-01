<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $table;
    protected $fillable = ['holidayname', 'holidaystartdate', 'holidayenddate', 'holidaycount', 'holidayyear', 'holidaystatus', 'holidaytype', 'holidayremarks'];
}
