<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    protected $fillable = [
        "titulo",
        "isbn",
        "publicacion",
        "sinopsis",
        "num_paginas",
        "disponible",
        "autor_id"
    ];

    //Method relation
    public function autores(){
        return $this->belongsTo(Autor::class);
    }

    public function generos(){
        return $this->belongsToMany(Genero::class);
    }

}
