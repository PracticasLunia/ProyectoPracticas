import { HttpClient } from '@angular/common/http';
import { inject, Injectable, signal } from '@angular/core';
import { environment } from '../../../environments/environment';
import { Genero } from '../interfaces/genero.interface';
import { Libro } from '../../libros/interfaces/libros.interface';

@Injectable({
  providedIn: 'root'
})
export class GeneroService {

  private http= inject(HttpClient);

  cargarGeneros(){
    return this.http.get<Genero[]>(`${environment.urlBackend}/generos`)
  }

  detalleGenero(generoId:number){
    return this.http.get<Genero>(`${environment.urlBackend}/generos/${generoId}`);
  }

  cargarLibrosPorGenero(generoId:number){
    return this.http.get<Libro[]>(`${environment.urlBackend}/generos/${generoId}/libros`);
  }

  actualizarGenero(generoId:number, datos:any){
    return this.http.put<Genero>(`${environment.urlBackend}/generos/${generoId}`, datos)
  }

  crearGenero(datos:any){
    return this.http.post<Genero>(`${environment.urlBackend}/generos`, datos);
  }

  eliminarGenero(generoId:number){
    return this.http.delete(`${environment.urlBackend}/generos/${generoId}`);
  }



}
