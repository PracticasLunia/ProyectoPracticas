import { ChangeDetectionStrategy, Component, inject, OnInit, signal } from '@angular/core';
import { LibrosService } from '../../services/libros.service';
import { Libro } from '../../interfaces/libros.interface';
import { LibroCard } from "../../components/libro-card/libro-card";
import { FormBuilder, ReactiveFormsModule } from '@angular/forms';


@Component({
  selector: 'app-lista-libros',
  imports: [LibroCard, ReactiveFormsModule],
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

  mostrarLibrosFiltrados(){
    this.service.buscarLibrosFormulario('')
    .subscribe((respuesta)=>{
      //this.libros.set(respuesta)
    });
  }

  /*Formulario*/
  fb=inject(FormBuilder);
  //formUtils= FormUtils;

  formulario=this.fb.group({
    titulo: [''],
    isbn: [''],
    autor: [''],
    genero_nombre: ['']
  })

  onSubmit(){
    const urlForm= `titulo=${this.formulario.value.titulo}&ibsn=${this.formulario.value.isbn}&autor=${this.formulario.value.autor}&genero_nombre=${this.formulario.value.genero_nombre}`
    console.log(urlForm);
        this.service.buscarLibrosFormulario(urlForm).subscribe((respuesta)=>{
        console.log(respuesta)
        this.libros.set(respuesta);
    })
    console.log(urlForm)
  }
}
