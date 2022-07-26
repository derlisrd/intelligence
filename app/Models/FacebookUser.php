<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookUser extends Model
{
    use HasFactory;
    protected $table= "facebook_users";


    //relacion uno a muchos
    public function bussiness_accounts(){

        return $this->hasMany(FacebookBussinessAccount::class,'facebook_users_id');

    }
}
