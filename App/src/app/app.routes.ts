import { Routes } from '@angular/router';
import { authGuard } from './auth/guards/authGuard.guard';

export const routes: Routes = [
  { path: '', redirectTo: 'home', pathMatch: 'full' },

  {
    path: 'auth/login',
    loadComponent: () => import('./auth/pages/login-page/login-page'),
  },
  {
    path: 'auth/register',
    loadComponent: () => import('./auth/pages/register-page/register-page'),
  },

  {
    path: 'home',
    loadComponent: () => import('./home/home.page').then(m => m.HomePage),
    canActivate: [authGuard],
  },
];
