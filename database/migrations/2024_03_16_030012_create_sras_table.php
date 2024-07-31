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
            $table->integer('transparency')->nullable();
            $table->float('percent_transparency')->nullable();
            $table->integer('rspo_compliance')->nullable();
            $table->float('percent_rspo_compliance')->nullable();
            $table->integer('ndpe_compliance')->nullable();
            $table->float('percent_ndpe_compliance')->nullable();
            $table->integer('total')->nullable();
            $table->float('percent_total')->nullable();
            
            $table->integer('score_transparency_upstream')->nullable();
            $table->text('desc_transparency_upstream')->nullable();
            $table->integer('score_transparency_sustainability')->nullable();
            $table->text('desc_transparency_sustainability')->nullable();
            $table->integer('score_transparency_refiners')->nullable();
            $table->text('desc_transparency_refiners')->nullable();
            $table->integer('score_transparency_publish_maps')->nullable();
            $table->text('desc_transparency_publish_maps')->nullable();
            $table->integer('score_transparency_concessions')->nullable();
            $table->text('desc_transparency_concessions')->nullable();
            $table->integer('score_transparency_website')->nullable();
            $table->text('desc_transparency_website')->nullable();
            $table->integer('score_rspo_registration')->nullable();
            $table->text('desc_rspo_registration')->nullable();
            $table->integer('score_rspo_certification_progress')->nullable();
            $table->text('desc_rspo_certification_progress')->nullable();
            $table->integer('score_rspo_percent_plantations')->nullable();
            $table->text('desc_rspo_percent_plantations')->nullable();
            $table->integer('score_rspo_complaints')->nullable();
            $table->text('desc_rspo_complaints')->nullable();
            $table->integer('score_ndpe_policy_adopted')->nullable();
            $table->text('desc_ndpe_policy_adopted')->nullable();
            $table->integer('score_ndpe_social_issues')->nullable();
            $table->text('desc_ndpe_social_issues')->nullable();
            $table->integer('score_ndpe_deforestation')->nullable();
            $table->text('desc_ndpe_deforestation')->nullable();
            $table->integer('score_ndpe_peatland_development')->nullable();
            $table->text('desc_ndpe_peatland_development')->nullable();
            $table->integer('score_ndpe_burn_areas')->nullable();
            $table->text('desc_ndpe_burn_areas')->nullable();
            $table->integer('score_ndpe_land_protection')->nullable();
            $table->text('desc_ndpe_land_protection')->nullable();
            $table->integer('score_ndpe_restoration_in_peatland')->nullable();
            $table->text('desc_ndpe_restoration_in_peatland')->nullable();
            $table->integer('score_hcvhsc_assessment')->nullable();
            $table->text('desc_hcvhsc_assessment')->nullable();
            $table->integer('total_scoring')->nullable();
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