<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookBusinessAccount extends Model
{
    use HasFactory;
    protected $table = "facebook_business_accounts";



    public function facebook_user(){
        return $this->belongsTo(FacebookUser::class,'facebook_users_id');
    }

    public function facebook_adcampaign(){
        return $this->hasMany(FacebookAdCampaign::class,'facebook_ads_account_id');
    }


}
