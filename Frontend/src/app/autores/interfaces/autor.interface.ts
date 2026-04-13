import { Libro } from "../../libros/interfaces/libros.interface";

export interface Autor {
  id:               number;
  created_at:       Date;
  updated_at:       Date;
  nombre:           string;
  apellidos:        string;
  nacionalidad:     string;
  fecha_nacimiento: string;
  biografia:        string;
  libros: Libro[]
}
