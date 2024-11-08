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
        Schema::create('emergency', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('error_number')->nullable();
            $table->string('dispatcher')->nullable();
            $table->string('criterion_dispatcher')->nullable();
            $table->string('real')->nullable();
            $table->string('number_passengers')->nullable();
            $table->string('injured')->nullable();
            $table->string('description')->nullable();
            $table->string('line_quality')->nullable();
            $table->string('safety_advice')->nullable();
            $table->string('arrival_time')->nullable();
            $table->text('comment')->nullable();
            $table->string('equipment_id')->nullable();
            $table->string('need_maintenance_time')->nullable();
            $table->string('need_maintenance')->nullable();
            $table->string('maintenance_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency');
    }
};
