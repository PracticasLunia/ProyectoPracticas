import { AsistenteDataInterface } from "./asistenteData.interface"

export interface AsistenteResponseInterface {
  data?: AsistenteDataInterface
  message: string
  errors?: Error | null
}
