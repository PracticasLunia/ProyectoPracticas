import { ChangeDetectionStrategy, Component, inject, OnInit, signal } from '@angular/core';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { Autor } from '../../interfaces/autor.interface';
import { AutorService } from '../../services/autor.service';
import { Libro } from '../../../libros/interfaces/libros.interface';
import { Observable } from 'rxjs';
import { DatePipe } from '@angular/common';
import { AuthService } from '../../../auth/services/authService.service';

@Component({
  selector: 'app-detalle-autores',
  imports: [RouterLink, DatePipe],
  templateUrl: './detalle-autores.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class DetalleAutores implements OnInit{

  ngOnInit(): void {
    this.detalleAutor(this.idRuta);
    this.librosDelAutor(this.idRuta);
  }

  //Contendra mensaje debido al posible error del backend de fk
  errorEliminar=signal('');

  //Inyection dependency
  service= inject(AutorService);
  serviceAuth= inject(AuthService);
  activateRoute= inject(ActivatedRoute);
  router= inject(Router);

  //Tomar el id de la ruta
  idRuta= inject(ActivatedRoute).snapshot.params['id'];

  autor=signal<Autor|null>(null);
  librosDeAutor=signal<Libro[]|null>(null);

  librosDelAutor(id:number){
    this.service.cargarLibrosPorAutor(id)
    .subscribe((respuesta)=>{
      this.librosDeAutor.set(respuesta.data!)
    })
  }

  detalleAutor(id:number){
    this.service.detalleAutor(id)
    .subscribe((respuesta)=>{
      this.autor.set(respuesta.data!)
    })
  }

  eliminar(){
    if (!confirm('¿Seguro que quieres eliminar este autor?')) return;

    this.service.eliminarAutor(this.idRuta)
    .subscribe({
      next:()=>this.router.navigate(['/autores']),
      error:(err)=>{
        this.errorEliminar.set('No se puede eliminar este autor, tiene libros asociados');
      }
    })
  }

}
