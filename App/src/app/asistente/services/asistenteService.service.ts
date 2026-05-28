import { HttpClient } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { AsistenteResponseInterface } from '../interfaces/asistenteResponse.interface';
import { environment } from 'src/environments/environment';
import { MessageInterface } from '../interfaces/messageInterface';

@Injectable({
  providedIn: 'root',
})
export class AsistenteService {

  //Inyection depency
  private http= inject(HttpClient);

  enviarMensaje(historial: MessageInterface[]): Observable <AsistenteResponseInterface>{

    //Filtrar las citas al modelo
    const payload = {
      messages: historial.map(m => ({
        role: m.role,
        content: m.content,
      })),
    };

    return this.http.post<AsistenteResponseInterface>(`${environment.urlBackend}/chat`, payload)
  }

}
