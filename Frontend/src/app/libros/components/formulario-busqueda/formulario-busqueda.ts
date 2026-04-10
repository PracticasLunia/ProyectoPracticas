import { Libro } from './../../interfaces/libros.interface';
import { ChangeDetectionStrategy, Component, inject, OnInit, signal } from '@angular/core';
import { AbstractControl, FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { LibrosService } from '../../services/libros.service';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { map } from 'rxjs';
import { Autor } from '../../../autores/interfaces/autor.interface';
import { Genero } from '../../../generos/interfaces/genero.interface';

@Component({
  selector: 'app-formulario-busqueda',
  imports: [ReactiveFormsModule, RouterLink],
  templateUrl: './formulario-busqueda.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class FormularioBusqueda implements OnInit{

  ngOnInit(): void {
    this.cargarAutoresSelect()
    this.cargarGenerosSelect()
    this.determinarModo(this.idRuta);
  }

  //Inyenccion de servicios y dependencias
  service=inject(LibrosService);
  fb=inject(FormBuilder);
  router= inject(Router);
  //Ruta activa
  idRuta= inject(ActivatedRoute).snapshot.params['id'];
  libro=signal<Libro|null>(null);

  //Campos formulario
  formulario=this.fb.group({
    titulo: [''],
    isbn: [''],
    anio_publicacion:[0],
    sinopsis: [''],
    num_paginas:[0],
    disponible:[true],
    autor_id: [0],
    genero_ids: [[0]]
  })

  //Options pertenecientes al select de autor y generos
  autores= signal<Autor[]>([]);
  generos= signal<Genero[]>([]);

  //Cargar select de autores
  cargarAutoresSelect(){
    this.service.cargarAutores()
    .subscribe((respuesta)=>{
      this.autores.set(respuesta)
    })
  }

  //Cargar select de generos
  cargarGenerosSelect(){
    this.service.cargarGeneros()
    .subscribe((respuesta)=>{
      this.generos.set(respuesta)
    })
  }

  //Determinar si debe mostrar el formulario para actualizar y cargar datos o crear
  determinarModo(id:number){
    if(id!=null){
      //Establecer valores del libro
      this.service.cargarLibroById(id)
        .subscribe((respuesta)=>{
          this.libro.set(respuesta);

        //Actualizar valores
        this.formulario.patchValue({
          titulo: this.libro()?.titulo,
          isbn: this.libro()?.isbn,
          anio_publicacion: this.libro()?.publicacion,
          sinopsis: this.libro()?.sinopsis,
          autor_id: this.libro()?.autor_id,
          genero_ids: this.libro()?.generos.map(g => g.id) ?? [],
          num_paginas:this.libro()?.num_paginas,
          disponible:this.libro()?.disponible,
        })
      })
    }
  }

  onSubmit(){

    const errores={};

    const datos= {
      titulo: this.formulario.value.titulo,
      isbn: this.formulario.value.isbn,
      publicacion: this.formulario.value.anio_publicacion,
      sinopsis: this.formulario.value.sinopsis,
      num_paginas: this.formulario.value.num_paginas,
      disponible: this.formulario.value.disponible,
      autor_id: this.formulario.value.autor_id,
      genero_ids: this.formulario.value.genero_ids
      //genero_ids:this.generos().values
      //generos: this.generos()
    }

    const datosFormulario=this.formulario;

    if(this.idRuta!=null){
      this.service.actualizarLibro(datos, this.idRuta)
      .subscribe({
        next: (respuesta)=>{
          console.log('Actualizado correctamente')
          //Redirigir automaticamente
          this.router.navigate(['/libros']);
        },
        error(err) {
          if(err.status===422){
            const errores= err.error.errors;
            console.log(errores)
            Object.keys(errores).forEach(campo => {
              const control = datosFormulario.get(campo);
              if (control) {
                control.setErrors({ backend: errores[campo][0] });
              }
            });
          }
        },
      })
    }
    else{
      this.service.nuevoLibro(datos)
       .subscribe({
        next: (respuesta)=>{
          console.log('Creado correctamente')
          //Redirigir automaticamente
          this.router.navigate(['/libros']);
        },
        error(err) {
          if(err.status===422){
            const errores= err.error.errors;
            console.log(errores)
            Object.keys(errores).forEach(campo => {
              const control = datosFormulario.get(campo);
              if (control) {
                control.setErrors({ backend: errores[campo][0] });
              }
            });
          }
        },
      })
    }

  }

}
