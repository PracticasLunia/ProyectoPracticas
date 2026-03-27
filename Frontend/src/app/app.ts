import { Component, signal } from '@angular/core';
import { RouterLink, RouterLinkActive, RouterOutlet } from '@angular/router';
import LayoutComponent from './shared/components/layout-component/layout-component';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet, LayoutComponent, RouterLink, RouterLinkActive],
  templateUrl: './app.html',
  styleUrl: './app.css'
})
export class App {
  protected readonly title = signal('Frontend');
}
