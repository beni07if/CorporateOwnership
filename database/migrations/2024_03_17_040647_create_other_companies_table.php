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
        Schema::create('other_companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('notaris')->nullable();
            $table->string('badan_hukum')->nullable();
            $table->string('kedudukan')->nullable();
            $table->string('no_bn')->nullable();
            $table->string('no_tbn')->nullable();
            $table->string('tahun_terbit')->nullable();
            $table->string('jenis_badan_hukum')->nullable();
            $table->string('jenis_transaksi')->nullable();
            $table->string('no_sk')->nullable();
            $table->string('tanggal_sk')->nullable();
            $table->string('no_akta')->nullable();
            $table->string('tanggal_akta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('other_companies');
    }
};
