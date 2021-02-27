<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name',60)->nullable(false);
            $table->string('last_name',60)->nullable(false);
            $table->string('middle_name',60)->nullable(true);
            $table->string('address',120)->nullable(false);
            $table->foreignId('department_id')->nullable(false);
            $table->foreignId('city_id')->nullable(false);
            $table->foreignId('state_id')->nullable(false);
            $table->foreignId('country_id')->nullable(false);
            $table->char('zip')->nullable(false);
            $table->date('birthday')->nullable();
            $table->date('date_hired')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
