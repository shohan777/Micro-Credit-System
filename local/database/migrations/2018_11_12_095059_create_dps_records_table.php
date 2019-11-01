<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDpsRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dps_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('accountNo');
            $table->integer('trnxNo');
            $table->string('terms');
            $table->date('date');
            $table->date('nextdate');
            $table->integer('late');
            $table->integer('monthlyamount');
            $table->float('monthlyinterest');
            $table->float('monthlytotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dps_records');
    }
}
