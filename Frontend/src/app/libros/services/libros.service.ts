import { HttpClient } from '@angular/common/http';
import { inject, Injectable, signal } from '@angular/core';
import { Libro } from '../interfaces/libros.interface';
import { environment } from '../../../environments/environment';
import { Autor } from '../interfaces/autor.interface';
import { Genero } from '../interfaces/genero.interface';

@Injectable({
  providedIn: 'root'
})
export class LibrosService {

  //Inyection depency
  private http= inject(HttpClient);

  cargarLibros(){
    //Peticion
    return this.http.get<Libro[]>(`${environment.urlBackend}/libros`)
  }

  cargarLibroById(id:number){
    return this.http.get<Libro>(`${environment.urlBackend}/libros/${id}`)
  }

  buscarLibrosFormulario(urlForm:string){
    return this.http.get<Libro[]>
    (`${environment.urlBackend}/libros/buscar?${urlForm}`)
  }

  cargarAutores(){
    return this.http.get<Autor[]>(`${environment.urlBackend}/autores`)
  }

  cargarGeneros(){
    return this.http.get<Genero[]>(`${environment.urlBackend}/generos`)
  }



}
