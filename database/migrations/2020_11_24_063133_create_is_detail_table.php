<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIsDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('is_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('headerId');
            $table->string('itemDesc',250);
            $table->string('itemColor',250);
            $table->string('itemSize',250)->nullable();
            $table->integer('qty');
            $table->datetime('lastIssueDate');
            $table->text('remarks');
            $table->integer('qtyReleased')->default(0);
            $table->integer('refId')->nullable();
            $table->integer('noPAR')->nullable();
            $table->integer('systemref')->nullable();
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
        Schema::dropIfExists('is_detail');
    }
}
