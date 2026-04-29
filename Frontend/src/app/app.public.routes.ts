import { Routes } from '@angular/router';

/**
 * Rutas públicas: zona accesible sin sesión iniciada.
 * Comparten layout (LayoutAuthComponent) que pinta una shell limpia,
 * sin el menú principal de la aplicación.
 */
export const publicRoutes: Routes = [
  {
    path: '',
    loadComponent: () =>
      import('./shared/components/layout-auth-component/layout-auth-component'),
    children: [
      {
        path: 'login',
        loadComponent: () => import('./auth/pages/login-page/login-page'),
      },
      // TODO: cuando llegue la fase de registro, descomentar y crear el componente.
      // {
      //   path: 'register',
      //   loadComponent: () => import('./auth/pages/register-page/register-page'),
      // },
      {
        path: '',
        redirectTo: 'login',
        pathMatch: 'full',
      },
    ],
  },
];
