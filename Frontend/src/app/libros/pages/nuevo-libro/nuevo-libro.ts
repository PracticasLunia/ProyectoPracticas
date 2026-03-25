import { ChangeDetectionStrategy, Component } from '@angular/core';
import { FormularioBusqueda } from "../../components/formulario-busqueda/formulario-busqueda";

@Component({
  selector: 'app-nuevo-libro',
  imports: [FormularioBusqueda],
  templateUrl: './nuevo-libro.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class NuevoLibro {
  
}
