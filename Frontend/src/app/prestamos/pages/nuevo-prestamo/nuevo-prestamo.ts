import { ChangeDetectionStrategy, Component } from '@angular/core';
import FormularioPrestamo from '../../components/formulario-prestamo/formulario-prestamo';

@Component({
  selector: 'app-nuevo-prestamo',
  imports: [FormularioPrestamo],
  templateUrl: './nuevo-prestamo.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class NuevoPrestamo {




}
