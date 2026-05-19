import { HttpClient } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from '../../../environments/environment';
import { Libro } from '../interfaces/libro.interface';

@Injectable({ providedIn: 'root' })
export class LibrosService {

  private http = inject(HttpClient);

  cargarLibros(): Observable<Libro[]> {
    return this.http.get<Libro[]>(`${environment.urlBackend}/libros`);
  }

  buscarLibros(urlForm: string): Observable<Libro[]> {
    return this.http.get<Libro[]>(`${environment.urlBackend}/libros/buscar?${urlForm}`);
  }

  cargarGeneros() {
    return this.http.get<{ id: number; nombre: string }[]>(`${environment.urlBackend}/generos`);
  }

  urlPortada(id: number): string {
    return `${environment.urlBackend}/libros/${id}/portada`;
  }
}

