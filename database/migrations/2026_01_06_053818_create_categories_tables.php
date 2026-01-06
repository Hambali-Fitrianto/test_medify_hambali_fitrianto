<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 1. Tabel Kategori
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('kode');
            $table->string('nama');
            $table->timestamps();
        });

        // 2. Tabel Pivot (Many to Many) - Tanpa Foreign Key Constraint
        Schema::create('category_item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('master_item_id');
            
            // Kita tidak pakai $table->foreign(...) sesuai request
        });
    }

    public function down()
    {
        Schema::dropIfExists('category_item');
        Schema::dropIfExists('categories');
    }
};