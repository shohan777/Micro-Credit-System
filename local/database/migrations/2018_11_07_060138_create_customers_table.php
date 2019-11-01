<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('accountNo');
            $table->string('fullname');
            $table->string('fathername');
            $table->string('mothername');
            $table->string('presentaddress');
            $table->string('permanentaddress');
            $table->string('occupation');
            $table->string('nationality');
            $table->string('nidno');
            $table->integer('age');
            $table->integer('mobile');
            $table->string('introducername');
            $table->string('introducerpermanentaddress');
            $table->string('nomname');
            $table->string('nomfathername');
            $table->string('nommothername');
            $table->string('nompresentaddress');
            $table->string('nompermanentaddress');
            $table->string('nomoccupation');
            $table->string('relationship');
            $table->string('nomnidno');
            $table->integer('nomage');
            $table->integer('nommobile');
            $table->integer('status')->default('1');
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
        Schema::dropIfExists('customers');
    }
}
