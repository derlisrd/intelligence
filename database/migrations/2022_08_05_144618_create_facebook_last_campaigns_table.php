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
            $table->text("campaign_name");
            $table->text("campaign_id");
            $table->string("status");
            $table->string("objetive");
            $table->float("spent");
            $table->bigInteger("impressions");
            $table->unsignedBigInteger("account_id")->nullable();
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
        Schema::dropIfExists('facebook_last_campaigns');
    }
}
