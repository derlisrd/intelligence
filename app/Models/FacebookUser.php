<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookUser extends Model
{
    use HasFactory;
    protected $table= "facebook_users";
    protected $fillable= ["email","name","facebook_user_id","access_token","user_id"];
    protected $hidden = ['updated_at','created_at'];

    //relacion uno a muchos
    public function ads_accounts(){

        return $this->hasMany(FacebookAdsAccount::class,'facebook_users_id');

    }

    public function adcampaigns(){
        return $this->hasMany(FacebookAdCampaign::class,'facebook_users_id');
    }
}
