<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookAdCampaign extends Model
{
    use HasFactory;
    protected $table = 'facebook_adcampaigns';
    protected $hidden = ['updated_at','created_at'];

    public function ads_account(){
        return $this->belongsTo(FacebookAdsAccount::class,'facebook_ads_account_id');
    }

}
