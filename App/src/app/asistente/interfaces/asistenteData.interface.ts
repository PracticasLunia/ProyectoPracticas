import { CitationInterface } from "./citation.interface"
import { FuentesInterface } from "./fuentes.interface"

export interface AsistenteDataInterface {
  texto: string
  citas: CitationInterface[]
  fuentes? : FuentesInterface[]
}
