<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('category_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // Tambahkan kolom kategori ke tabel products jika belum ada
        if (!Schema::hasColumn('products', 'kategori')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('kategori')->nullable()->after('stock');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Hapus kolom kategori jika ada
        if (Schema::hasColumn('products', 'kategori')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('kategori');
            });
        }
        Schema::dropIfExists('category_products');
    }
};
