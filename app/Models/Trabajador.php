<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Trabajador extends Model
{
    use HasFactory;
    protected $table = 'trabajador';

    public function getKeyName(){
        return "id";
    }

    public $fillable = [
        'nombre',
        'codigo',
        'estado',
    ];
}
