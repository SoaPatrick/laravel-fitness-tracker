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
        Schema::table('exercises', function (Blueprint $table) {
            $table->enum('orientation', ['up', 'down'])->nullable();
            $table->string('video_url')->nullable();
            $table->string('preview_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exercises', function (Blueprint $table) {
            $table->dropColumn('orientation');
            $table->dropColumn('video_url');
            $table->dropColumn('preview_image');
        });
    }
};
