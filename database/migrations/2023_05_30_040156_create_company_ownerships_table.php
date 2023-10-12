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
        Schema::create('company_ownerships', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('idCompany')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_type')->nullable();
            $table->string('incorporation_date')->nullable();
            $table->string('company_number')->nullable();
            $table->string('date_company_number')->nullable();
            $table->string('change_company_number')->nullable();
            $table->string('date_change_company_number')->nullable();
            $table->string('taxpayer_identification_number')->nullable();
            $table->string('registered_address')->nullable();
            $table->string('country_of_registered_address')->nullable();
            $table->string('business_address')->nullable();
            $table->string('country_of_business_address')->nullable();
            $table->string('nature_of_business')->nullable();
            $table->string('shareholder_name')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('ic_passport_comp_number')->nullable();
            $table->string('address')->nullable();
            $table->string('position')->nullable();
            $table->string('number_of_shares')->nullable();
            $table->string('total_of_shares')->nullable();
            $table->string('percentage_of_shares')->nullable();
            $table->string('currency')->nullable();
            $table->string('data_source')->nullable();
            $table->string('data_update')->nullable();
            $table->string('pic')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_ownerships');
    }
};
