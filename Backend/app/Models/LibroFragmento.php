<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibroFragmento extends Model {

    protected $fillable = [
        "libro_id",
        "pagina",
        "orden",
        "texto",
        "embedding",
        "origen"
    ];

    protected $casts = [
        'embedding' => 'array',
    ];

    public function libro(){
        return $this->belongsTo(Libro::class);
    }

}
