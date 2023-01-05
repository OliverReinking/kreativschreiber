<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('person_companies');
            //
            $table->string('adv_offer', 400)->nullable();
            $table->integer('adv_number_of_words')->nullable()->default(100);
            $table->boolean('adv_writing_style_persuasive')->nullable()->default(false);
            $table->boolean('adv_writing_style_emotional')->nullable()->default(false);
            $table->boolean('adv_writing_style_enlightening')->nullable()->default(false);
            $table->boolean('adv_writing_style_humorous')->nullable()->default(false);
            $table->boolean('adv_writing_style_provocative')->nullable()->default(false);
            $table->boolean('adv_gender_female')->nullable()->default(false);
            $table->boolean('adv_gender_male')->nullable()->default(false);
            $table->boolean('adv_gender_divers')->nullable()->default(false);
            $table->boolean('adv_age_strata_children')->nullable()->default(false);
            $table->boolean('adv_age_strata_young')->nullable()->default(false);
            $table->boolean('adv_age_strata_adults')->nullable()->default(false);
            $table->boolean('adv_age_strata_seniors')->nullable()->default(false);
            $table->string('adv_interest_groups', 400)->nullable();
            $table->string('adv_professional_groups', 400)->nullable();
            $table->string('adv_lifestyle', 400)->nullable();
            //
            $table->string('blog_topic', 400)->nullable();
            $table->integer('blog_number_of_words')->nullable()->default(100);
            $table->boolean('blog_writing_style_personal')->nullable()->default(false);
            $table->boolean('blog_writing_style_objective')->nullable()->default(false);
            $table->boolean('blog_writing_style_opinionated')->nullable()->default(false);
            $table->boolean('blog_writing_style_entertaining')->nullable()->default(false);
            $table->boolean('blog_writing_style_creative')->nullable()->default(false);
            $table->boolean('blog_gender_female')->nullable()->default(false);
            $table->boolean('blog_gender_male')->nullable()->default(false);
            $table->boolean('blog_gender_divers')->nullable()->default(false);
            $table->boolean('blog_age_strata_children')->nullable()->default(false);
            $table->boolean('blog_age_strata_young')->nullable()->default(false);
            $table->boolean('blog_age_strata_adults')->nullable()->default(false);
            $table->boolean('blog_age_strata_seniors')->nullable()->default(false);
            $table->string('blog_interest_groups', 400)->nullable();
            $table->string('blog_professional_groups', 400)->nullable();
            $table->string('blog_lifestyle', 400)->nullable();
            //
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
