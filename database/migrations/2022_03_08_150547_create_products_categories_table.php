<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 150);
            $table->string('name', 150);
            $table->integer('parent')->unsigned();
            $table->smallInteger('level')->unsigned();
            $table->text('description');
            $table->integer('thumbnail')->unsigned();
            $table->integer('sort')->unsigned();
            $table->string('meta_title', 255);
            $table->string('meta_description', 255);
            $table->string('meta_keywords', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_categories');
    }
}
