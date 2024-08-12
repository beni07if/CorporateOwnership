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
        Schema::create('groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('idGroup')->nullable();
            $table->string('group_name')->nullable();
            $table->string('official_group_name')->nullable();
            $table->string('group_status')->nullable();
            $table->string('stock_exchange_name')->nullable();
            $table->string('controller')->nullable();
            $table->text('company_overview')->nullable();
            $table->text('business_sector')->nullable();
            $table->text('main_product')->nullable();
            $table->string('commercial_operation_date')->nullable();
            $table->string('country_registration')->nullable();
            $table->text('business_address')->nullable();
            $table->string('country_operation')->nullable();
            $table->string('shareholder_name1')->nullable();
            $table->string('percent_of_share1')->nullable();
            $table->string('shareholder_name2')->nullable();
            $table->string('percent_of_share2')->nullable();
            $table->string('shareholder_name3')->nullable();
            $table->string('percent_of_share3')->nullable();
            $table->string('shareholder_name4')->nullable();
            $table->string('percent_of_share4')->nullable();
            $table->string('shareholder_name5')->nullable();
            $table->string('percent_of_share5')->nullable();
            $table->string('group_structure')->nullable();
            $table->text('management_name_and_position')->nullable();
            $table->string('subsidiary_affiliation')->nullable();
            $table->string('land_area_controlled')->nullable();
            $table->string('total_planted')->nullable();
            $table->string('total_smallholders')->nullable();
            $table->string('total_land_designated_hcv')->nullable();
            $table->string('annual_ffb_productivity')->nullable();
            $table->string('annual_productivity_by_rspo_certified')->nullable();
            $table->string('annual_cpo_productivity')->nullable();
            $table->string('annual_cpk_productivity')->nullable();
            $table->string('rspo_member')->nullable();
            $table->string('cgf_member')->nullable();
            $table->string('asd_member')->nullable();
            $table->string('gpnsr_member')->nullable();
            $table->string('others_mention')->nullable();
            $table->string('ndpe_policy')->nullable();
            $table->string('ndpe_time_bound_plan_implementation')->nullable();
            $table->string('sustainability_progress_report')->nullable();
            $table->string('supply_chain_traceability')->nullable();
            $table->string('grievance_mechanism')->nullable();
            $table->string('recovery_plan')->nullable();
            $table->string('data_sources')->nullable();
            $table->string('last_update')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};