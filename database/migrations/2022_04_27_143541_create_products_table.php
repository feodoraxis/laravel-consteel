<?php

use App\Models\Products;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 150)->unique();
            $table->string('sku', 50);
            $table->integer('thumbnail_preview')->unsigned();
            $table->integer('thumbnail_detail')->unsigned();
            $table->string('gallery', 255); //JSON
            $table->decimal('price', 10, 2, true);
            $table->decimal('price_discount', 10, 2, true);
            $table->text('description');
            $table->text('description_detail');
            $table->mediumInteger('quantity')->unsigned();
            $table->string('files', 255); //JSON
            $table->enum("type", [ Products::TYPE_SIMPLE, Products::TYPE_VARIABLE ]);
            $table->string('meta', 255); //JSON
            $table->mediumInteger('category')->unsigned();
            $table->string('characteristics', 255); //JSON [{"CHAR_OPTION_ID":"CHAR_OPTION_VALUE"},{"CHAR_OPTION_ID":"CHAR_OPTION_VALUE"},{"CHAR_OPTION_ID":"CHAR_OPTION_VALUE"}]
            $table->integer('sort')->unsigned();
            $table->string('documentation', 255); //JSON or COMMA (,) LIKE DECIMAL
            $table->enum("status", [ Products::STATUS_PUBLISHED, Products::STATUS_DRAFT, Products::STATUS_TRASH ] );
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
        Schema::dropIfExists('products');
    }
}
