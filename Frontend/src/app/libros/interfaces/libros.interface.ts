export interface Libro {
  id:          number;
  created_at:  Date;
  updated_at:  Date;
  titulo:      string;
  isbn:        string;
  publicacion: number;
  sinopsis:    string;
  num_paginas: number;
  disponible:  number;
  autor_id: number;
  nombre_autor: string;
  generos:Genero[]
}

interface Genero{
  nombre:string;
}

