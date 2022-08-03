<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacebookAdcampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facebook_adcampaigns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("facebook_ads_account_id")->nullable();
            $table->foreign("facebook_ads_account_id")->references("id")->on("facebook_ads_accounts")->onDelete("set null");
            $table->unsignedBigInteger("facebook_users_id")->nullable();
            $table->string("name");
            $table->string("objective");
            $table->text("campaign_id");
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
        Schema::dropIfExists('facebook_adcampaigns');
    }
}
