<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // 'default', 'modern', etc.
            $table->string('label'); // User-friendly name like 'Classic Light Theme'
            $table->string('preview_image')->nullable(); // URL or local path
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('themes');
    }
};
