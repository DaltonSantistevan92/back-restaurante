<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Menu;


class Rol extends Model
{
    use HasFactory;

    protected $table = "roles";

    public function user(){
        return $this->hasMany(User::class);
    }

    public function menu(){
        return $this->hasMany(Menu::class);
    }
}
