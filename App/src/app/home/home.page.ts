import { Component, inject } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../auth/services/authService.service';
import { IonHeader, IonToolbar, IonTitle, IonContent, IonButton } from '@ionic/angular/standalone';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  imports: [IonHeader, IonToolbar, IonTitle, IonContent, IonButton],
})
export class HomePage {

  private service = inject(AuthService);
  private router = inject(Router);

  cerrarSesion() {
    this.service.logout().subscribe({
      complete: () => {
        this.service.eliminarToken();
        this.router.navigate(['/auth/login']);
      },
    });
  }
}

