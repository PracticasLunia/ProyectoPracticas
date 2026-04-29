import { ChangeDetectionStrategy, Component, inject, OnInit, signal } from '@angular/core';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { GeneroService } from '../../services/genero.service';
import { Genero } from '../../interfaces/genero.interface';
import { Libro } from '../../../libros/interfaces/libros.interface';
import { AuthService } from '../../../auth/services/authService.service';

@Component({
  selector: 'app-detalle-genero',
  imports: [RouterLink],
  templateUrl: './detalle-genero.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class DetalleGenero implements OnInit {

  ngOnInit(): void {
    this.detalleDelGenero(this.idRuta);
    this.librosDelGenero(this.idRuta);
  }

  //Inyeccion de dependencias
  service=inject(GeneroService)
  serviceAuth= inject(AuthService);
  activateRoute= inject(ActivatedRoute);
  router= inject(Router);

  //Valores del genero y sus libros
  genero=signal<Genero|null>(null);
  librosDeGenero=signal<Libro[]|null>(null);

  //Contendra mensaje debido al posible error del backend de fk
  errorEliminar=signal('');

  //Tomar el id de la ruta
  idRuta= inject(ActivatedRoute).snapshot.params['id'];

  detalleDelGenero(id:number){
    this.service.detalleGenero(id)
    .subscribe({
      next:(respuesta)=>{
        this.genero.set(respuesta.data!);
      },
    })
  }

  librosDelGenero(id:number){
    this.service.cargarLibrosPorGenero(id)
    .subscribe({
      next:(respuesta)=>{
        this.librosDeGenero.set(respuesta.data!);
      },
    })
  }

  //Confirmacion para eliminar al genero
  eliminar(){
    if(!confirm('¿Seguro que quieres eliminar a este género?')) return;

    this.service.eliminarGenero(this.idRuta)
    .subscribe({
      next:(value)=>{
        this.router.navigate(['/generos']);
      },
      error:(err)=>{
        this.errorEliminar.set('No se puede eliminar este genero, tiene libros asociados');
      },
    })

  }

}
