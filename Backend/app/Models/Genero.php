<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Genero extends Model
{

    use HasFactory;
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
