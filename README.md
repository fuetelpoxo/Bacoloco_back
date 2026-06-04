<p align="center">
  <img src="public/imagenes/logoBlanco.png" width="220" alt="Bacoloco Logo">
</p>

<h1 align="center">BACOLOCO - API Backend</h1>

<p align="center">
  <strong>Servidor API REST y Panel de Administración construidos con Laravel 12</strong>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-%3E%3D%208.2-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP >= 8.2">
  <img src="https://img.shields.io/badge/MySQL-Active-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Composer-Dependency_Manager-885630?style=for-the-badge&logo=composer&logoColor=white" alt="Composer">
</p>

---

## 📋 Descripción General

Este repositorio contiene el backend del proyecto **BACOLOCO**. Es una API REST robusta que gestiona la lógica de negocio, usuarios, valoraciones, etiquetas, ubicaciones de lugares y eventos. Además, incluye un panel de administración para gestionar la base de datos de manera visual.

Esta guía detalla el proceso paso a paso para la instalación, configuración y ejecución de este backend en tu máquina de desarrollo local usando **MySQL** a través de herramientas de servidor local como **Laragon** o **XAMPP**.

---

## 🛠️ Requisitos Previos

Antes de comenzar, asegúrate de tener instaladas las siguientes herramientas en tu sistema:

* **Git**: Para el control de versiones y descarga del repositorio.
* **Servidor Local (MySQL & PHP)**:
  * [Laragon](https://laragon.org/) (Altamente recomendado para Windows) o [XAMPP](https://www.apachefriends.org/).
  * Debe incluir **PHP >= 8.2** y el servidor de bases de datos **MySQL**.
* **Composer**: Gestor de dependencias de PHP. [Descargar Composer](https://getcomposer.org/).
* **Node.js y npm** (LTS): Para la compilación de assets si se requiere (Vite). [Descargar Node.js](https://nodejs.org/).

---

## 🚀 Puesta en Marcha en Local

Sigue atentamente cada uno de los siguientes pasos en la terminal de tu sistema para configurar el entorno.

### 1. Clonar el repositorio
Si aún no has clonado el repositorio del backend, abre tu terminal y ejecuta:
```bash
git clone <URL_DEL_REPOSITORIO_BACKEND>
```
*(Reemplaza `<URL_DEL_REPOSITORIO_BACKEND>` por el enlace HTTPS o SSH correspondiente de GitHub).*

### 2. Acceder al directorio
Navega dentro de la carpeta raíz del backend:
```bash
cd Bacoloco_back
```

### 3. Instalar las dependencias de PHP
Descarga e instala el framework Laravel y todas las dependencias requeridas por el backend:
```bash
composer install
```
*Este comando leerá el archivo `composer.json` y creará la carpeta `/vendor` con todos los paquetes necesarios.*

### 4. Configurar las Variables de Entorno
Crea el archivo `.env` a partir de la plantilla por defecto `.env.example`:
* En **Windows** (PowerShell o CMD):
  ```bash
  copy .env.example .env
  ```
* En **Linux / macOS**:
  ```bash
  cp .env.example .env
  ```

### 5. Generar la Clave de Seguridad
Laravel necesita una clave de cifrado única para proteger las sesiones de usuario y los datos encriptados:
```bash
php artisan key:generate
```
*Este comando actualizará automáticamente el campo `APP_KEY` dentro de tu nuevo archivo `.env`.*

### 6. Configurar la Base de Datos MySQL (Laragon / XAMPP)
1. Abre el panel de control de tu servidor local (**Laragon** o **XAMPP**) e inicia los servicios de **Apache** y **MySQL**.
2. Accede a tu gestor de base de datos preferido:
   * Si usas Laragon: Haz clic en el botón **Database** para abrir **HeidiSQL**.
   * Si usas XAMPP: Ve a [http://localhost/phpmyadmin](http://localhost/phpmyadmin) en tu navegador.
3. Crea una base de datos nueva y nómbrala **`bacoloco`** (puedes elegir otro nombre si lo deseas). Colación recomendada: `utf8mb4_unicode_ci`.
4. Abre el archivo `.env` en la raíz del proyecto backend y actualiza las líneas de configuración de la base de datos para que apunten a tu servidor local:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=bacoloco
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   > 💡 **Nota:** En Laragon y XAMPP por defecto el usuario administrador es `root` y la contraseña está vacía (sin contraseña). Si has configurado una contraseña personalizada en tu instalación, añádela en la variable `DB_PASSWORD`.

### 7. Ejecutar las Migraciones y Cargar los Datos de Prueba (Seeders)
Este paso creará la estructura de tablas necesarias en MySQL y las poblará con datos iniciales (tipos de lugares, etiquetas, usuarios de prueba, ubicaciones, eventos y valoraciones):
```bash
php artisan migrate --seed
```
* **`migrate`**: Lee los archivos de la carpeta `database/migrations` y crea las tablas en tu base de datos MySQL.
* **`--seed`**: Llama al archivo `DatabaseSeeder` para rellenar de forma automatizada las tablas con información lista para interactuar desde el frontend.

---

## 💻 Ejecución del Proyecto

Laravel 12 viene preparado con scripts de automatización en `composer.json` para facilitar el desarrollo local.

### Opción A (Recomendada): Todo en Uno
Si tienes instalado Node.js en tu máquina, puedes iniciar todos los servicios del backend (servidor web de Laravel, Vite local para recursos, colas y logs de depuración) con un único comando interactivo:
```bash
composer dev
```
*Este script utiliza `npx concurrently` para ejecutar todos los procesos del servidor en segundo plano en una misma terminal.*

### Opción B: Ejecución Manual Estándar
Si solo deseas iniciar el servidor API REST principal de Laravel, ejecuta:
```bash
php artisan serve
```
*Por defecto, tu API estará disponible en **`http://127.0.0.1:8000`** (o `http://localhost:8000`). Deja esta terminal abierta mientras trabajes en el proyecto.*

---

## 🛠️ Comandos Útiles

* **Refrescar la Base de Datos**: Si deseas vaciar todas las tablas y volver a aplicar los seeders desde cero:
  ```bash
  php artisan migrate:fresh --seed
  ```
* **Ver Rutas de la API**: Para listar todos los endpoints disponibles del backend:
  ```bash
  php artisan route:list
  ```
* **Borrar Caché de Configuración**: Útil si cambias valores del archivo `.env` y no se ven reflejados:
  ```bash
  php artisan config:clear
  ```
