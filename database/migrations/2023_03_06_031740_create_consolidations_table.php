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
        Schema::create('consolidations', function (Blueprint $table) {
            $table->integer('id');
            $table->string('user_id')->nullable();
            $table->string('id_subsidiary')->nullable();
            $table->string('id_group')->nullable();
            $table->string('id_mill')->nullable();
            $table->string('group_type')->nullable();
            $table->string('group_name')->nullable();
            $table->string('official_group_name')->nullable();
            $table->string('owner')->nullable();
            $table->string('group_status')->nullable();
            $table->string('stock_exchange')->nullable();
            $table->string('country_registration')->nullable();
            $table->string('rspo_member')->nullable();
            $table->string('ndpe_policy')->nullable();
            $table->string('ownership_status')->nullable();
            $table->string('subsidiary')->nullable();
            $table->string('shareholder_subsidiary')->nullable();
            $table->string('principal_activities')->nullable();
            $table->string('facilities')->nullable();
            $table->string('estate')->nullable();
            $table->string('status_operation')->nullable();
            $table->string('capacity')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('country_operation')->nullable();
            $table->string('province')->nullable();
            $table->string('regency')->nullable();
            $table->string('map_availability')->nullable();
            $table->string('land_title')->nullable();
            $table->string('sizebyeq')->nullable();
            $table->string('rspo_certified')->nullable();
            $table->string('mspo_certified')->nullable();
            $table->string('ispo_certified')->nullable();
            $table->string('data_source')->nullable();
            $table->string('data_update')->nullable();
            $table->string('complete_percen')->nullable();
            $table->string('akta')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consolidations');
    }
};
