import { ChangeDetectionStrategy, Component, inject, OnInit, signal } from '@angular/core';
import { LibrosService } from '../../services/libros.service';
import { Libro } from '../../interfaces/libros.interface';
import { LibroCard } from "../../components/libro-card/libro-card";

@Component({
  selector: 'app-lista-libros',
  imports: [LibroCard],
  templateUrl: './lista-libros.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class ListaLibros implements OnInit{

  ngOnInit(): void {

    this.mostrarLibros();

  }

  service= inject(LibrosService);

  libros= signal<Libro[]>([]);

  //Mostrar todos los libros
  mostrarLibros(){
    this.service.cargarLibros()
    .subscribe((respuesta)=>{
      this.libros.set(respuesta)
    });
  }
}
