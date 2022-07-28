<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookUser extends Model
{
    use HasFactory;
    protected $table= "facebook_users";


    //relacion uno a muchos
    public function ads_accounts(){

        return $this->hasMany(FacebookAdsAccount::class,'facebook_users_id');

    }
}
