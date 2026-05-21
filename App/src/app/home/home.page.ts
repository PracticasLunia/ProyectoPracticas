import { Component, inject } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from '../auth/services/authService.service';
import { IonHeader, IonToolbar, IonTitle, IonContent, IonButton, IonButtons, IonMenuButton } from '@ionic/angular/standalone';
import { finalize } from 'rxjs';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  imports: [IonHeader, IonToolbar, IonTitle, IonContent, IonButton, IonButtons, IonMenuButton],
})
export class HomePage {

  private service = inject(AuthService);
  private router = inject(Router);

  cerrarSesion() {
    this.service.logout()
      .pipe(finalize(() => {
        this.service.eliminarToken();
        this.router.navigate(['/auth/login']);
      }))
      .subscribe({ error: () => {} });
  }
}

