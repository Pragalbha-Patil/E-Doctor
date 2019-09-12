<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_appointment_mapping', function (Blueprint $table) {
            $table->increments('rid'); //record id
            $table->string('dname');
            $table->date('date');
            $table->time('time');
            $table->string('status'); //either time slot is booked or not, 1 OR 0, anything!
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
        Schema::dropIfExists('doctor_models');
    }
}
