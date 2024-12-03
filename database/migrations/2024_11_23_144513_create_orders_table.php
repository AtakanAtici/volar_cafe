<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siparişi veren kullanıcı
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Sipariş edilen ürün
            $table->integer('quantity'); // Adet
            $table->decimal('price', 10, 2); // Fiyat
            $table->text('description')->nullable(); // Açıklama
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
