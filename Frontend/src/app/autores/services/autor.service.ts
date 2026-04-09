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
    return this.http.get<Autor[]>(`${environment.urlBackend}/autores`)
  }

  cargarLibrosPorAutor(autorId: number): Observable<Autor> {
    return this.http.get<Autor>(`${environment.urlBackend}/autores/${autorId}/libros`)
  }

}
