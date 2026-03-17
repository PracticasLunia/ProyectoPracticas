<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genero extends Model
{
    //Sigue convencion Genero->generos
    //protected $table= "generos";

    protected $fillable= [
        "nombre",
        "descripcion",
    ];

    //Method relation
    public function libros(){
        return $this->belongsToMany(Libro::class);
    }


}
