import { ChangeDetectionStrategy, Component } from '@angular/core';

@Component({
  selector: 'app-autor-card',
  imports: [],
  template: `<p>autor-card works!</p>`,
  styleUrl: './autor-card.css',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export class AutorCard { }
