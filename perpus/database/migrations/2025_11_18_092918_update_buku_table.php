<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buku', function (Blueprint $table) {

            // Jika kolom belum ada → tambahkan
            if (!Schema::hasColumn('buku', 'penulis')) {
                $table->string('penulis', 100)->after('judul');
            }

            if (!Schema::hasColumn('buku', 'penerbit')) {
                $table->string('penerbit', 100)->after('penulis');
            }

            if (!Schema::hasColumn('buku', 'tahun')) {
                $table->integer('tahun')->after('penerbit');
            }

            if (!Schema::hasColumn('buku', 'stok')) {
                $table->integer('stok')->after('tahun');
            }
        });
    }

    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            $table->dropColumn(['penulis', 'penerbit', 'tahun', 'stok']);
        });
    }
};