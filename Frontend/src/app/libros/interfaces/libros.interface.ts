import { Autor } from "../../autores/interfaces/autor.interface";
import { Genero } from "../../generos/interfaces/genero.interface";
import { Prestamo } from "../../prestamos/interfaces/prestamo.interface";


export interface Libro {
  id:          number;
  created_at:  Date;
  updated_at:  Date;
  titulo:      string;
  isbn:        string;
  publicacion: number;
  sinopsis:    string;
  num_paginas: number;
  disponible:  boolean;
  tiene_portada:boolean;
  tiene_contenido:boolean;
  contenido_nombre: string | null;
  contenido_tamano: number | null;
  autor_id: number;
  nombre_autor: string;
  generos:Genero[];
  autor:Autor;
  prestamo_activo:Prestamo;
  esta_prestado:boolean;
}
