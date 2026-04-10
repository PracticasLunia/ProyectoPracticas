import { HttpClient } from '@angular/common/http';
import { inject, Injectable, signal } from '@angular/core';
import { environment } from '../../../environments/environment';
import { Autor } from '../interfaces/autor.interface';
import { Observable } from 'rxjs';
import { Libro } from '../../libros/interfaces/libros.interface';
@Injectable({
  providedIn: 'root'
})


export class AutorService {

//Inyection depency
private http= inject(HttpClient);

  cargarAutores(): Observable<Autor[]> {
    return this.http.get<Autor[]>(`${environment.urlBackend}/autores`);
  }

  detalleAutor(autorId:number){
    return this.http.get<Autor>(`${environment.urlBackend}/autores/${autorId}`);
  }

  cargarLibrosPorAutor(autorId: number) {
    return this.http.get<Libro[]>(`${environment.urlBackend}/autores/${autorId}/libros`);
  }

  crearAutor(datos:any){
    return this.http.post<Libro>(`${environment.urlBackend}/autores`, datos);
  }

  actualizarAutor(autorId: number, datos: any){
    return this.http.put<Autor>(`${environment.urlBackend}/autores/${autorId}`,datos);
  }

  eliminarAutor(idAutor:number){
    return this.http.delete(`${environment.urlBackend}/autores/${idAutor}`)
  }

}
