import { Routes } from '@angular/router';

export const routes: Routes = [
  /*Path para libros*/
  {
    path: 'libros',
    loadComponent:()=>import('./libros/pages/lista-libros/lista-libros'),
  },
  {
    path: 'libros/nuevo',
    loadComponent:()=>import('./libros/pages/nuevo-libro/nuevo-libro'),
  },
  {
    path: 'libros/:id',
    loadComponent: ()=> import('./libros/pages/detalle-libros/detalle-libros'),
  },
  {
    path: 'libros/:id/editar',
    loadComponent:()=> import('./libros/pages/editar-libro/editar-libro')
  },

  /*Path para autores */
  {
    path: 'autores',
    loadComponent: ()=>import('./autores/pages/lista-autores/lista-autores')
  },
  {
    path: 'autores/nuevo',
    loadComponent:()=>import('./autores/pages/nuevo-autor/nuevo-autor')
  },
  {
    path: 'autores/:id',
    loadComponent: ()=>import('./autores/pages/detalle-autores/detalle-autores')
  },
  {
    path: 'autores/:id/editar',
    loadComponent: ()=>import('./autores/pages/editar-autor/editar-autor')
  },

  /**Path para generos*/
  {
    path: 'generos',
    loadComponent: ()=>import('./generos/pages/lista-generos/lista-generos')
  },
  {
    path: 'generos/nuevo',
    loadComponent: ()=>import('./generos/pages/nuevo-genero/nuevo-genero')
  },
  {
    path: 'generos/:id',
    loadComponent:()=>import('./generos/pages/detalle-genero/detalle-genero')
  },
  {
    path: 'generos/:id/editar',
    loadComponent:()=>import('./generos/pages/editar-genero/editar-genero')
  },

  //Path para prestamos
  {
    path: 'prestamos',
    loadComponent:()=>import('./prestamos/pages/lista-prestamos/lista-prestamos')
  },
  {
    path: 'prestamos/:id',
    loadComponent:()=>import('./prestamos/pages/detalle-prestamo/detalle-prestamo')
  },
  /*
  {

  },*/

  //Redigire a /libros para cualquier ruta no definida anteriormente
  {
    path: '**',
    redirectTo: 'libros',
  }
];
