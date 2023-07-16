<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInteractiongroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interactiongroups', function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('customer_id',15);
            $table->string('name',255);
            $table->text('description')->nullable();
            $table->string('status',1)->default(1);
            $table->bigInteger('registered_by');
            $table->bigInteger('updated_by')->nullable();
            $table->timestamp('lastinteraction_at')->nullable();
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
        Schema::dropIfExists('interactiongroups');
    }
}
