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
        Schema::create('bus_event', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('daily_report_id')->nullable();
            $table->string('name')->nullable();
            $table->mediumText('description')->nullable();
            $table->dateTime('time')->nullable();
            $table->string('location')->nullable();
            $table->string('reporter')->nullable();
            $table->mediumText('notified')->nullable();
            $table->string('recorder')->nullable();
            $table->integer('damage_value')->nullable();

            $table->foreign('daily_report_id')->references('id')->on('daily_reports')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bus_event');
    }
};
