import { ApplicationConfig, LOCALE_ID ,provideBrowserGlobalErrorListeners } from '@angular/core';
import { provideRouter } from '@angular/router';

import { routes } from './app.routes';

//Importar la configuracion local
import localEs from '@angular/common/locales/es';
import { registerLocaleData } from '@angular/common';

//Registrar la configuracion local
registerLocaleData(localEs);

export const appConfig: ApplicationConfig = {
  providers: [
    provideBrowserGlobalErrorListeners(),
    provideRouter(routes),
    { provide: LOCALE_ID, useValue: 'es-ES' }
  ]
};
