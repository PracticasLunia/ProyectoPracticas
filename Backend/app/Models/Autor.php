<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
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

