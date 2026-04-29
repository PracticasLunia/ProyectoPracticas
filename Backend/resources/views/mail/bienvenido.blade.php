<x-mail::message>
# Hola, {{ $nombre }}

Tu cuenta de **Biblioteca** se ha creado correctamente con el correo `{{ $email }}`.

Desde ahora puedes iniciar sesion en la aplicacion para gestionar libros, autores, generos y prestamos.

<x-mail::button :url="config('app.url')">
Ir a la aplicacion
</x-mail::button>

Si no has sido tu quien ha creado esta cuenta, ignora este mensaje y nos pondremos en contacto contigo si fuera necesario.

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
