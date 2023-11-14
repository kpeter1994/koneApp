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
        Schema::table('feed_comments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('name');
            $table->unsignedBigInteger('creator_id');

            $table->foreign('feed_id')->references('id')->on('feeds')->onDelete('cascade');
            $table->foreign('creator_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feed_comments', function (Blueprint $table) {
            //
        });
    }
};
