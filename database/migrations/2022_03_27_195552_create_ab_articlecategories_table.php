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
        Schema::create('ab_articlecategories', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->primary();
            $table->string('ab_name');
            $table->string('ab_description',1000)->nullable();
            $table->unsignedTinyInteger('ab_parent')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ab_articlecategories');
    }
};
