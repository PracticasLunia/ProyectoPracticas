import { Genero } from "./genero.interface";

export interface GeneroResponse{
  data?: Genero,
  message: string,
  errors: Error|null
}
