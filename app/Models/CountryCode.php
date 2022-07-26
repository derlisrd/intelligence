<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryCode extends Model
{
    use HasFactory;
    protected $table = 'country_codes';
    protected $fillable=['name','country_code'];
    protected $hidden = ['updated_at','created_at'];
}
