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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->string('name')->nullable();
            $table->integer('stok')->nullable();
            $table->integer('qty_kecil')->nullable();
            $table->integer('qty_sedang')->nullable();
            $table->integer('qty_besar')->nullable();
            $table->enum('satuan_kecil', ['pcs', 'sachet'])->nullable();
            $table->enum('satuan_sedang', ['pack', 'rtg', 'box'])->nullable();
            $table->enum('satuan_besar', ['bal', 'krt', 'jrg'])->nullable();
            $table->enum('fp', ['ppn', 'non_ppn'])->nullable();
            $table->enum('type', ['makanan/minuman', 'otomotif'])->nullable();
            $table->string('keterangan')->nullable();
            $table->integer('ppn')->nullable();
            $table->integer('stat_data')->default(1)->nullable();
            $table->integer('stat_barang')->default(1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
