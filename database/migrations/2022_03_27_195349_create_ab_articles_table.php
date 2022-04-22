<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ab_articles', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('ab_name',80);
            $table->integer('ab_price');
            $table->string('ab_description', 1000)->nullable();
            $table->unsignedInteger('ab_creator_id');
            $table->timestamp('ab_createdate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ab_articles');
    }
};
