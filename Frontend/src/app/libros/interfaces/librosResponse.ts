import { Libro } from "./libros.interface";

export interface LibroResponse {
  data?:Libro;
  message: string;
  errors: Error|null
}


export interface LibrosResponse {
  data?:Libro[];
  meta?: { current_page: number; last_page: number; per_page: number; total: number };
  message: string;
  errors: Error|null
}
