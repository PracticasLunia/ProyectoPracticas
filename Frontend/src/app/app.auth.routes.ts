import { Routes } from '@angular/router';

export const authRoutes: Routes = [
  {
    path: 'auth',
    loadComponent: () => import('./shared/components/layout-component/layout-component'),
    children: [
      {
        path: 'login',
        loadComponent: () => import('./auth/pages/login-page/login-page')
      },
      {
        path: '',
        redirectTo: 'login',
      }
    ]
  }
];
