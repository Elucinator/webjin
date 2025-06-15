<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table('businesses', function (Blueprint $table) {
            $table->text('photo_url')->nullable()->after('website');
            $table->decimal('lat', 10, 7)->nullable()->after('photo_url');
            $table->decimal('lng', 10, 7)->nullable()->after('lat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table('businesses', function (Blueprint $table) {
            Schema::table('businesses', function (Blueprint $table) {
                $table->dropColumn(['photo_url', 'lat', 'lng']);
            });
        });
    }
};
