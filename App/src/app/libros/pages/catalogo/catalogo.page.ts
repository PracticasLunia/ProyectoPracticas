import { Genero } from './../../../generos/interfaces/genero.interface';
import { ChangeDetectionStrategy, Component, computed, inject, OnInit, signal } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { RouterLink } from '@angular/router';
import { LibrosService } from '../../services/libros.service';
import { Libro } from '../../interfaces/libro.interface';
import {
  IonHeader, IonToolbar, IonTitle, IonContent, IonButtons, IonMenuButton,
  IonSearchbar, IonItem, IonLabel, IonSelect, IonSelectOption, IonToggle,
  IonCard, IonCardHeader, IonCardTitle, IonCardSubtitle, IonCardContent,
  IonImg, IonBadge, IonGrid, IonRow, IonCol, IonRefresher, IonRefresherContent,
  IonSpinner, IonText,
} from '@ionic/angular/standalone';
import { addIcons } from 'ionicons';
import { bookOutline, searchCircle } from 'ionicons/icons';

@Component({
  selector: 'app-catalogo',
  styleUrls: ['./catalogo.page.scss'],
  templateUrl: './catalogo.page.html',
  changeDetection: ChangeDetectionStrategy.OnPush,
  imports: [
    CommonModule, FormsModule, RouterLink,
    IonHeader, IonToolbar, IonTitle, IonContent, IonButtons, IonMenuButton,
    IonSearchbar, IonItem, IonLabel, IonSelect, IonSelectOption, IonToggle,
    IonCard, IonCardHeader, IonCardTitle, IonCardSubtitle, IonCardContent,
    IonImg, IonBadge, IonGrid, IonRow, IonCol, IonRefresher, IonRefresherContent,
    IonSpinner, IonText,
  ],
})
export default class CatalogoPage implements OnInit {

constructor() {
    /**
     * Any icons you want to use in your application
     * can be registered in app.component.ts and then
     * referenced by name anywhere in your application.
     */
    addIcons({ searchCircle, bookOutline });
  }

  private service = inject(LibrosService);

  libros = signal<Libro[]>([]);
  generos = signal< Genero []>([]);
  cargando = signal(false);

  paginaActual = signal(1);
  totalPaginas = signal(1);

  paginas = computed(() => Array.from({ length: this.totalPaginas() }, (_, i) => i + 1));

  // estado de los filtros
  texto = '';
  generoId: number | null = null;
  soloDisponibles = false;

  ngOnInit() {
    this.cargarGeneros();
    this.buscar();
  }

  cargarPagina(pagina: number) {
  this.paginaActual.set(pagina);
  const url = `&page=${pagina}`;   // mantiene los filtros del buscador
  this.service.buscarLibros(url).subscribe((resp) => {
    this.libros.set(resp.data ?? []);
    this.totalPaginas.set(resp.meta?.last_page ?? 1);
  });
}

  cargarGeneros() {
    this.service.cargarGeneros().subscribe({
      next: (respuesta) => this.generos.set(respuesta.data!),
    });
  }

  buscar() {
    this.cargando.set(true);

    const params = new URLSearchParams();
    if (this.texto.trim()) params.append('titulo', this.texto.trim());
    if (this.generoId !== null) params.append('genero_id', String(this.generoId));
    if (this.soloDisponibles) params.append('disponible', '1');

    const query = params.toString();

    const observable = query
      ? this.service.buscarLibros(query)
      : this.service.cargarLibros();

    observable.subscribe({
      next: (respuesta) => {
        this.libros.set(respuesta.data ?? []);
        this.cargando.set(false);
      },
      error: () => this.cargando.set(false),
    });
  }

  onRefresh(event: CustomEvent) {
    this.buscar();
    setTimeout(() => (event.target as HTMLIonRefresherElement).complete(), 500);
  }

  urlPortada(id: number) {
    return this.service.urlPortada(id);
  }
}
