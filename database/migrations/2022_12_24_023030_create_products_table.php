<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->foreignId('category_id')->constrained(); //llave foranea a la tabla category
            $table->string('code',25)->nullable(); //codigo de barra
            $table->string('name',100);
            $table->string('changes',255)->nullable(); //cambios
            $table->decimal('cost',10,2)->default(0); //maximo de 10 digitos y 2 decimales
            $table->decimal('price',10,2)->default(0); //precio de venta genral de productos
            $table->decimal('price2',10,2)->default(0); //precio especial
            $table->integer('stock')->default(0);
            $table->integer('min_stock')->default(0);
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
};
