import { HttpClient } from '@angular/common/http';
import { inject, Injectable } from '@angular/core';
import { environment } from '../../../environments/environment';
import { Observable } from 'rxjs';
import { AuthResponse } from '../interfaces/authResponse.interface';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  //Inyection depency
  private http= inject(HttpClient);

  //Metodos para autenticacion------------

  login(email: string, password: string):Observable<AuthResponse>{
    return this.http.post<AuthResponse>(`${environment.urlBackend}/login`, {
      email,
      password
    });
  }

  logout() {
    return this.http.post(`${environment.urlBackend}/logout`, {});
  }

  register(name: string, email: string, password: string, passwordConfirmation: string): Observable<AuthResponse> {
    return this.http.post<AuthResponse>(`${environment.urlBackend}/register`, {
      name,
      email,
      password,
      password_confirmation: passwordConfirmation,
    });
  }

   usuarioActual(){
     return this.http.get<AuthResponse>(`${environment.urlBackend}/user`);
   }

  devolverToken() {
    return localStorage.getItem('token');
  }

  guardarToken(token: string) {
    localStorage.setItem('token', token);
  }

  eliminarToken() {
    localStorage.removeItem('token');
  }

  estaLogueado(): boolean {
    return !!this.devolverToken(); //Convierte a boolean
  }


}
