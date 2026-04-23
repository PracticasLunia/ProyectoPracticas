import { ChangeDetectionStrategy, Component, inject, OnInit, signal } from '@angular/core';
import { environment } from '../../../../environments/environment';
import { LibrosService } from '../../../libros/services/libros.service';
import { Prestamo } from '../../interfaces/prestamo.interface';
import { PrestamoService } from '../../services/prestamo.service';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { Libro } from '../../../libros/interfaces/libros.interface';
import { DatePipe } from '@angular/common';

@Component({
  selector: 'app-detalle-prestamo',
  imports: [RouterLink, DatePipe],
  templateUrl: './detalle-prestamo.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class DetallePrestamo implements OnInit{

  ngOnInit(): void {
    this.mostrarPrestamo();
    this.libroPrestamo();
  }

  //Inyeccion de servicios y dependencias

  service= inject(PrestamoService)
  serviceLibro= inject(LibrosService);
  activateRoute= inject(ActivatedRoute);
  router= inject(Router);

  //Variables

  prestamo= signal<Prestamo|null>(null);
  libro=signal<Libro|null>(null);
  urlBackend = environment.urlBackend; //Acceso a la url del backend
  id= this.activateRoute.snapshot.params['id'];

  //Metodos

  mostrarPrestamo(){
    this.service.cargarPrestamoPorId(this.id)
    .subscribe({
      next:(respuesta)=>{
        this.prestamo.set(respuesta.data!)
      }
    })
  }

  libroPrestamo(){
    this.serviceLibro.cargarLibroById(this.id)
    .subscribe({
      next:(respuesta)=>{
        this.libro.set(respuesta.data!);
      }
    })
  }

  marcarDevuelto(){
    this.service.devolverPrestamo(this.id)
    .subscribe({
      next:(value)=> {
        this.router.navigate(['/prestamos']);
      },
    })
  }

}
