import { Prestamo } from "./prestamo.interface";

export interface PrestamoResponse{

  data?:Prestamo,
  message:string,
  errors: Error|null
}
