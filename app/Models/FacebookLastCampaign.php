<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacebookLastCampaign extends Model
{
    use HasFactory;
    protected $table = "facebook_last_campaigns";
    protected $hidden = ['updated_at', 'created_at'];
    protected $fillable=['date_preset','account_currency','account_name','account_id','campaign_id','campaign_name','clicks','cpc','cpm','created_time','ctr','date_start','date_stop','impressions','objective','reach','spend','country'];
}
