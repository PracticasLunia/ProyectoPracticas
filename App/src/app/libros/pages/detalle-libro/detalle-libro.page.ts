import { ChangeDetectionStrategy, Component, computed, inject, OnInit, signal } from '@angular/core';
import { DatePipe } from '@angular/common';
import { ActivatedRoute } from '@angular/router';
import { HttpClient } from '@angular/common/http';
import { IonHeader, IonToolbar, IonButtons, IonBackButton, IonTitle, IonContent, IonImg, IonCard, IonCardHeader, IonCardTitle, IonCardSubtitle, IonCardContent, IonBadge, IonList, IonItem, IonIcon, IonLabel, IonChip, IonSpinner, IonText, IonButton } from '@ionic/angular/standalone';

import { addIcons } from 'ionicons';
import {
  barcodeOutline,
  calendarOutline,
  documentTextOutline
} from 'ionicons/icons';

import { LibrosService } from '../../services/libros.service';
import { Libro } from '../../interfaces/libro.interface';
import { environment } from 'src/environments/environment';
import { Router, RouterLink } from '@angular/router';

addIcons({
  barcodeOutline,
  calendarOutline,
  documentTextOutline
});

@Component({
  selector: 'app-detalle-libro',
  standalone: true,
  imports: [
    DatePipe, IonHeader, IonToolbar, IonButtons, IonBackButton, IonTitle,
    IonContent, IonImg, IonCard, IonCardHeader, IonCardTitle,
    IonCardSubtitle, IonCardContent, IonBadge, IonList,
    IonItem, IonIcon, IonLabel, IonChip, IonSpinner, IonText,
    IonButton, RouterLink
],
  templateUrl: './detalle-libro.page.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})

export default class DetalleLibroPage implements OnInit {

  private route = inject(ActivatedRoute);
  public serviceLibro = inject(LibrosService);
  http = inject(HttpClient);

  libro = signal<Libro | null>(null);
  noEncontrado = signal(false);
  cargando = signal(true);

  prestamoActivo = computed(() =>
    this.libro()?.prestamos?.find(
      p => p.fecha_devolucion_real === null
    ) ?? null
  );

  id = Number(this.route.snapshot.params['id']);

  ngOnInit(): void {
    this.cargarLibro();
  }

  cargarLibro(): void {

    this.cargando.set(true);

    this.serviceLibro.cargarLibroById(this.id)
      .subscribe({

        next: (resp) => {
          this.libro.set(resp.data ?? null);
        },

        error: (err) => {

          if (err.status === 404) {
            this.noEncontrado.set(true);
          }

        },

        complete: () => {
          this.cargando.set(false);
        }

      });
  }

  urlPortada(id: number, version?: Date | string): string {
    const base = `${environment.urlBackend}/libros/${id}/portada`;
  return version ? `${base}?v=${version}` : base;
  }


  descargarPdf(id: number) {
    const url = `${environment.urlBackend}/libros/${id}/contenido?download=1`;

    this.http.get(url, {
      responseType: 'blob'
    })
    .subscribe(blob => {
      const objectUrl = URL.createObjectURL(blob);
      const a = document.createElement('a');
      a.href = objectUrl;
      a.download = `libro-${id}.pdf`;
      a.click();
      URL.revokeObjectURL(objectUrl);
    });

  }

}
