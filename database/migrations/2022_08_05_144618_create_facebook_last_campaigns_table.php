<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacebookLastCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facebook_last_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string("account_currency")->nullable();
            $table->string("country")->nullable();
            $table->unsignedBigInteger("account_id")->nullable();
            $table->string("account_name");
            $table->string("campaign_id");
            $table->text("campaign_name");
            $table->bigInteger("clicks");
            $table->float("cpc")->nullable();
            $table->float("cpm");
            $table->date("created_time")->nullable();
            $table->float("ctr");
            $table->date("date_start")->nullable();
            $table->date("date_stop")->nullable();
            $table->string("objective");
            $table->float("spend");
            $table->bigInteger("reach")->nullable();
            $table->bigInteger("impressions");
            $table->timestamps();
        });
    }
/*
account_currency: "BRL"
account_id: "1130983330591585"
account_name: "Analisar.co Douglas"
campaign_id: "23851454572080651"
campaign_name: "icredapp.com#830#818 — Cópia"
clicks: "2335"
cpc: "0.044891"
cpm: "3.517922"
created_time: "2022-07-25"
ctr: "7.836622"
date_start: "2022-07-09"
date_stop: "2022-08-07"
impressions: "29796"
objective: "CONVERSIONS"
reach: "21536"
spend: "104.82"

*/



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facebook_last_campaigns');
    }
}
