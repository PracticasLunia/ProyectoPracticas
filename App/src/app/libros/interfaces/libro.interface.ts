import { Autor } from "src/app/autores/interfaces/autor.interface";
import { Genero } from "src/app/generos/interfaces/genero.interface";
import { Prestamo } from "src/app/prestamos/interfaces/prestamo.interface";

/*export interface Libro {
  id: number;
  titulo: string;
  isbn: string;
  publicacion: number;
  sinopsis: string;
  num_paginas: number;
  disponible: boolean;
  tiene_portada: boolean;
  nombre_autor: string;
  generos: { id: number; nombre: string }[];
  tiene_prestamo_activo: boolean;
}*/

export interface Libro{
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
  tiene_prestamo_activo:boolean
  contenido_nombre: string | null;
  contenido_tamano: number | null;
  autor_id: number;
  nombre_autor: string;
  generos:Genero[];
  autor:Autor;
  prestamos?:Prestamo[];
}
