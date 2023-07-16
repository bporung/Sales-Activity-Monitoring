<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInteractiondetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interactiondetails', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('interaction_id');
            $table->uuid('item_id');
            $table->bigInteger('qty')->default(1);
            $table->bigInteger('unit_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interactiondetails');
    }
}
