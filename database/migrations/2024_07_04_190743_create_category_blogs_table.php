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
        Schema::create('category_blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('category_blogs')->onDelete('cascade');
            $table->integer('ord')->default(0);
            $table->tinyInteger('is_show')->default(1);
            $table->tinyInteger('is_highlight')->default(0);
            $table->string('name');
            $table->string('slug');
            $table->longText('content')->nullable();
            $table->text('meta_image')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_blogs');
    }
};
