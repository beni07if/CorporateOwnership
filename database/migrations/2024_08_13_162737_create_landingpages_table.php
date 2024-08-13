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
        Schema::create('landingpages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tagline')->nullable();
            $table->string('title_short_definition')->nullable();
            $table->text('short_definition')->nullable();
            $table->string('title_of_data1')->nullable();
            $table->string('number_of_data1')->nullable();
            $table->string('tag_of_data1')->nullable();
            $table->string('title_of_data2')->nullable();
            $table->string('number_of_data2')->nullable();
            $table->string('tag_of_data2')->nullable();
            $table->string('title_of_data3')->nullable();
            $table->string('number_of_data3')->nullable();
            $table->string('tag_of_data3')->nullable();

            $table->string('title_corporate_profile')->nullable();
            $table->text('definition_corporate_profile')->nullable();
            $table->string('image_corporate_profile')->nullable();
            
            $table->string('key_feature_title1')->nullable();
            $table->text('key_feature_desc1')->nullable();
            $table->string('key_feature_image1')->nullable();
            $table->string('key_feature_title2')->nullable();
            $table->text('key_feature_desc2')->nullable();
            $table->string('key_feature_image2')->nullable();
            $table->string('key_feature_title3')->nullable();
            $table->text('key_feature_desc3')->nullable();
            $table->string('key_feature_image3')->nullable();
            $table->string('key_feature_title4')->nullable();
            $table->text('key_feature_desc4')->nullable();
            $table->string('key_feature_image4')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landingpages');
    }
};