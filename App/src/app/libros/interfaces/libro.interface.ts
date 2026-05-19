export interface Libro {
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
}
