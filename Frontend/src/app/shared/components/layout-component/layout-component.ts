import { ChangeDetectionStrategy, Component, inject, OnInit, signal } from '@angular/core';
import { Router, RouterLink, RouterLinkActive, RouterLinkWithHref, RouterOutlet } from "@angular/router";
import { AuthService } from '../../../auth/services/authService.service';
import { User } from '../../../auth/interfaces/user.interface';

@Component({
  selector: 'app-layout-component',
  imports: [RouterLinkActive, RouterLinkWithHref, RouterLink, RouterOutlet],
  templateUrl: './layout-component.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class LayoutComponent implements OnInit{


  service= inject(AuthService);
  router= inject(Router);

  user:User|undefined;


  ngOnInit(): void {
    if (!this.service.estaLogueado()) {
      return;
    }
    this.service.usuarioActual().subscribe({
      next: (value) => {
        this.user = value.user;
      },
    });
  }

  cerrarSesion(){
    this.service.logout().subscribe({
      next: () => this.finishLogout(),
      error: () => this.finishLogout()
    });
  }

  finishLogout() {
    this.service.eliminarToken();
    this.router.navigate(['/auth/login']);
  }

}
