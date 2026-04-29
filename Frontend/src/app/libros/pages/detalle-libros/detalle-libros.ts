import { ChangeDetectionStrategy, Component, computed, inject, OnInit, signal } from '@angular/core';
import { LibrosService } from '../../services/libros.service';
import { Libro } from '../../interfaces/libros.interface';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { environment } from '../../../../environments/environment';
import {PdfViewerModule } from 'ng2-pdf-viewer';
import { DatePipe } from '@angular/common';
import { PrestamoService } from '../../../prestamos/services/prestamo.service';
import { AuthService } from '../../../auth/services/authService.service';

@Component({
  selector: 'app-detalle-libros',
  imports: [RouterLink, PdfViewerModule, DatePipe],
  templateUrl: './detalle-libros.html',
  changeDetection: ChangeDetectionStrategy.OnPush,

})

export default class DetalleLibros implements OnInit {

  ngOnInit(): void{
    this.detalleLibro(this.id);
  }

  //Inyeccion de dependencias

  service= inject(LibrosService);
  servicePrestamos=inject(PrestamoService);
  serviceAuth= inject(AuthService);

  //Variables

  activateRoute= inject(ActivatedRoute);
  router= inject(Router);
  urlBackend=environment.urlBackend;
  //Contendra mensaje debido al posible error del backend de fk
  errorEliminar=signal('');
  //Paginacion
  paginaActual = signal(1);
  totalPaginas = signal(0);
  //Tomar el id de la ruta
  id= inject(ActivatedRoute).snapshot.params['id'];
  //Informacion del libro, valor inicial nulo
  libro= signal<Libro|null>(null);
  prestamoActivo = computed(() => this.libro()?.prestamo_activo ?? null);

  //Metodos

  //Detalle de un solo libro
  detalleLibro(id:number){
    this.service.cargarLibroById(id)
    .subscribe((respuesta)=>{
      if(respuesta.data)
        {
          this.libro.set(respuesta.data)
        }
    })
  }

  eliminar(){
    if(!confirm('¿Seguro que quieres eliminar a este libro?')) return;

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

  urlContenido(id: number): string {
    return `${this.urlBackend}/libros/${id}/contenido`;
  }

  onPdfCargado(pdf: any) {
    this.totalPaginas.set(pdf.numPages);
  }

  formatearTamano(bytes: number | null | undefined): string {
    if (!bytes) return '';
    if (bytes < 1024) return `${bytes} B`;
    if (bytes < 1024 * 1024) return `${(bytes / 1024).toFixed(1)} KB`;
    return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
  }

  marcarDevuelto(id:number){
    this.servicePrestamos.devolverPrestamo(id)
    .subscribe({
      next:(value)=> {
        this.router.navigate(['/prestamos']);
      },
    })
  }

}
