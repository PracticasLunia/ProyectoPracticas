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
        "autor_id",
        "portada_path",
    ];

    protected $casts = [
        'disponible' => 'bool'
    ];

    //Method relation
    public function autor(){
        return $this->belongsTo(Autor::class);
    }

    public function generos(){
        return $this->belongsToMany(Genero::class);
    }


    protected $appends = ['tiene_portada'];

    public function getTienePortadaAttribute(): bool
    {
        return !is_null($this->portada_path);
    }

}


