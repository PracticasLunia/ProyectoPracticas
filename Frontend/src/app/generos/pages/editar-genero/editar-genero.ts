import { ChangeDetectionStrategy, Component } from '@angular/core';
import Formulario from '../../components/formulario/formulario';

@Component({
  selector: 'app-editar-genero',
  imports: [Formulario],
  templateUrl: './editar-genero.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class EditarGenero { }
