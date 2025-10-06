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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('short_description')->nullable();
            $table->text('description');
            $table->string('icon')->nullable();
            $table->string('image');
            $table->boolean('status')->default(true);

            //Seo
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 160)->nullable();
            $table->string('meta_keyword')->nullable();
            $table->string('meta_image')->nullable();
            $table->string('canonical_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
