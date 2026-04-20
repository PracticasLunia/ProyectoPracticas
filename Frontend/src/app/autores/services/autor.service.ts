import { HttpClient } from '@angular/common/http';
import { inject, Injectable, signal } from '@angular/core';
import { environment } from '../../../environments/environment';
import { Autor } from '../interfaces/autor.interface';
import { Observable } from 'rxjs';
import { Libro } from '../../libros/interfaces/libros.interface';
import { AutoresResponse, AutorResponse } from '../interfaces/autorResponse';
import { LibroResponse, LibrosResponse } from '../../libros/interfaces/librosResponse';
@Injectable({
  providedIn: 'root'
})


export class AutorService {

//Inyection depency
private http= inject(HttpClient);

  cargarAutores(): Observable<AutoresResponse> {
    return this.http.get<AutoresResponse>(`${environment.urlBackend}/autores`);
  }

  detalleAutor(autorId:number): Observable<AutorResponse>{
    return this.http.get<AutorResponse>(`${environment.urlBackend}/autores/${autorId}`);
  }

  cargarLibrosPorAutor(autorId: number):Observable<LibrosResponse>{
    return this.http.get<LibrosResponse>(`${environment.urlBackend}/autores/${autorId}/libros`);
  }

  crearAutor(datos:any): Observable<LibroResponse>{
    return this.http.post<LibroResponse>(`${environment.urlBackend}/autores`, datos);
  }

  actualizarAutor(autorId: number, datos: any): Observable<AutorResponse>{
    return this.http.put<AutorResponse>(`${environment.urlBackend}/autores/${autorId}`,datos);
  }

  eliminarAutor(idAutor:number){
    return this.http.delete(`${environment.urlBackend}/autores/${idAutor}`)
  }

}
