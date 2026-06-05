import { ChangeDetectionStrategy, Component, computed, inject, OnInit, signal } from '@angular/core';
import { LibrosService } from '../../services/libros.service';
import { Libro } from '../../interfaces/libros.interface';
import { FormBuilder, ReactiveFormsModule } from '@angular/forms';
import { RouterLink } from '@angular/router';
import { environment } from '../../../../environments/environment';
import { AuthService } from '../../../auth/services/authService.service';


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
  serviceAuth= inject(AuthService);
  fb=inject(FormBuilder);

  //Variables-----
  libros= signal<Libro[]>([]);
  urlBackend = environment.urlBackend; //Acceso a la url del backend
  //Pagination
  paginaActual = signal(1);
  totalPaginas = signal(1);
  paginas = computed(() => Array.from({ length: this.totalPaginas() }, (_, i) => i + 1));
  formulario=this.fb.group({
    titulo: [''],
    isbn: [''],
    autor: [''],
    genero_nombre: ['']
  })

  //Metodos-----

  //Metodo para mostrar todos los libros junto cargando tambien sus datos relacionados de autor y generos
  mostrarLibros(){
    this.paginaActual.set(1);
    this.service.buscarLibrosFormulario(`${this.contruirUrlBuscar()}&page=1`)
    .subscribe((respuesta)=>{
      this.libros.set(respuesta.data!)
      this.totalPaginas.set(respuesta.meta?.last_page ?? 1);

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
    this.paginaActual.set(1);
    const urlForm=`${this.contruirUrlBuscar()}&page=1`;
    this.service.buscarLibrosFormulario(urlForm).subscribe((respuesta)=>{
    this.libros.set(respuesta.data!);

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

    })
  }

  private contruirUrlBuscar() {
    return `titulo=${this.formulario.value.titulo}&isbn=${this.formulario.value.isbn}&autor=${this.formulario.value.autor}&genero_nombre=${this.formulario.value.genero_nombre}`
  }

  cargarPagina(pagina: number) {
  this.paginaActual.set(pagina);
  const url = `${this.contruirUrlBuscar()}&page=${pagina}`;   // mantiene los filtros del buscador
  this.service.buscarLibrosFormulario(url).subscribe((resp) => {
    this.libros.set(resp.data ?? []);
    this.totalPaginas.set(resp.meta?.last_page ?? 1);

    //Por cada libro obtener su autor y genero
    resp.data!.forEach((libro: Libro) => {
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
}
