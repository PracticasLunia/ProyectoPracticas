import { ChangeDetectionStrategy, Component, inject, OnInit, signal } from '@angular/core';
import { PrestamoService } from '../../services/prestamo.service';
import { environment } from '../../../../environments/environment';
import { Prestamo } from '../../interfaces/prestamo.interface';
import { RouterLink } from '@angular/router';
import { DatePipe } from '@angular/common';

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

  //Variables
  prestamos= signal<Prestamo[]>([]);
  urlBackend = environment.urlBackend; //Acceso a la url del backend

  mostrarPrestamos(){
    this.service.cargarPrestamos()
    .subscribe({
      next:(respuesta)=>{
        this.prestamos.set(respuesta.data!);
      }
    })
  }

}
