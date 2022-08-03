<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookAdsAccount extends Model
{
    use HasFactory;
    protected $table = "facebook_ads_accounts";
    protected $hidden = ['updated_at','created_at'];

    public function facebook_user(){
        return $this->belongsTo(FacebookUser::class,'facebook_users_id');
    }

    public function adCampaigns(){
        return $this->hasMany(FacebookAdCampaign::class,'facebook_ads_account_id');
    }
}
