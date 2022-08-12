<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoogleGamCampaigns extends Model
{
    use HasFactory;
    protected $table= "google_gam_campaigns";
    protected $hidden = ['updated_at','created_at'];
    protected $fillable = ['date','domain','impressions','impressions_rate','country','value','name','value','receita','ctr','cpm','clicks'];
}
