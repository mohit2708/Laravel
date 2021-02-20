<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee', function (Blueprint $table) {
            $table->id();
            $table->string('f_name', 255)->nullable();
            $table->string('l_name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('gender', 255)->nullable();
            $table->string('m_number', 255)->nullable();
            $table->string('language', 255)->nullable();            
            $table->string('country', 255)->nullable();            
            $table->string('state', 255)->nullable();            
            $table->string('city', 255)->nullable();            
            $table->text('description');
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
        Schema::dropIfExists('employee');
    }
}
