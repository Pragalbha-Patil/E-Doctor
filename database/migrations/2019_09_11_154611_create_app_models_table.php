<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('uid')->unsigned();
            $table->string('uname',50);
            $table->string('uemail',150);
            $table->bigInteger('umobile');
            $table->string('ugender',10);
            $table->date('adate');
            $table->time('atime');
            $table->string('amount')->default(100)->nullable();
            $table->string('atoken')->nullable();
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
        Schema::dropIfExists('appointments');
    }
}
