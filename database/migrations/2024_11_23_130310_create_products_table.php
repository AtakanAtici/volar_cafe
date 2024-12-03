<?php
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
            $table->id(); // Birincil anahtar
            $table->string('name'); // Ürün adı
            $table->decimal('price', 10, 2); // Ürün fiyatı
            $table->string('cover_image'); // Kapak fotoğrafı yolu
            $table->text('description')->nullable(); // Ürün açıklaması
            $table->timestamps(); // created_at ve updated_at
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
