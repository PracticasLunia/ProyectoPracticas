import { Autor } from "./autor.interface";

export interface AutorResponse{
  data?: Autor
  message: string,
  errors: Error|null
}

export interface AutoresResponse{
  data?: Autor[]
  message: string,
  errors: Error|null
}
