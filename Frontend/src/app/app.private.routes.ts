import { Routes } from '@angular/router';
import { authGuard } from './auth/guards/authGuard.guard';

/**
 * Rutas privadas: zona principal de la aplicación.
 * Comparten layout (LayoutComponent) que pinta el menú de Biblioteca.
 *
 * Política de protección:
 *   - Listado y detalle: accesibles para visitantes (sin login).
 *   - Crear (/nuevo) y editar (/:id/editar): protegidas con authGuard.
 */
export const privateRoutes: Routes = [
  {
    path: '',
    loadComponent: () =>
      import('./shared/components/layout-component/layout-component'),
    children: [
      // Libros
      { path: 'libros', loadComponent: () => import('./libros/pages/lista-libros/lista-libros') },
      { path: 'libros/nuevo', loadComponent: () => import('./libros/pages/nuevo-libro/nuevo-libro'), canActivate: [authGuard] },
      { path: 'libros/:id', loadComponent: () => import('./libros/pages/detalle-libros/detalle-libros') },
      { path: 'libros/:id/editar', loadComponent: () => import('./libros/pages/editar-libro/editar-libro'), canActivate: [authGuard] },

      // Autores
      { path: 'autores', loadComponent: () => import('./autores/pages/lista-autores/lista-autores') },
      { path: 'autores/nuevo', loadComponent: () => import('./autores/pages/nuevo-autor/nuevo-autor'), canActivate: [authGuard] },
      { path: 'autores/:id', loadComponent: () => import('./autores/pages/detalle-autores/detalle-autores') },
      { path: 'autores/:id/editar', loadComponent: () => import('./autores/pages/editar-autor/editar-autor'), canActivate: [authGuard] },

      // Géneros
      { path: 'generos', loadComponent: () => import('./generos/pages/lista-generos/lista-generos') },
      { path: 'generos/nuevo', loadComponent: () => import('./generos/pages/nuevo-genero/nuevo-genero'), canActivate: [authGuard] },
      { path: 'generos/:id', loadComponent: () => import('./generos/pages/detalle-genero/detalle-genero') },
      { path: 'generos/:id/editar', loadComponent: () => import('./generos/pages/editar-genero/editar-genero'), canActivate: [authGuard] },

      // Préstamos
      { path: 'prestamos', loadComponent: () => import('./prestamos/pages/lista-prestamos/lista-prestamos') },
      { path: 'prestamos/nuevo', loadComponent: () => import('./prestamos/pages/nuevo-prestamo/nuevo-prestamo'), canActivate: [authGuard] },
      { path: 'prestamos/:id', loadComponent: () => import('./prestamos/pages/detalle-prestamo/detalle-prestamo') },

      // Cualquier otra ruta vuelve al listado de libros
      { path: '**', redirectTo: 'libros' },
    ],
  },
];
