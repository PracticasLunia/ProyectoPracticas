import { ChangeDetectionStrategy, Component, inject, OnInit, signal } from '@angular/core';
import { LibrosService } from '../../services/libros.service';
import { Libro } from '../../interfaces/libros.interface';
import { ActivatedRoute, Router} from '@angular/router';
import { JsonPipe } from '@angular/common';
@Component({
  selector: 'app-detalle-libros',
  imports: [],
  templateUrl: './detalle-libros.html',
  changeDetection: ChangeDetectionStrategy.OnPush,

})
export default class DetalleLibros implements OnInit {

  ngOnInit(): void{
    this.detalleLibro(this.id);
  }

  activateRoute= inject(ActivatedRoute);
  router= inject(Router);

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

}
