import { Libro } from "./libro.interface";

export interface LibrosResponse {
  data?: Libro[];
  meta?: { current_page: number; last_page: number; per_page: number; total: number };
  message: string;
  errors: unknown[] | null;
}
