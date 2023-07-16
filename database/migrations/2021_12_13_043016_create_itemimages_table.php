<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemimagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itemimages', function (Blueprint $table) {
            $table->id();
            $table->uuid('item_id');
            $table->text('description')->nullable();
            $table->text('link');
            $table->string('isDefault',1)->default('0');
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
        Schema::dropIfExists('itemimages');
    }
}
