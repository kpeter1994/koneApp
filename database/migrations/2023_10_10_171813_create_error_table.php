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
        Schema::create('error', function (Blueprint $table) {
            $table->id();
            $table->string('error_number')->nullable();
            $table->string('equipment_id');
            $table->string('description')->nullable();
            $table->string('error_type')->nullable();
            $table->string('isStand')->nullable();
            $table->string('injured')->nullable();
            $table->string('dispatcher')->nullable();
            $table->string('whistleblower')->nullable();
            $table->string('whistleblower_tel')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('error');
    }
};
