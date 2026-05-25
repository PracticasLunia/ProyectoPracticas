import { Component, inject } from '@angular/core';
import { Router, RouterLink } from '@angular/router';
import { AuthService } from '../../../auth/services/authService.service';
import {
  IonMenu, IonHeader, IonToolbar, IonTitle, IonContent,
  IonList, IonItem, IonIcon, IonLabel, IonMenuToggle
} from '@ionic/angular/standalone';
import { addIcons } from 'ionicons';
import { libraryOutline, peopleOutline, bookmarksOutline, logOutOutline, homeOutline, bookOutline, chatbubbleEllipses, chatbubbleEllipsesOutline } from 'ionicons/icons';
import { finalize } from 'rxjs';

@Component({
  selector: 'app-menu',
  templateUrl: './menu.html',
  host: { style: 'display: contents' },
  imports: [
    RouterLink,
    IonMenu, IonHeader, IonToolbar, IonTitle, IonContent,
    IonList, IonItem, IonIcon, IonLabel, IonMenuToggle,
  ],
})
export class MenuComponent {

  private service = inject(AuthService);
  private router = inject(Router);

  constructor() {
    addIcons({ libraryOutline, peopleOutline, bookmarksOutline,
      logOutOutline, homeOutline, bookOutline, chatbubbleEllipsesOutline});
  }

  cerrarSesion() {
    this.service.logout()
      .pipe(finalize(() => {
        this.service.eliminarToken();
        this.router.navigate(['/auth/login']);
      }))
      .subscribe({ error: () => {} });
  }
}
