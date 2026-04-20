import { Prestamo } from "./prestamo.interface";

export interface PrestamosResponse {
  data?:Prestamo[],
  message:string,
  errors: Error|null
}
