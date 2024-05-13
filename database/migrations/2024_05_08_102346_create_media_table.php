<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('model_type');
            $table->unsignedBigInteger('model_id');
            $table->string('collection_name');
            $table->string('name');
            $table->string('file_name');
            $table->string('mime_type')->nullable();
            $table->string('disk');
            $table->string('conversions_disk')->nullable();
            $table->string('size')->nullable();
            $table->string('uuid')->nullable(); // Add the 'uuid' column
            $table->json('custom_properties')->nullable();
            $table->json('responsive_images')->nullable();
            $table->bigInteger('order_column')->nullable();
            $table->json('manipulations')->nullable();
            $table->json('generated_conversions')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('media');
    }
}


