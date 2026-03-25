import { Libro } from './../../interfaces/libros.interface';
import { ChangeDetectionStrategy, Component, inject, OnInit, signal } from '@angular/core';
import { AbstractControl, FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { LibrosService } from '../../services/libros.service';
import { Autor } from '../../interfaces/autor.interface';
import { Genero } from '../../interfaces/genero.interface';
import { ActivatedRoute } from '@angular/router';
import { map } from 'rxjs';

@Component({
  selector: 'app-formulario-busqueda',
  imports: [ReactiveFormsModule],
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
  //Ruta activa
  idRuta= inject(ActivatedRoute).snapshot.params['id'];
  libro=signal<Libro|null>(null);

  //Campos formulario
  formulario=this.fb.group({
    titulo: [''],
    isbn: [''],
    anio_publicacion:[''],
    sinopsis: [''],
    num_paginas:[''],
    disponible:[true],
    autor_id: [''],
    genero_id: ['']
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
    if(this.idRuta!=null){
      //Establecer valores del libro
      this.service.cargarLibroById(id)
      .subscribe((respuesta)=>{
        this.libro.set(respuesta);
      })

      //Actualizar valores
      this.formulario.patchValue({
        titulo: this.libro()?.titulo
      })

    }
  }


  onSubmit(){
    const urlForm= `titulo=${this.formulario.value.titulo}&ibsn=${this.formulario.value.isbn}&autor=${this.formulario.value.autor_id}&genero_nombre=${this.formulario.value.genero_id}`
    console.log(urlForm);

      this.service.buscarLibrosFormulario(urlForm).subscribe((respuesta)=>{
      console.log(respuesta)

    })
    console.log(urlForm)
  }

}
