<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class modulos extends Model
{
    protected $table = 'modulos';

    public function getKeyName(){
        return "id";
    }

    public $fillable = [
        'id',
        'nombre_modulo',
        'profesor',
        'created_at',
        'updated_at'
    ];
}
