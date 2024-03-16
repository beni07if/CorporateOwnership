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
        Schema::create('sras', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('idGroup')->nullable();
            $table->string('group_name')->nullable();
            $table->string('transparency')->nullable();
            $table->string('percent_transparency')->nullable();
            $table->string('rspo_compliance')->nullable();
            $table->string('percent_rspo_compliance')->nullable();
            $table->string('ndpe_compliance')->nullable();
            $table->string('percent_ndpe_compliance')->nullable();
            $table->string('total')->nullable();
            $table->string('percent_total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sras');
    }
};
