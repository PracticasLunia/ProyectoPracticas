import { Libro } from './../../interfaces/libros.interface';
import { ChangeDetectionStrategy, Component, inject } from '@angular/core';
import { AbstractControl, FormBuilder, ReactiveFormsModule, Validators } from '@angular/forms';
import { LibrosService } from '../../services/libros.service';

@Component({
  selector: 'app-formulario-busqueda',
  imports: [ReactiveFormsModule],
  templateUrl: './formulario-busqueda.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class FormularioBusqueda {

  service=inject(LibrosService);
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

    })
    console.log(urlForm)

  }

}
