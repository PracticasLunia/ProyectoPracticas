import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { AuthService } from '../services/authService.service';

export const authGuard: CanActivateFn = (route, state) => {
  const authService = inject(AuthService);
  const router = inject(Router);

  if (authService.estaLogueado()) {
    return true;
  }
  //Los guards no ejecutan navegación directamente. Solo pueden decidir el resultado de la navegación actual.
  return router.createUrlTree(['/auth/login']);
};
