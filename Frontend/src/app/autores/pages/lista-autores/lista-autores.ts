import { ChangeDetectionStrategy, signal, Component, inject, OnInit } from '@angular/core';
import { AutorService } from '../../services/autor.service';
import { Autor } from '../../interfaces/autor.interface';
import { RouterLink } from '@angular/router';
import { DatePipe, JsonPipe } from '@angular/common';

@Component({
  selector: 'app-lista-autores',
  imports: [RouterLink, DatePipe],
  templateUrl: './lista-autores.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class ListaAutores implements OnInit {

  ngOnInit(): void {
    this.mostrarGeneros()
  }

  //Inyeccion de servicio
  service= inject(AutorService);

  //Variable propias
  autores= signal<Autor[]>([]);

  mostrarGeneros(){
    this.service.cargarAutores()
    .subscribe((respuesta)=>{
      this.autores.set(respuesta.data!);

      //Por cada autor modificar su propiedad de Libro[], con un peticion para cada de estos
      respuesta.data!.forEach((autor: Autor) => {
        this.service.cargarLibrosPorAutor(autor.id).subscribe({
          next: (librosAutor) => {
            //Actualizar señal
            this.autores.update(lista =>
              lista.map(a =>
                a.id === autor.id
                  ? { ...a, libros: librosAutor.data!}
                  : a
              )
            );
          }
        })
      });

    });
  }

}
