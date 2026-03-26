import { Routes } from '@angular/router';

export const routes: Routes = [
  {
    path: 'libros',
    loadComponent:()=>import('./libros/pages/lista-libros/lista-libros'),
    /*children: [
      {
        path: ':id',
        loadComponent: ()=> import('./libros/pages/detalle-libros/detalle-libros'),
      },
    ]*/
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
  {
    path: 'libros/:id/eliminar',
    loadComponent:()=> import('./libros/pages/eliminar-libro/eliminar-libro')
  },
  //Redirect Libros
  {
    path: '**',
    redirectTo: 'libros',
  }
];
