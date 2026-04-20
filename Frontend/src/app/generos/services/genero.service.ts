import { HttpClient } from '@angular/common/http';
import { inject, Injectable, signal } from '@angular/core';
import { environment } from '../../../environments/environment';
import { Genero } from '../interfaces/genero.interface';
import { Libro } from '../../libros/interfaces/libros.interface';
import { Observable } from 'rxjs';
import { GeneroResponse, GenerosResponse } from '../interfaces/generoResponse';
import { LibrosResponse } from '../../libros/interfaces/librosResponse';

@Injectable({
  providedIn: 'root'
})
export class GeneroService {

  private http= inject(HttpClient);

  cargarGeneros(): Observable<GenerosResponse>{
    return this.http.get<GenerosResponse>(`${environment.urlBackend}/generos`)
  }

  detalleGenero(generoId:number): Observable<GeneroResponse>{
    return this.http.get<GeneroResponse>(`${environment.urlBackend}/generos/${generoId}`);
  }

  cargarLibrosPorGenero(generoId:number): Observable<LibrosResponse>{
    return this.http.get<LibrosResponse>(`${environment.urlBackend}/generos/${generoId}/libros`);
  }

  actualizarGenero(generoId:number, datos:any): Observable<GeneroResponse>{
    return this.http.put<GeneroResponse>(`${environment.urlBackend}/generos/${generoId}`, datos)
  }

  crearGenero(datos:any): Observable<GeneroResponse>{
    return this.http.post<GeneroResponse>(`${environment.urlBackend}/generos`, datos);
  }

  eliminarGenero(generoId:number){
    return this.http.delete(`${environment.urlBackend}/generos/${generoId}`);
  }



}
