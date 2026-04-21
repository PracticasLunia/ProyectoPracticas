import { Prestamo } from './../interfaces/prestamo.interface';
import { HttpClient } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { PrestamoResponse } from '../interfaces/prestamoResponse';
import { environment } from '../../../environments/environment';
import { Observable } from 'rxjs';
import { PrestamosResponse } from '../interfaces/prestamosResponse';

@Injectable({
  providedIn: 'root'
})
export class PrestamoService {

  //Inyeccion de dependencias
  private http= inject(HttpClient);


  cargarPrestamos(): Observable<PrestamosResponse>{
    return this.http.get<PrestamosResponse>(`${environment.urlBackend}/prestamos`);
  }

  cargarPrestamoPorId(id:number): Observable<PrestamoResponse>{
    return this.http.get<PrestamoResponse>(`${environment.urlBackend}/prestamos/${id}`);
  }

  crearPrestamo(datos:any): Observable<PrestamoResponse>{
    return this.http.post<PrestamoResponse>(`${environment.urlBackend}/prestamos`, datos);
  }

  devolverPrestamo(id:number): Observable<PrestamoResponse>{
    return this.http.put<PrestamoResponse>(`${environment.urlBackend}/prestamos/${id}/devolver`,{});
  }

}
