import { Autor } from "../../autores/interfaces/autor.interface";
import { Genero } from "../../generos/interfaces/genero.interface";


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
  autor_id: number;
  nombre_autor: string;
  generos:Genero[];
  autor:Autor;
}

/*interface Genero{
  nombre:string;
}*/

