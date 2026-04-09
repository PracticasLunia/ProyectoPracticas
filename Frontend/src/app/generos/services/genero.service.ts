import { HttpClient } from '@angular/common/http';
import { inject, Injectable, signal } from '@angular/core';
import { environment } from '../../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class Genero {

  private http= inject(HttpClient);
  
  cargarGeneros(){
      return this.http.get<Genero[]>(`${environment.urlBackend}/generos`)
  }

}
