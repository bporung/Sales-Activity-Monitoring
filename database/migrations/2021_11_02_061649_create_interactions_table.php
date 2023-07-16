<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInteractionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interactions', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id',15);
            $table->bigInteger('customercontact_id')->nullable();
            $table->uuid('group_id')->nullable();
            $table->bigInteger('type_id');
            $table->bigInteger('stage_id');
            $table->text('description');
            $table->date('next_date')->nullable();
            $table->text('next_action')->nullable();
            $table->bigInteger('registered_by');
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('finalized_by')->nullable();
            $table->timestamp('finalized_at')->nullable();
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
        Schema::dropIfExists('interactions');
    }
}
