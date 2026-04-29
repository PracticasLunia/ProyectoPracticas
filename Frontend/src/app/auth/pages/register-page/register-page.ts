import { ChangeDetectionStrategy, Component, inject, signal } from '@angular/core';
import { AbstractControl, FormBuilder, ReactiveFormsModule, ValidationErrors, Validators } from '@angular/forms';
import { Router, RouterLink } from '@angular/router';
import { AuthService } from '../../services/authService.service';

@Component({
  selector: 'app-register-page',
  imports: [ReactiveFormsModule, RouterLink],
  templateUrl: './register-page.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class RegisterPage {

  fb = inject(FormBuilder);
  service = inject(AuthService);
  router = inject(Router);

  errorRegistro = signal('');

  formulario = this.fb.group(
    {
      name: ['', [Validators.required, Validators.maxLength(255)]],
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required, Validators.minLength(8)]],
      password_confirmation: ['', [Validators.required]],
    },
    { validators: this.passwordsCoinciden }
  );

  /**
   * Validador a nivel de grupo: comprueba que password y password_confirmation
   * tienen el mismo valor. Si no, devuelve un error 'noCoincide'.
   */
  passwordsCoinciden(grupo: AbstractControl): ValidationErrors | null {
    const pass = grupo.get('password')?.value;
    const conf = grupo.get('password_confirmation')?.value;
    return pass && conf && pass !== conf ? { noCoincide: true } : null;
  }

  onSubmit() {
    if (this.formulario.invalid) {
      return;
    }

    const datos = {
      name: this.formulario.value.name ?? '',
      email: this.formulario.value.email ?? '',
      password: this.formulario.value.password ?? '',
      password_confirmation: this.formulario.value.password_confirmation ?? '',
    };

    this.service
      .register(datos.name, datos.email, datos.password, datos.password_confirmation)
      .subscribe({
        next: (respuesta) => {
          this.service.guardarToken(respuesta.token);
          this.router.navigate(['/libros']);
        },
        error: (err) => {
          if (err.status === 422) {
            this.errorRegistro.set('Revisa los datos: el email ya esta en uso o las contraseñas no son validas.');
          } else {
            this.errorRegistro.set('No se ha podido crear la cuenta. Intentalo de nuevo en un momento.');
          }
        },
      });
  }
}
