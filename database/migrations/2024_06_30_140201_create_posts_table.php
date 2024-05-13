<?php

// In the create_posts_table migration file

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('tags')->nullable();
            $table->string('feature')->nullable();
            $table->string('img')->nullable();
            $table->string('pdf_first')->nullable();
            $table->boolean('pinned')->default(false);
            $table->unsignedBigInteger('category_id')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('posts');
    }
}

