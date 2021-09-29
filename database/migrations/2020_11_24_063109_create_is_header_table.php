<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIsHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('is_header', function (Blueprint $table) {
            $table->increments('id');
            $table->string('controlNum',250)->nullable();
            $table->date('docDate');
            $table->string('receiverId',250);
            $table->string('receiver',250);
            $table->string('position',250)->nullable();
            $table->integer('isContractor');
            $table->integer('contractorId')->nullable();
            $table->string('status',150);
            $table->datetime('postedDate');
            $table->integer('isCompleted');
            $table->string('dept')->nullable();
            $table->string('location');
            $table->string('systemref')->nullable();
            $table->string('addedBy',150);
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
        Schema::dropIfExists('is_header');
    }
}
