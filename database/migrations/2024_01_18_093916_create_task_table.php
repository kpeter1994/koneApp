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
        Schema::create('task', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->unsignedBigInteger('error_id')->nullable();
            $table->unsignedBigInteger('acceptor_id')->nullable();
            $table->boolean('is_accepted')->default(false);

            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('error_id')->references('id')->on('error')->onDelete('cascade');
            $table->foreign('acceptor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task');
    }
};
