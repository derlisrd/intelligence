<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoogleGamCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('google_gam_campaigns', function (Blueprint $table) {
            $table->id();
            $table->date("date");
            $table->string("domain");
            $table->bigInteger('impressions');
            $table->bigInteger('clicks');
            $table->float('cpm');
            $table->float('ctr');
            $table->float('receita');
            $table->string("name");
            $table->string('value');
            $table->string("country");
            $table->float("impressions_rate")->nullable();
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
        Schema::dropIfExists('google_gam_campaigns');
    }
}
