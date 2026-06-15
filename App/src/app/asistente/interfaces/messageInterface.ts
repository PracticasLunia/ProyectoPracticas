import { CitationInterface } from "./citation.interface"
import { FuentesInterface } from "./fuentes.interface"

export interface MessageInterface {
  role: 'user' | 'assistant'
  content: string
  citas? : CitationInterface[]
  fuentes? : FuentesInterface[]
}
