<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookBussinessAccount extends Model
{
    use HasFactory;
    protected $table = "facebook_bussiness_accounts";



    public function facebook_user(){
        return $this->belongsTo(FacebookUser::class,'facebook_users_id');
    }
}
