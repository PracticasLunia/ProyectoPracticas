import { ChangeDetectionStrategy, signal, Component, inject, OnInit } from '@angular/core';
import { AutorService } from '../../services/autor.service';
import { Autor } from '../../interfaces/autor.interface';
import { RouterLink } from '@angular/router';
import { JsonPipe } from '@angular/common';

@Component({
  selector: 'app-lista-autores',
  imports: [RouterLink, JsonPipe],
  templateUrl: './lista-autores.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class ListaAutores implements OnInit {

  ngOnInit(): void {
    this.mostrarGeneros()
  }

  service= inject(AutorService);
  autores= signal<Autor[]>([]);

  mostrarGeneros(){
    this.service.cargarAutores()
    .subscribe((respuesta)=>{
      this.autores.set(respuesta);

      respuesta.forEach((autor: Autor) => {
        this.service.cargarLibrosPorAutor(autor.id).subscribe({
          next: (librosAutor) => {
            console.log();
            autor.libros = librosAutor.libros;
          }
        })
      });
       this.autores.set(respuesta);
    });
  }


}
