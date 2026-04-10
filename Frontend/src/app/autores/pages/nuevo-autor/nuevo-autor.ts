import { ChangeDetectionStrategy, Component } from '@angular/core';
import { Formulario } from "../../components/formulario/formulario";

@Component({
  selector: 'app-nuevo-autor',
  imports: [Formulario],
  templateUrl: './nuevo-autor.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class NuevoAutor { }
