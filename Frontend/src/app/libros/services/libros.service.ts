import { HttpClient } from '@angular/common/http';
import { inject, Injectable, signal } from '@angular/core';
import { Libro } from '../interfaces/libros.interface';
import { environment } from '../../../environments/environment';
import { Autor } from '../../autores/interfaces/autor.interface';
import { Genero } from '../../generos/interfaces/genero.interface';


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


  actualizarLibro(datos:FormData, id:number){
    datos.append('_method', 'PUT');
    return this.http.post<Libro>(`${environment.urlBackend}/libros/${id}`, datos)
  }

  nuevoLibro(datos:FormData){
    return this.http.post<Libro>(`${environment.urlBackend}/libros`, datos)
  }

  eliminarLibro(id:number){
    return this.http.delete(`${environment.urlBackend}/libros/${id}`)
  }

  //Crear servicios especificos de autor y genero
  cargarAutores(){
    return this.http.get<Autor[]>(`${environment.urlBackend}/autores`)
  }

  cargarGeneros(){
    return this.http.get<Genero[]>(`${environment.urlBackend}/generos`)
  }

}
