<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleArticleCategoryTable extends Migration
{
    public function up(): void
    {
        Schema::create('article_article_category', function (Blueprint $table) {
            $table->unsignedInteger('article_category_id')->unsigned()->index();
            $table->foreign('article_category_id')->references('id')->on('article_categories')->onDelete('cascade');
            $table->unsignedInteger('article_id')->unsigned()->index();
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('article_article_category');
    }
}
