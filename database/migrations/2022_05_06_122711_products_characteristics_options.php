<?php

use App\Models\Products;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductsCharacteristicsOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_characteristics_options', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->string('unit', 150)->default('');
            $table->enum("type", [ Products::CHARACTERISTICS_TYPE__STRING, Products::CHARACTERISTICS_TYPE__INTEGER, Products::CHARACTERISTICS_TYPE__FLOAT, Products::CHARACTERISTICS_TYPE__COLOR ]);
            $table->string('meta', 255);
            $table->integer('sort' )->unsigned();
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
        //
    }
}
