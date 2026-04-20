import { Libro } from "./libros.interface";

export interface LibroResponse {
  data?:Libro;
  message: string;
  errors: Error|null
}


export interface LibrosResponse {
  data?:Libro[];
  message: string;
  errors: Error|null
}
