import { Component, ViewChild, signal } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { firstValueFrom } from 'rxjs';
import { IonContent, IonHeader, IonToolbar, IonButtons, IonMenuButton, IonTitle, IonFooter, IonInput, IonButton, IonIcon, IonItem, IonSpinner, IonCardContent, IonCardSubtitle, IonCardTitle, IonCardHeader, IonCard, IonGrid } from '@ionic/angular/standalone';
import { MessageInterface } from '../../interfaces/messageInterface';
import { AsistenteResponseInterface } from '../../interfaces/asistenteResponse.interface';
import { AsistenteService } from '../../services/asistenteService.service';

@Component({
  selector: 'app-asistente',
  templateUrl: './asistente.page.html',
  styleUrls: ['./asistente.page.scss'],
  standalone: true,
  imports: [
    FormsModule, IonHeader, IonToolbar, IonButtons, IonMenuButton, IonTitle,
    IonContent, IonFooter, IonInput, IonButton, IonIcon, IonItem, IonSpinner,
    IonCardContent, IonCardSubtitle, IonCardTitle, IonCardHeader, IonCard,
    IonGrid
],
})
export default class AsistentePage {

  @ViewChild(IonContent)
  private content?: IonContent;

  mensajes = signal<MessageInterface[]>([]);

  texto = signal('');

  cargando = signal(false);

  constructor(
    private chatService: AsistenteService
  ) {}

  async enviar(): Promise<void> {

    const mensaje = this.texto().trim();

    if (!mensaje || this.cargando()) {
      return;
    }

    //Añade el nuevo mensaje al historial de mensajes
    this.mensajes.update(actual => [
      ...actual,
      {
        role: 'user',
        content: mensaje,
      }
    ]);

    this.texto.set('');

    this.cargando.set(true);

    this.scrollBottom();

    try {

      //Envia la peticion con todo el historial de mensajes y recibe la devolucion del asistente
      const response = await firstValueFrom(
        this.chatService.enviarMensaje(this.mensajes())
      );

      //La respuesta se añade al historial
      this.mensajes.update(actual => [
        ...actual,
        {
          role: 'assistant',
          content: response.data?.texto ?? 'No pude generar respuesta.',
          citas: response.data?.citas ?? [],
        }
      ]);

    } catch {

      this.mensajes.update(actual => [
        ...actual,
        {
          role: 'assistant',
          content: 'Ha ocurrido un error. Inténtalo de nuevo más tarde.',
        }
      ]);

    } finally {

      this.cargando.set(false);

      this.scrollBottom();
    }
  }

  private scrollBottom(): void {

    setTimeout(() => {
      this.content?.scrollToBottom(300);
    }, 100);
  }
}
