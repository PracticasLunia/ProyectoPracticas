import { ChangeDetectionStrategy, Component } from '@angular/core';
import Formulario from '../../components/formulario/formulario';

@Component({
  selector: 'app-eliminar-genero',
  imports: [Formulario],
  templateUrl: './eliminar-genero.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class EliminarGenero { }
