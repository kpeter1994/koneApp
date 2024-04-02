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
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('dispatcher');
            $table->boolean('actual');
            $table->string('info_error')->nullable();
            $table->string('firewall_attack')->nullable();

            $table->integer('d_solo_demand')->nullable();
            $table->integer('d_articulated_demand')->nullable();
            $table->integer('d_solo_supply')->nullable();
            $table->integer('d_articulated_supply')->nullable();

            $table->integer('b_solo_demand')->nullable();
            $table->integer('b_articulated_demand')->nullable();
            $table->integer('b_solo_supply')->nullable();
            $table->integer('b_articulated_supply')->nullable();

            $table->integer('k_solo_demand')->nullable();
            $table->integer('k_articulated_demand')->nullable();
            $table->integer('k_sprinter_demand')->nullable();
            $table->integer('k_solo_supply')->nullable();
            $table->integer('k_articulated_supply')->nullable();
            $table->integer('k_sprinter_supply')->nullable();

            $table->string('d_start_worker')->nullable();
            $table->string('d_middle_worker')->nullable();
            $table->string('d_end_worker')->nullable();

            $table->string('b_start_worker')->nullable();
            $table->string('b_middle_worker')->nullable();
            $table->string('b_end_worker')->nullable();

            $table->string('k_start_worker')->nullable();
            $table->string('k_middle_worker')->nullable();
            $table->string('k_end_worker')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
};
