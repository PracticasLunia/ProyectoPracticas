import { HttpClient } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { environment } from '../../../environments/environment';
import { LibrosResponse } from '../interfaces/libroResponse.interface';
import { GenerosResponse } from 'src/app/generos/interfaces/generosResponse.interface';
import { LibroResponse } from '../interfaces/librosResponse.interface';

@Injectable({ providedIn: 'root' })
export class LibrosService {

  private http = inject(HttpClient);

  cargarLibros(): Observable<LibrosResponse> {
    return this.http.get<LibrosResponse>(`${environment.urlBackend}/libros`);
  }

  buscarLibros(urlForm: string): Observable<LibrosResponse> {
    return this.http.get<LibrosResponse>(`${environment.urlBackend}/libros/buscar?${urlForm}`);
  }

  buscarLibrosFormulario(urlForm:string): Observable<LibrosResponse>{
    return this.http.get<LibrosResponse>
    (`${environment.urlBackend}/libros/buscar?${urlForm}`)
  }

  cargarGeneros() {
    return this.http.get<GenerosResponse>(`${environment.urlBackend}/generos`);
  }

  urlPortada(id: number, version?: Date | string): string {
    const base = `${environment.urlBackend}/libros/${id}/portada`;
    return version ? `${base}?v=${version}` : base;
  }

  cargarLibroById(id:number): Observable<LibroResponse>{
    return this.http.get<LibroResponse>(`${environment.urlBackend}/libros/${id}`)
  }

  contenidoLibro(id:number): any {
    return this.http.get(`${environment.urlBackend}/libros/contenido/${id}/?download=1`)
  }
}

