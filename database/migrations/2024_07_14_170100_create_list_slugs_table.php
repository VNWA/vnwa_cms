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
        Schema::create('list_slugs', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('model_type'); // Loại model (ví dụ: CategoryBlog, Post)
            $table->unsignedBigInteger('model_id'); // ID của model tương ứng
            $table->timestamps();
            $table->index(['slug', 'model_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('list_slugs');
    }
};
