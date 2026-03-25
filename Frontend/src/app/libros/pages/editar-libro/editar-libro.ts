import { ChangeDetectionStrategy, Component } from '@angular/core';
import { FormularioBusqueda } from "../../components/formulario-busqueda/formulario-busqueda";

@Component({
  selector: 'app-editar-libro',
  imports: [FormularioBusqueda],
  templateUrl: './editar-libro.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class EditarLibro { }
