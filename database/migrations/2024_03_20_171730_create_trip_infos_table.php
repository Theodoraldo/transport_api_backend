<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trip_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity_sold')->default(0);
            $table->decimal('fare', 10, 2);
            $table->boolean('completed')->default(false);
            $table->string('trip_from');
            $table->string('trip_to');
            $table->time('trip_time');
            $table->date('trip_date');
            $table->integer('duration');
            $table->string('mode')->default('terminal');
            $table->unsignedBigInteger('web_user_id');
            $table->unsignedBigInteger('car_id');
            $table->unsignedBigInteger('driver_id');
            $table->timestamps();

            $table->foreign('web_user_id')->references('id')->on('users');
            $table->foreign('car_id')->references('id')->on('cars');
            $table->foreign('driver_id')->references('id')->on('drivers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_infos');
    }
};
