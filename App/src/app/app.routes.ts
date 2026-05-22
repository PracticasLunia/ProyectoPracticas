import { Routes } from '@angular/router';
import { authGuard } from './auth/guards/authGuard.guard';

export const routes: Routes = [
  { path: '', redirectTo: 'catalogo', pathMatch: 'full' },

  {
    path: 'auth/login',
    loadComponent: () => import('./auth/pages/login-page/login-page'),
  },
  {
    path: 'auth/register',
    loadComponent: () => import('./auth/pages/register-page/register-page'),
  },

  {
    path: 'catalogo',
    loadComponent: () => import('./libros/pages/catalogo/catalogo.page'),
    canActivate: [authGuard],
  },
  {
    path: 'home',
    loadComponent: () => import('./home/home.page').then(m => m.HomePage),
    canActivate: [authGuard],
  },
  {
    path: 'libros/:id', loadComponent: () => import('./libros/pages/detalle-libro/detalle-libro.page'),
    canActivate: [authGuard]
  },
  {
    path: 'lector/:id', loadComponent: () => import('./libros/pages/lector.page/lector.page')
  }
];
