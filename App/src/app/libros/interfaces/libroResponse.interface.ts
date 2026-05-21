import { Libro } from "./libro.interface";

export interface LibrosResponse {
  data?: Libro[];
  message: string;
  errors: unknown[] | null;
}
