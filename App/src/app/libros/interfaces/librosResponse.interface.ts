import { Libro } from "./libro.interface";

export interface LibroResponse {
  data?: Libro;
  message: string;
  errors: unknown[] | null;
}
