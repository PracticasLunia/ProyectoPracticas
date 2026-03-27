import { ChangeDetectionStrategy, Component } from '@angular/core';
import { RouterLink, RouterLinkActive, RouterLinkWithHref, RouterOutlet } from "@angular/router";

@Component({
  selector: 'app-layout-component',
  imports: [RouterLinkActive, RouterLinkWithHref, RouterLink],
  templateUrl: './layout-component.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class LayoutComponent { }
