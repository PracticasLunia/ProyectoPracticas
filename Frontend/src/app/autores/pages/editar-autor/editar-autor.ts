import { ChangeDetectionStrategy, Component } from '@angular/core';
import { Formulario } from "../../components/formulario/formulario";

@Component({
  selector: 'app-editar-autor',
  imports: [Formulario],
  templateUrl: './editar-autor.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class EditarAutor { }
