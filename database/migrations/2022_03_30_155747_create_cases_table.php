<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 150);
            $table->string('name', 150);
            $table->integer('thumbnail')->unsigned();
            $table->text('content');
            $table->integer('category')->unsigned();
            $table->string('products');
            $table->enum('status', ['published', 'draft', 'trash']);
            $table->string('meta', 255);
            $table->string('meta_title', 150);
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
        Schema::dropIfExists('cases');
    }
}
