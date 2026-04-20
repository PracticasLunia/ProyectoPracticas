import { ChangeDetectionStrategy, Component, inject, OnInit, signal } from '@angular/core';
import { AutorService } from '../../services/autor.service';
import { FormBuilder, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { Autor } from '../../interfaces/autor.interface';

@Component({
  selector: 'app-formulario',
  imports: [ReactiveFormsModule, RouterLink],
  templateUrl: './formulario.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class Formulario implements OnInit {

  ngOnInit(): void {
    this.determinarModo(this.idRuta)
  }

  //Dependencias
  service=inject(AutorService);
  fb=inject(FormBuilder);

  //Ruta activa
  router=inject(Router);
  idRuta=inject(ActivatedRoute).snapshot.params['id'];

  //Autor para cargar sus datos por defecto
  autor=signal<Autor|null>(null);

  //Formulario
  formulario=this.fb.group({
    nombre: [''],
    apellidos: [''],
    nacionalidad: [''],
    fecha_nacimiento: [''],
    biografia: [''],
  })

  determinarModo(id:number){
    //Si se esta editando un autor
    if(id!=null){
      //Obtener valores del mismo
      this.service.detalleAutor(id)
      .subscribe((respuesta)=>{
        this.autor.set(respuesta.data!);

        //Establecer valores por defecto en el formulario
        this.formulario.patchValue({
        nombre: this.autor()?.nombre,
        apellidos: this.autor()?.apellidos,
        nacionalidad: this.autor()?.nacionalidad,
        fecha_nacimiento: this.autor()?.fecha_nacimiento,
        biografia: this.autor()?.biografia,
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
      apellidos:this.formulario.value.apellidos,
      nacionalidad:this.formulario.value.nacionalidad,
      fecha_nacimiento:this.formulario.value.fecha_nacimiento,
    }
    //Lo mismo
    const datosFormulario=this.formulario;

    //Dependiendo si se esta editando o creando un nuevo autor se ejecuta uno u otro
    //Actualizar
    if(this.idRuta!=null){
      this.service.actualizarAutor(this.idRuta, datos)
      .subscribe({
        next: (respuesta)=>{
          this.router.navigate(['/autores']);
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
      this.service.crearAutor(datos)
      .subscribe({
        next: (respuesta)=>{
          this.router.navigate(['/autores']);
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
