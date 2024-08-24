<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blog_tag_blog_post', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blog_tag_id')->constrained('blog_tags')->onDelete('cascade');
            $table->foreignId('blog_post_id')->constrained('blog_posts')->onDelete('cascade');
            $table->timestamps();
            $table->index(['blog_tag_id', 'blog_post_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_tag_blog_post');
    }
};
