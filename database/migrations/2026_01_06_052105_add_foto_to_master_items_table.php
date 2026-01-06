<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('master_items', function (Blueprint $table) {
            // Menambahkan kolom foto setelah kolom jenis
            // Kita set nullable agar data lama yang belum punya foto tidak error
            $table->string('foto')->nullable()->after('jenis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('master_items', function (Blueprint $table) {
            // Menghapus kolom jika kita melakukan rollback
            $table->dropColumn('foto');
        });
    }
};