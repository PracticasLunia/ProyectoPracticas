import { HttpClient } from '@angular/common/http';
import { inject, Injectable, signal } from '@angular/core';
import { Libro } from '../interfaces/libros.interface';
import { environment } from '../../../environments/environment';

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

}
