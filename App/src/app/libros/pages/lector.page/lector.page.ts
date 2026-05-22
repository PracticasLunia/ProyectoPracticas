import { HttpClient } from '@angular/common/http';
import { ChangeDetectionStrategy, Component, inject, OnInit, signal } from '@angular/core';
import { environment } from 'src/environments/environment';
import { IonButtons, IonTitle, IonToolbar, IonHeader, IonBackButton, IonContent, IonSpinner } from "@ionic/angular/standalone";
import { Router, ActivatedRoute } from '@angular/router';
import { PdfViewerModule } from 'ng2-pdf-viewer';

@Component({
  selector: 'app-lector.page',
  imports: [PdfViewerModule, IonButtons, IonTitle, IonToolbar, IonHeader, IonBackButton, IonContent, IonSpinner],
  templateUrl: './lector.page.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
})
export default class LectorPage implements OnInit {

  http = inject(HttpClient);
  url = environment.urlBackend;
  cargando = signal(true);
  pdfData = signal <Uint8Array|null>(null);
  //Ruta activa
  router=inject(Router);
  idRuta=inject(ActivatedRoute).snapshot.params['id'];

  ngOnInit(): void {
    this.http.get(`${this.url}/libros/${this.idRuta}/contenido`,{responseType: 'blob'})
    .subscribe({
      next: async (blob) => {

        const arrayBuffer = await blob.arrayBuffer();

        this.pdfData.set(
          new Uint8Array(arrayBuffer)
        );

        this.cargando.set(false);
      },

      error: (err) => {
        this.cargando.set(false);
      }
    });
  }


}
