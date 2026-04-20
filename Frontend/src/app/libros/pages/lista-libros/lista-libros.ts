import { ChangeDetectionStrategy, Component, inject, OnInit, signal } from '@angular/core';
import { LibrosService } from '../../services/libros.service';
import { Libro } from '../../interfaces/libros.interface';
import { FormBuilder, ReactiveFormsModule } from '@angular/forms';
import { RouterLink } from '@angular/router';
import { environment } from '../../../../environments/environment';


@Component({
  selector: 'app-lista-libros',
  imports: [ReactiveFormsModule, RouterLink],
  templateUrl: './lista-libros.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class ListaLibros implements OnInit{

  ngOnInit(): void {
    this.mostrarLibros();
  }

  //Inyeccion de servicios-----
  service= inject(LibrosService);
  fb=inject(FormBuilder);

  //Variables-----
  libros= signal<Libro[]>([]);
  urlBackend = environment.urlBackend; //Acceso a la url del backend

  formulario=this.fb.group({
    titulo: [''],
    isbn: [''],
    autor: [''],
    genero_nombre: ['']
  })

  //Metodos-----

  //Metodo para mostrar todos los libros junto cargando tambien sus datos relacionados de autor y generos
  mostrarLibros(){
    this.service.cargarLibros()
    .subscribe((respuesta)=>{
      this.libros.set(respuesta.data!)

      //Por cada libro obtener su autor y genero
      respuesta.data!.forEach((libro: Libro) => {
        this.service.cargarLibroById(libro.id).subscribe({
          next: (libroCompleto) => {
            //Actualizar señal
            this.libros.update(lista =>
              lista.map(a =>
                a.id === libro.id
                  ? {
                      ...a,
                       autor: libroCompleto.data?.autor!,
                      generos: libroCompleto.data?.generos!,
                    }
                  : a
              )
            );
          }
        })
      });

    });
  }

  //Metodo que se ejecuta al subir el formulario para filtrar libros por campos de este
  onSubmit(){
    const urlForm= `titulo=${this.formulario.value.titulo}&ibsn=${this.formulario.value.isbn}&autor=${this.formulario.value.autor}&genero_nombre=${this.formulario.value.genero_nombre}`
        this.service.buscarLibrosFormulario(urlForm).subscribe((respuesta)=>{
        this.libros.set(respuesta);
    })
  }
}
