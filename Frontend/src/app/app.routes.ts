import { Routes } from '@angular/router';

/**
 * Router raíz: solo decide a qué bloque entra la URL.
 *
 *   /auth/...  -> rutas públicas (login y futuras de registro).
 *   /...       -> rutas privadas (la aplicación de Biblioteca).
 *
 * Los layouts y la lógica concreta viven en cada fichero hijo.
 */
export const routes: Routes = [
  {
    path: 'auth',
    loadChildren: () =>
      import('./app.public.routes').then((m) => m.publicRoutes),
  },
  {
    path: '',
    loadChildren: () =>
      import('./app.private.routes').then((m) => m.privateRoutes),
  },
];
