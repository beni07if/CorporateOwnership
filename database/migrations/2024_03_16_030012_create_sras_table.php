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
            
            $table->string('transparency_upstream')->nullable();
            $table->string('transparency_sustainability')->nullable();
            $table->string('transparency_refiners')->nullable();
            $table->string('transparency_publish')->nullable();
            $table->string('transparency_website')->nullable();
            $table->string('rspo_registration')->nullable();
            $table->string('rspo_certification_progress')->nullable();
            $table->string('rspo_percent')->nullable();
            $table->string('rspo_complaints')->nullable();
            $table->string('ndpe_adopted')->nullable();
            $table->string('ndpe_social_issues')->nullable();
            $table->string('ndpe_deforestation')->nullable();
            $table->string('ndpe_peatland')->nullable();
            $table->string('ndpe_burn_area')->nullable();
            $table->string('ndpe_land_protection')->nullable();
            $table->string('ndpe_restoration')->nullable();
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
