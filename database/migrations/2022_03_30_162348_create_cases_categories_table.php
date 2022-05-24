<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCasesCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cases_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 150);
            $table->string('name', 150);
            $table->integer('parent')->unsigned();
            $table->integer('sort')->unsigned();
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
        Schema::dropIfExists('cases_categories');
    }
}
