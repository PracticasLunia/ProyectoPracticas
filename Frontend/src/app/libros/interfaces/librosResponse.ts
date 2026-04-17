import { Libro } from "./libros.interface";

export interface LibroResponse {
  data:Libro|null;
  message: string;
}
