import { ChangeDetectionStrategy, Component, inject, OnInit } from '@angular/core';
import { LibrosService } from '../../services/libros.service';
import { ActivatedRoute, RouterLink, Router} from '@angular/router';

@Component({
  selector: 'app-eliminar-libro',
  imports: [],
  templateUrl: './eliminar-libro.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class EliminarLibro implements OnInit {
  //Inyenccion de servicios y dependencias
  service=inject(LibrosService);
  router= inject(Router);
  idRuta:number= inject(ActivatedRoute).snapshot.params['id'];

  ngOnInit(): void {
    //console.log(this.idRuta);
    this.confirmarEliminar(this.idRuta);
  }

  confirmarEliminar(id:number){
    //Eliminar
    if(confirm('¿Seguro que quieres eliminar este libro?')){
      this.service.eliminarLibro(id)
      .subscribe((respuesta)=>{
        console.log(respuesta);
      })
    }

    //Redirigir automaticamente
    this.router.navigate(['/libros']);
  }

}
