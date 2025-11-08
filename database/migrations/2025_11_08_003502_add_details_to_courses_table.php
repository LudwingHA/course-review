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
    Schema::table('courses', function (Blueprint $table) {
        $table->string('category')->nullable();
        $table->string('image')->nullable();
        $table->text('tags')->nullable(); 
        $table->text('content_table')->nullable(); 
        $table->string('youtube_urls')->nullable(); 
        $table->date('published_at')->nullable();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            //
        });
    }
};
