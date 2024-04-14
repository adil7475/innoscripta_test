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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('author_id')->nullable();
            if (getenv('DB_CONNECTION' === 'sqlite')) {
                $table->text('title')->nullable();
                $table->text('description')->nullable();
            }
            $table->text('title')->fulltext()->nullable();
            $table->text('description')->fulltext()->nullable();
            $table->text('url')->nullable();
            $table->text('image_url')->nullable();
            $table->timestampTz('published_at');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('category_id')
                ->on('categories')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('source_id')
                ->on('sources')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('author_id')
                ->on('authors')
                ->references('id')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
