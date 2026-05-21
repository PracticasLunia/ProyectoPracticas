import { Genero } from "./genero.interface";

export interface GenerosResponse{
  data?: Genero[],
  message: string,
  errors: Error|null
}
