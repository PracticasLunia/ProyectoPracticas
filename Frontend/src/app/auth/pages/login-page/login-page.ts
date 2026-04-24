import { ChangeDetectionStrategy, Component, inject, signal } from '@angular/core';
import { FormBuilder, ReactiveFormsModule } from '@angular/forms';
import { AuthService } from '../../services/authService.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login-page',
  imports: [ReactiveFormsModule],
  templateUrl: './login-page.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class LoginPage {

  //Inyeccion dependency
  fb=inject(FormBuilder);
  service= inject(AuthService);
  router= inject(Router);

  //Variables---------------

  formulario=this.fb.group({
    email: [''],
    password: [''],
  })

  errorLogin=signal('');

  //Metodos-------------

  onSubmit(){

    const datos={
      email: this.formulario.value.email ?? '',
      password: this.formulario.value.password ?? '',
    }

    this.service.login(datos.email, datos.password)
    .subscribe({
      next:(respuesta)=>{
        this.service.guardarToken(respuesta.token)
        this.router.navigate(['/libros']);

      },
      error:(err)=>{
        this.errorLogin.set('Credenciales incorrectas. Revisa email y password')
      },
    })
  }

}
