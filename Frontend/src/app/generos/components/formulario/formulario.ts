import { ChangeDetectionStrategy, Component, inject, OnInit, signal } from '@angular/core';
import { FormBuilder, ReactiveFormsModule } from '@angular/forms';
import { Router, ActivatedRoute, RouterLink } from '@angular/router';
import { Genero } from '../../interfaces/genero.interface';
import { GeneroService } from '../../services/genero.service';

@Component({
  selector: 'app-formulario-genero',
  imports: [ReactiveFormsModule, RouterLink],
  templateUrl: './formulario.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class Formulario implements OnInit {

  ngOnInit(): void {
    this.determinarModo(this.idRuta);
  }

  //Dependencias
  service=inject(GeneroService);
  fb=inject(FormBuilder);

  //Ruta activa
  router=inject(Router);
  idRuta=inject(ActivatedRoute).snapshot.params['id'];

  //Genero para cargar sus datos por defecto
  genero=signal<Genero|null>(null);

  //Formulario
  formulario=this.fb.group({
    nombre: [''],
    descripcion: [''],
  })

  determinarModo(id:number){
    //Si se esta editando un genero
    if(id!=null){
      //Obtener valores del mismo
      this.service.detalleGenero(id)
      .subscribe((respuesta)=>{
        this.genero.set(respuesta.data!);

        //Establecer por defecto en los campos del formulario
        this.formulario.patchValue({
          nombre: this.genero()?.nombre,
          descripcion: this.genero()?.descripcion,
        })

      })
    }
  }

  onSubmit(){
    //Almacenar posibles errores
    const errores={};

    //Guardar datos del formulario
    const datos={
      nombre:this.formulario.value.nombre,
      descripcion:this.formulario.value.descripcion
    }

    //Lo mismo
    const datosFormulario=this.formulario;

    //Dependiendo si se esta editando o creando un nuevo autor se ejecuta uno u otro
    //Actualizar
    if(this.idRuta!=null){
      this.service.actualizarGenero(this.idRuta, datos)
      .subscribe({
        next: (respuesta)=>{
          this.router.navigate(['/generos']);
        },
        error(err) {
          if(err.status===422){
            const errores= err.error.errors;
            Object.keys(errores).forEach(campo => {
              const control = datosFormulario.get(campo);
              if (control) {
                control.setErrors({ backend: errores[campo][0] });
              }
            });
          }
        },
      })
    }
    //Crear
    else{
      this.service.crearGenero(datos)
      .subscribe({
        next: (respuesta)=>{
          this.router.navigate(['/generos']);
        },
        error(err) {
          if(err.status===422){
            const errores= err.error.errors;
            Object.keys(errores).forEach(campo => {
              const control = datosFormulario.get(campo);
              if (control) {
                control.setErrors({ backend: errores[campo][0] });
              }
            });
          }
        },
      })
    }

  }

}
