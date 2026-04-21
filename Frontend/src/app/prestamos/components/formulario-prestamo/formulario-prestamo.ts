import { ChangeDetectionStrategy, Component, inject, OnInit, signal } from '@angular/core';
import { FormBuilder, ReactiveFormsModule } from '@angular/forms';
import { PrestamoService } from '../../services/prestamo.service';
import { Router, ActivatedRoute, RouterLink } from '@angular/router';
import { Libro } from '../../../libros/interfaces/libros.interface';
import { LibrosService } from '../../../libros/services/libros.service';
import { map } from 'rxjs';

@Component({
  selector: 'app-formulario-prestamo',
  imports: [ReactiveFormsModule, RouterLink],
  templateUrl: './formulario-prestamo.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class FormularioPrestamo implements OnInit{

  ngOnInit(): void {
    this.filtrarLibrosDisponibles();
  }

  //Inyeccion de dependencias y servicios

  service= inject(PrestamoService);
  serviceLibro= inject(LibrosService);
  fb=inject(FormBuilder);
  router=inject(Router);
  activatedRoute= inject(ActivatedRoute);

  //Variables

  idRuta=this.activatedRoute.snapshot.params['id'];
  libros=signal<Libro[]|null>(null); //Carga de select de libros


  /*  nombre_lector:             string;
  email_lector:              string;
  fecha_prestamo:            Date;
  fecha_devolucion_prevista: Date;
  fecha_devolucion_real:     Date;
  observaciones:             string;*/

  //Formulario
  formulario=this.fb.group({
    libro_id: [0],
    nombre_lector: [''],
    email_lector: [''],
    fecha_prestamo: [''],
    fecha_devolucion_prevista: [''],
    observaciones: [''],
  })

  //Metodos

  onSubmit(){
    const errores={}

    const datos={
      libro_id: this.formulario.value.libro_id,
      nombre_lector: this.formulario.value.nombre_lector,
      email_lector: this.formulario.value.email_lector,
      fecha_prestamo: this.formulario.value.fecha_prestamo,
      fecha_devolucion_prevista: this.formulario.value.fecha_devolucion_prevista,
      observaciones: this.formulario.value.observaciones
    }

    if(this.idRuta!=null){
      //Actualizar
    }
    else{
      //Crear
      this.service.crearPrestamo(datos)
      .subscribe({
        next: (respuesta)=>{
          this.router.navigate(['/prestamos']);
        },
        error:(err)=>{
          if(err.status===422){
            const errores= err.error.errors;
            Object.keys(errores).forEach(campo => {
              const control = this.formulario.get(campo);
              if (control) {
                control.setErrors({ backend: errores[campo][0] });
              }
            });
          }
        },
      })
    }

  }

  //Filtrar para mostrar en el select aquellos libros que si esten disponibles
  filtrarLibrosDisponibles(){
    this.serviceLibro.cargarLibros()
    //Filtrar con pipe los datos antes que lleguen al suscribe
    .pipe(
      map(respuestas=>respuestas.data!
        .filter(respuesta=>respuesta.disponible)
      )
    )
    .subscribe({
      next:(value)=>{
        this.libros.set(value);
      },
    })

  }

}
