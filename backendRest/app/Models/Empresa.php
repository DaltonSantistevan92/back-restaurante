<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';
    protected $fillable = ['user_id','nombre','descripcion','img','estado'];

    public function user(){
        return $this->belongsTo(User::class);
    }
} 
