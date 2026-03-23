import { ChangeDetectionStrategy, Component, input } from '@angular/core';
import { Libro } from '../../interfaces/libros.interface';
import { RouterLink } from "@angular/router";

@Component({
  selector: 'app-libro-card',
  imports: [RouterLink],
  template: `<p>libro-card works!</p>`,
  templateUrl: './libro-card.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class LibroCard {
  libro= input.required<Libro>();
}
