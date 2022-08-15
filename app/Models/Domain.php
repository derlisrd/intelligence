<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;
    protected $table = 'domains';
    protected $fillable=['domain'];
    protected $hidden = ['updated_at','created_at'];
}
