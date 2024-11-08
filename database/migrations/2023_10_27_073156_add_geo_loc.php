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
        Schema::table('equipments', function (Blueprint $table) {
            // Csak akkor adjuk hozzá az 'lat' oszlopot, ha még nem létezik
            if (!Schema::hasColumn('equipments', 'lat')) {
                $table->string('lat')->nullable();
            }

            // Csak akkor adjuk hozzá az 'lng' oszlopot, ha még nem létezik
            if (!Schema::hasColumn('equipments', 'lng')) {
                $table->string('lng')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipments', function (Blueprint $table) {
            // Itt pedig ellenőrizzük, hogy léteznek-e az oszlopok, mielőtt eltávolítanánk őket
            if (Schema::hasColumn('equipments', 'lat')) {
                $table->dropColumn('lat');
            }

            if (Schema::hasColumn('equipments', 'lng')) {
                $table->dropColumn('lng');
            }
        });
    }
};
