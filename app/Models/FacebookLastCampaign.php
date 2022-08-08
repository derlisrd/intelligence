<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookLastCampaign extends Model
{
    use HasFactory;
    protected $table = "facebook_last_campaigns";
    protected $hidden = ['updated_at','created_at'];
}
