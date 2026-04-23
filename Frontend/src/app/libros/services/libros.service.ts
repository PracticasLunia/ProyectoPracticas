import { HttpClient } from '@angular/common/http';
import { inject, Injectable, signal } from '@angular/core';
import { Libro } from '../interfaces/libros.interface';
import { environment } from '../../../environments/environment';
import { Autor } from '../../autores/interfaces/autor.interface';
import { Genero } from '../../generos/interfaces/genero.interface';
import { Observable } from 'rxjs';
import { LibroResponse, LibrosResponse } from '../interfaces/librosResponse';


@Injectable({
  providedIn: 'root'
})
export class LibrosService {

  //Inyeccion de dependencias
  private http= inject(HttpClient);

  cargarLibros(): Observable<LibrosResponse>{
    return this.http.get<LibrosResponse>(`${environment.urlBackend}/libros`)
  }

  cargarLibroById(id:number): Observable<LibroResponse>{
    return this.http.get<LibroResponse>(`${environment.urlBackend}/libros/${id}`)
  }

  buscarLibrosFormulario(urlForm:string): Observable<LibrosResponse>{
    return this.http.get<LibrosResponse>
    (`${environment.urlBackend}/libros/buscar?${urlForm}`)
  }

  actualizarLibro(datos:FormData, id:number): Observable<LibroResponse>{
    datos.append('_method', 'PUT');
    return this.http.post<LibroResponse>(`${environment.urlBackend}/libros/${id}`, datos)
  }

  nuevoLibro(datos:FormData): Observable<LibroResponse>{
    return this.http.post<LibroResponse>(`${environment.urlBackend}/libros`, datos)
  }

  eliminarLibro(id:number){
    return this.http.delete(`${environment.urlBackend}/libros/${id}`)
  }

  //Uso de servicios externos
  cargarAutores(){
    return this.http.get<Autor[]>(`${environment.urlBackend}/autores`)
  }

  cargarGeneros(){
    return this.http.get<Genero[]>(`${environment.urlBackend}/generos`)
  }

}
