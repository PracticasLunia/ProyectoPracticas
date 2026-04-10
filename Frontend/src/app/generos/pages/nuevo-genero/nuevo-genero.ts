import { ChangeDetectionStrategy, Component } from '@angular/core';
import Formulario from '../../components/formulario/formulario';

@Component({
  selector: 'app-nuevo-genero',
  imports: [Formulario],
  templateUrl: './nuevo-genero.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class NuevoGenero { }
