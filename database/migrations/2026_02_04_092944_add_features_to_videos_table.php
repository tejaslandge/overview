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
        Schema::table('videos', function (Blueprint $table) {
            $table->string('title')->nullable()->after('id');
            $table->string('category')->nullable()->after('description');
            $table->string('thumbnail_path')->nullable()->after('file_path');
            $table->boolean('is_active')->default(true)->after('description');
            $table->unsignedBigInteger('views')->default(0)->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn(['title', 'category', 'thumbnail_path', 'is_active', 'views']);
        });
    }
};
