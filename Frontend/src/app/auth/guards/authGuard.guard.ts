import { inject } from '@angular/core';
import type { CanActivateFn } from '@angular/router';
import { AuthService } from '../services/authService.service';

//Guard para verificar si un usuario esta logueado
export const authGuard: CanActivateFn = (route, state) => {
  const authService = inject(AuthService);
  return authService.estaLogueado();
};
