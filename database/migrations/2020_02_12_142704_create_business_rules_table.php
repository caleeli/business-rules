<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('variable');
            $table->string('condition');
            $table->enum('status', ['ENABLED', 'DISABLED'])->default('ENABLED');
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
        Schema::dropIfExists('business_rules');
    }
}
