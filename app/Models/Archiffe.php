<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archiffe extends Model
{
    use HasFactory;
    protected $fillable = ['name','montant','validation','charge','designiation','image','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
