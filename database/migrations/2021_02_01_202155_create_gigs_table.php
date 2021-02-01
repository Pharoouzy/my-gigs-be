<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gigs', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('role');
            $table->string('company_name');
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->cascadeOnDelete();
            $table->unsignedBigInteger('state_id');
            $table->foreign('state_id')->references('id')->on('states')->cascadeOnDelete();
            $table->longText('address');
            $table->decimal('min_salary', 20, 2)->default('0.00');
            $table->decimal('max_salary', 20, 2)->default('0.00');
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
        Schema::dropIfExists('gigs');
    }
}
