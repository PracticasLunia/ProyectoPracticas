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
    path: 'libros/:id',
    loadComponent: ()=> import('./libros/pages/detalle-libros/detalle-libros'),
  },


  //Redirect Libros
  {
    path: '**',
    redirectTo: 'libros',
  }
];
