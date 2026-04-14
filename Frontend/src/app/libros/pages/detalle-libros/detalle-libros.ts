import { ChangeDetectionStrategy, Component, inject, OnInit, signal } from '@angular/core';
import { LibrosService } from '../../services/libros.service';
import { Libro } from '../../interfaces/libros.interface';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { JsonPipe } from '@angular/common';
import { environment } from '../../../../environments/environment';
@Component({
  selector: 'app-detalle-libros',
  imports: [RouterLink],
  templateUrl: './detalle-libros.html',
  changeDetection: ChangeDetectionStrategy.OnPush,

})
export default class DetalleLibros implements OnInit {

  ngOnInit(): void{
    this.detalleLibro(this.id);
  }

  activateRoute= inject(ActivatedRoute);
  router= inject(Router);
  urlBackend=environment.urlBackend;
  //Contendra mensaje debido al posible error del backend de fk
  errorEliminar=signal('');

  //Tomar el id de la ruta
  id= inject(ActivatedRoute).snapshot.params['id'];

  //Informacion del libro, valor inicial nulo
  libro= signal<Libro|null>(null);

  //Inyection dependency
  service= inject(LibrosService);

  //Detalle de un solo libro
  detalleLibro(id:number){
    this.service.cargarLibroById(id)
    .subscribe((respuesta)=>{
      this.libro.set(respuesta)
      console.log(respuesta);
    })
  }

    eliminar(){
    if(!confirm('¿Seguro que quieres eliminar a este género?')) return;

    this.service.eliminarLibro(this.id)
    .subscribe({
      next:(value)=>{
        this.router.navigate(['/libros']);
      },
      error:(err)=>{
        this.errorEliminar.set('No se puede eliminar este libro');
      },
    })

  }

}
