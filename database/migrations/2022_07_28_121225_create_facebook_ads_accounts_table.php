<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacebookAdsAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facebook_ads_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("facebook_users_id")->nullable();
            $table->foreign("facebook_users_id")->references("id")->on("facebook_users")->onDelete("set null");
            $table->string('name');
            $table->string('account_id');
            $table->string("act_account_id");
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
        Schema::dropIfExists('facebook_ads_accounts');
    }
}
