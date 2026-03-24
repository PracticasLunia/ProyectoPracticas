import { ChangeDetectionStrategy, Component } from '@angular/core';

@Component({
  selector: 'app-layout-component',
  imports: [],
  templateUrl: './layout-component.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class LayoutComponent { }
