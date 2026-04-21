<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isNull;

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
        //Acceso a datos de archivos
        "portada_path",
        "contenido_path",
        "contenido_nombre",
        "contenido_tamano",
    ];

    //Valores que no existen en la bd, y se calculan dinamicamente a patir de otros
    protected $appends = ['tiene_portada', 'tiene_contenido'];

    //Casteo a tipo admitido para Mysql number->boolean
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

    public function prestamos(){
        return $this->hasMany(Prestamo::class);
    }

    //Funciones para asignarles valor a los atributos $appends
    public function getTienePortadaAttribute(): bool
    {
        return !is_null($this->portada_path);
    }

    public function getTieneContenidoAttribute(): bool{
        return !is_null($this->contenido_path);
    }

}


