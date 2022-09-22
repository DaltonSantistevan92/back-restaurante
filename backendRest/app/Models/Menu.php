<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Rol;

class Menu extends Model
{
    use HasFactory;

    protected $table = "menus";

    public function rol(){
        return $this->belongsTo(Rol::class);
    }
}
