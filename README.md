# Gestión de Obras de Teatro Marvel
_Un proyecto de TFG desarrollado en Laravel 11_

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

## Sobre el Proyecto

Esta aplicación web tiene como objetivo gestionar obras de teatro inspiradas en el universo Marvel, permitiendo funciones de registro, login, gestión de perfiles y administración de obras.  
Se desarrolló con **Laravel 11** y utiliza **Laravel Breeze** para la autenticación.

## Características

- Autenticación de usuarios (registro, login, recuperación de contraseña).
- Dashboard personalizado para la gestión de contenido.
- Gestión completa de obras de teatro con temática Marvel.
- Panel de administración para la configuración de la aplicación.

## Estructura del Proyecto

- **app/**: Lógica de negocio, controladores, modelos y (middleware personalizado, que se pueden registrar en `bootstrap/app.php`).
- **resources/**: Vistas (Blade) y activos no compilados.
- **routes/**: Definición de rutas web y de API.
- **database/**: Migraciones y seeders para la base de datos.
- **public/**: Archivos accesibles públicamente (CSS, JS, imágenes).

## Instalación

1. Clonar el repositorio:
   ```bash
   git clone https://github.com/TuUsuario/NombreDeTuRepositorio.git
   cd NombreDeTuRepositorio

2. Instalar las dependencias de Composer:
   composer install

3. Instalar las dependencias de NPM (si aplica):
   npm install

4. Configurar las variables de entorno:
   cp .env.example .env

5. Generar la clave de la aplicación:
   php artisan key:generate

6. Ejecutar migraciones y seeders (opcional):
   php artisan migrate --seed

7. Levantar el servidor de desarrollo:
   php artisan serve

## Uso

Una vez completada la instalación y con el servidor en funcionamiento, abre tu navegador y accede a [http://localhost:8000](http://localhost:8000). Desde ahí, podrás iniciar sesión, registrarte y navegar por las distintas secciones de la aplicación.

## Contribución

Si deseas experimentar o mejorar este proyecto, te recomiendo trabajar en ramas. Puedes crear nuevas ramas para funcionalidades adicionales y luego integrarlas en la rama principal (main).

## Agradecimientos

Este proyecto se basa en el framework Laravel, cuyo ecosistema y comunidad han permitido desarrollar aplicaciones web robustas y escalables.

## Licencia

Este proyecto se distribuye bajo la licencia [MIT](https://opensource.org/license/MIT).