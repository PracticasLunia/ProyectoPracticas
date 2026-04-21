import { Prestamo } from './../../interfaces/prestamo.interface';
import { ChangeDetectionStrategy, Component, inject, OnInit, signal } from '@angular/core';
import { PrestamoService } from '../../services/prestamo.service';
import { environment } from '../../../../environments/environment';
import { RouterLink } from '@angular/router';
import { DatePipe } from '@angular/common';
import { LibrosService } from '../../../libros/services/libros.service';

@Component({
  selector: 'app-lista-prestamos',
  imports: [RouterLink, DatePipe],
  templateUrl: './lista-prestamos.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class ListaPrestamos implements OnInit{

  ngOnInit(): void {
    this.mostrarPrestamos();
  }

  //Inyeccion de servicios y dependencias
  service= inject(PrestamoService)
  serviceLibro= inject(LibrosService);

  //Variables
  prestamos= signal<Prestamo[]>([]);

  mostrarPrestamos(){
    this.service.cargarPrestamos()
    .subscribe({
      next:(respuesta)=>{
        this.prestamos.set(respuesta.data!);

        //Por cada prestamo, con su id hacer peticion y conseguir nombre de ese libro
        respuesta.data!.forEach((prestamo: Prestamo) => {
            this.serviceLibro.cargarLibroById(prestamo.libro_id)
            .subscribe({
              next:(libroCompleto)=>{
              this.prestamos.update(lista =>
                lista.map(a =>
                  a.id === prestamo.id
                    ? {
                        ...a,
                        libro: libroCompleto.data!,
                      }
                    : a
                )
              );
              },
            })
        });
      }
    })
  }

}
