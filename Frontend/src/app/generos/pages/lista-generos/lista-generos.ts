import { ChangeDetectionStrategy, Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-lista-generos',
  imports: [],
  templateUrl: './lista-generos.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class ListaGeneros implements OnInit {


  ngOnInit(): void {
    this.mostrarLibros();
  }

  mostrarLibros(){
    
  }



}
