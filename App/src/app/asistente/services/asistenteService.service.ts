import { HttpClient } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { AsistenteResponseInterface } from '../interfaces/asistenteResponse.interface';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root',
})
export class AsistenteService {

  //Inyection depency
  private http= inject(HttpClient);

  enviarMensaje(texto: string): Observable <AsistenteResponseInterface>{
    return this.http.post<AsistenteResponseInterface>(`${environment.urlBackend}/chat`,{ message: texto})
  }








}
