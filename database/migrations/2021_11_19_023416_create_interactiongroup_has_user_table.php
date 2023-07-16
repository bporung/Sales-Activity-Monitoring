<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInteractiongroupHasUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interactiongroup_has_users', function (Blueprint $table) {
            
            $table->uuid('interactiongroup_id');
            $table->unsignedBigInteger('user_id');
            
            $table->primary(['interactiongroup_id', 'user_id']);

            $table->foreign('interactiongroup_id')
                ->references('id')
                ->on('interactiongroups')
                ->onDelete('cascade');
            $table->foreign('user_id')
                    ->references('id')
                    ->on('users')
                    ->onDelete('cascade');


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
        Schema::dropIfExists('interactiongroup_has_users');
    }
}
