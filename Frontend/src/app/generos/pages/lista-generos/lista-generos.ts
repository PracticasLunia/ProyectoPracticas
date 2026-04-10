import { ChangeDetectionStrategy, Component, inject, OnInit, signal } from '@angular/core';
import { GeneroService } from '../../services/genero.service';
import { Genero } from '../../interfaces/genero.interface';
import { RouterLink } from '@angular/router';

@Component({
  selector: 'app-lista-generos',
  imports: [RouterLink],
  templateUrl: './lista-generos.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class ListaGeneros implements OnInit {


  ngOnInit(): void {
    this.mostrarLibros();
  }

  service=inject(GeneroService);
  generos=signal<Genero[]>([]);

  mostrarLibros(){
    this.service.cargarGeneros()
    .subscribe({
      next: (respuesta)=>{
        this.generos.set(respuesta);
      },
    })
  }



}
