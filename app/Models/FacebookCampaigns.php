<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookCampaigns extends Model
{
    use HasFactory;
    protected $fillable = [
        'campaign_name','campaign_id','status','account_id','created_time'
    ];
}
