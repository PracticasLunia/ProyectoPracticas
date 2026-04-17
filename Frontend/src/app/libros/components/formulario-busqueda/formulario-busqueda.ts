import { Libro } from './../../interfaces/libros.interface';
import { ChangeDetectionStrategy, Component, inject, OnInit, signal } from '@angular/core';
import { FormBuilder, ReactiveFormsModule } from '@angular/forms';
import { LibrosService } from '../../services/libros.service';
import { ActivatedRoute, Router, RouterLink } from '@angular/router';
import { Autor } from '../../../autores/interfaces/autor.interface';
import { Genero } from '../../../generos/interfaces/genero.interface';
import { environment } from '../../../../environments/environment';
import { AutorService } from '../../../autores/services/autor.service';
import { GeneroService } from '../../../generos/services/genero.service';

@Component({
  selector: 'app-formulario-busqueda',
  imports: [ReactiveFormsModule, RouterLink],
  templateUrl: './formulario-busqueda.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class FormularioBusqueda implements OnInit{

  ngOnInit(): void {
    this.cargarAutoresSelect()
    this.cargarGenerosSelect()
    this.determinarModo(this.idRuta);
  }

  //Inyeccion de servicios y dependencias-------------
  service=inject(LibrosService);
  serviceAutor=inject(AutorService);
  serviceGenero=inject(GeneroService);
  fb=inject(FormBuilder);
  router= inject(Router);

  //Variables------------------------------------------

  urlBackend=environment.urlBackend;

  //Options pertenecientes al select de autor y generos
  autores= signal<Autor[]>([]);
  generos= signal<Genero[]>([]);

  //Señales imagen
  eliminarPortadaFlag = signal<boolean>(false); //Señal para indicar la eliminacion de portada
  portadaFile = signal<File | null>(null); //Contiene el archivo seleccionado
  errorPortada = signal<String|null>(null);

  //Señales documento
  eliminarContenidoFlag = signal(false);
  contenidoFile = signal<File | null>(null);//Contiene al documento
  errorContenido = signal<string | null>(null);

  //Ruta activa
  idRuta= inject(ActivatedRoute).snapshot.params['id'];
  libro=signal<Libro|null>(null);

  //Campos formulario
  formulario=this.fb.group({
    titulo: [''],
    isbn: [''],
    anio_publicacion:[0],
    sinopsis: [''],
    num_paginas:[0],
    disponible:[true],
    autor_id: [0],
    genero_ids: [[0]],
  })

  //Metodos---------------------------------------------------------

  //Metodos para cambiar el valor de la señal de eliminar portada o contenido
  eliminarPortadaActual() {
    this.eliminarPortadaFlag.set(true);
  }

  eliminarContenidoActual(){
    this.eliminarContenidoFlag.set(true);
  }

  //Metodos para carga de selects
  cargarAutoresSelect(){
    this.serviceAutor.cargarAutores()
    .subscribe((respuesta)=>{
      this.autores.set(respuesta)
    })
  }

  cargarGenerosSelect(){
    this.serviceGenero.cargarGeneros()
    .subscribe((respuesta)=>{
      this.generos.set(respuesta)
    })
  }

  //Determinar si debe mostrar el formulario para actualizar y cargar datos o crear
  determinarModo(id:number){
    if(id!=null){
      //Establecer valores del libro
      this.service.cargarLibroById(id)
      .subscribe((respuesta)=>{
        this.libro.set(respuesta);
        //Actualizar valores
        this.formulario.patchValue({
          titulo: this.libro()?.titulo,
          isbn: this.libro()?.isbn,
          anio_publicacion: this.libro()?.publicacion,
          sinopsis: this.libro()?.sinopsis,
          autor_id: this.libro()?.autor_id,
          genero_ids: this.libro()?.generos.map(g => g.id) ?? [],
          num_paginas:this.libro()?.num_paginas,
          disponible:this.libro()?.disponible,
        })
      })
    }
  }

  onSubmit(){

    //Resetear errores
    const errores={};
    this.errorPortada.set(null);
    this.errorContenido.set(null);

    //Enviar datos con formData para envio de archivos, este solo admite strings
    const datos2 = new FormData();
    datos2.append('titulo',      this.formulario.value.titulo ?? '');
    datos2.append('isbn',        this.formulario.value.isbn ?? '');
    datos2.append('publicacion', String(this.formulario.value.anio_publicacion ?? ''));
    datos2.append('sinopsis',    this.formulario.value.sinopsis ?? '');
    datos2.append('num_paginas', String(this.formulario.value.num_paginas ?? ''));
    datos2.append('disponible',  this.formulario.value.disponible ? '1' : '0');
    datos2.append('autor_id',    String(this.formulario.value.autor_id ?? ''));

    // Los géneros son un array. FormData no acepta arrays directamente:
    // hay que hacer append uno a uno con el nombre "genero_ids[]".
    const generos = this.formulario.value.genero_ids ?? [];
    generos.forEach(id => datos2.append('genero_ids[]', String(id)));

    //Agregar la portada y/o el documento si los a proporcionado el usuario
    if (this.portadaFile()) {
      datos2.append('portada', this.portadaFile()!);
    }
    if(this.contenidoFile()){
      datos2.append('contenido', this.contenidoFile()!);
    }

    //Eliminar la portada y/o el documento si lo ha seleccionado el usuario
    if (this.eliminarPortadaFlag()) {
      datos2.append('eliminar_portada', '1');
    }

    if(this.eliminarContenidoFlag()){
      datos2.append('eliminar_contenido', '1');
    }

    if(this.idRuta!=null){
      this.service.actualizarLibro(datos2, this.idRuta)
      .subscribe({
        next: (respuesta)=>{
          //Redirigir automaticamente
          this.router.navigate(['/libros']);
        },
        //Arrow function para el uso de propiedades del this.formulario
        error:(err)=>{
          if(err.status===422){
            const errores= err.error.errors;
            Object.keys(errores).forEach(campo => {
              const control = this.formulario.get(campo);
              if (control) {
                control.setErrors({ backend: errores[campo][0] });
              }
            });
              this.errorContenido.set(errores['contenido']?.[0] ?? null);
              this.errorPortada.set(errores['portada']?.[0] ?? null);
          }
        },
      })
    }
    else{
      this.service.nuevoLibro(datos2)
       .subscribe({
        next: (respuesta)=>{
          //Redirigir automaticamente
          this.router.navigate(['/libros']);
        },
        error:(err)=>{
          if(err.status===422){
            const errores= err.error.errors;
            Object.keys(errores).forEach(campo => {
              const control = this.formulario.get(campo);
              if (control) {
                control.setErrors({ backend: errores[campo][0] });
              }
            });
            this.errorContenido.set(errores['contenido']?.[0] ?? null);
            this.errorPortada.set(errores['portada']?.[0] ?? null);
          }
        },
      })
    }

  }

  onPortadaSeleccionada(event: Event) {
    //Casteo del tipo de dato
    const input = event.target as HTMLInputElement;
    const fichero = input.files?.[0] ?? null; //Seleccionar el unico archivo posible
    this.portadaFile.set(fichero); //Guarda el archivo
  }

  onContenidoSeleccionado(event: Event) {
    //Casteo tipo de dato
    const input = event.target as HTMLInputElement;
    const fichero = input.files?.[0] ?? null;//Seleccionar el unico archivo posible
    this.contenidoFile.set(fichero);//Guarda el archivo
  }

  //Casteo de tamaño en diferentes valores
  formatearTamano(bytes: number | null | undefined): string {
    if (!bytes) return '';
    if (bytes < 1024) return `${bytes} B`;
    if (bytes < 1024 * 1024) return `${(bytes / 1024).toFixed(1)} KB`;
    return `${(bytes / (1024 * 1024)).toFixed(1)} MB`;
  }

}
