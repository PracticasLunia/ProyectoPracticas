export interface MessageInterface {
  role: 'user' | 'assistant'
  content: string
  citas?: {
    url: string
    title: string
  }[]
}
