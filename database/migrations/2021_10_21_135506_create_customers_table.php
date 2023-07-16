<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('id',15);
            $table->primary('id');
            $table->bigInteger('title_id');
            $table->string('name',255);
            $table->string('email',125)->nullable();
            $table->text('note')->nullable();

            $table->text('address');
            $table->bigInteger('province_id')->nullable();
            $table->bigInteger('city_id')->nullable();
            $table->bigInteger('district_id')->nullable();
            $table->bigInteger('village_id')->nullable();
            $table->string('zipcode',7)->nullable();
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();


            $table->string('pic',255)->nullable();
            $table->string('phone',20)->nullable();

            $table->bigInteger('registered_by');
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
