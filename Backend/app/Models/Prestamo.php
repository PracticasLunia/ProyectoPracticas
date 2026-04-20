<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    //
    protected $fillable = [
        'libro_id',
        'nombre_lector',
        'email_lector',
        'fecha_prestamo',
        'fecha_devolucion_prevista',
        'fecha_devolucion_real',
        'observaciones'
    ];

    //Valores que no existen en la bd, y se calculan dinamicamente a patir de otros
    protected $appends = ['esta_disponible'];

    //Funciones para asignarles valor a los atributos $appends
    public function getEstaDisponibleAttribute(): bool{
       if($this->fecha_devolucion_real != null){
        return true;
       }
       else{
            return false;
       }
    }

    //Relaciones
    public function libro(){
        return $this->belongsTo(Libro::class);
    }

}
