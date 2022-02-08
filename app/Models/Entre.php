<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entre extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['date','name','montant','validation','charge','designiation','image','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','id');
    }
}