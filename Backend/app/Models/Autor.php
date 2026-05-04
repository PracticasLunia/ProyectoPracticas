<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Autor extends Model
{

    use HasFactory;

    protected $table = "autores";

    protected $fillable = [
        "nombre",
        "apellidos",
        "nacionalidad",
        "fecha_nacimiento",
        "biografia",
    ];

    //Method relation
    public function libros(){
        return $this->hasMany(Libro::class, 'autor_id');
    }
}

