import { ChangeDetectionStrategy, Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';

@Component({
  selector: 'app-layout-auth-component',
  imports: [RouterOutlet],
  templateUrl: './layout-auth-component.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class LayoutAuthComponent { }
