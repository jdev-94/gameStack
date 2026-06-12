# 🎮 GameStack - Descubre tu próxima aventura

GameStack es una aplicación web moderna y responsiva orientada al ecosistema gaming. Funciona como un catálogo 
interactivo que consume datos en tiempo real de la API internacional de **RAWG**, ofreciendo una interfaz de usuario 
fluida, optimizada y con una estética futurista de estilo *cyberpunk*.

El proyecto está construido bajo una arquitectura limpia y desacoplada en el backend, delegando la infraestructura de 
red a capas de servicios y blindando el rendimiento mediante buenas prácticas de desarrollo en Laravel.

---

## 🚀 Características Principales

* **Consumo de API Externa:** Conexión directa y fluida con los endpoints de videojuegos, plataformas y géneros de RAWG.
* **Arquitectura Desacoplada:** Uso de un servicio exclusivo (`RawgService`) para centralizar las peticiones HTTP, manteniendo los controladores limpios y enfocados en la lógica de negocio.
* **Sistema de Búsqueda y Filtros Dinámicos:** Buscador por texto exacto combinado con filtros concurrentes por consolas principales y géneros (ordenados por popularidad en la API).
* **Paginación Dinámica Avanzada:** Navegación fluida entre páginas manteniendo en la URL el estado actual de los filtros seleccionados mediante combinaciones de queries en el framework.
* **Interfaz de Usuario Premium:** Diseño maquetado íntegramente con Tailwind CSS utilizando efectos de retroiluminación de neón, desenfoques de fondo (`backdrop-blur`) y transiciones suaves.
* **Detalles al Milímetro:** Ficha técnica de cada videojuego con galería de capturas interactiva mediante JavaScript nativo, mapeo de tiendas oficiales de compra sin bucles anidados y *favicons* dinámicos (icono corporativo con Google Fonts en la landing y miniatura del juego en la vista de detalle).

---

## 🛠️ Tecnologías Utilizadas

* **Backend:** PHP 8.x & Laravel 10.x / 11.x
* **Frontend:** Blade Templating Engine & Tailwind CSS (v3.x via CDN)
* **Iconografía y Fuentes:** FontAwesome 6.5.1, Google Fonts (Orbitron & Inter)
* **API de Datos:** RAWG Video Games Database API

---

## 📦 Requisitos Previos

Antes de desplegar el proyecto, asegúrate de tener instalado en tu entorno local:
* PHP (>= 8.1)
* Composer
* Una cuenta en [RAWG.io](https://rawg.io/apidocs) para obtener tu API Key gratuita.

---

## 💿 Instalación y Configuración Local

Sigue estos pasos para levantar el entorno de desarrollo en tu máquina local:

1. **Clonar el repositorio:**
   ```bash
   git clone [https://github.com/TU_USUARIO/TU_REPOSITORIO.git](https://github.com/TU_USUARIO/TU_REPOSITORIO.git)
   cd nombre-del-proyecto

2. **Instalar dependencias de PHP (Composer):**
    ```bash
    composer install

3. **Configurar el archivo de entorno**
    ```bash
    cp .env.example .env
    php artisan key:generate

4. **Configurar la API Key de RAWG**
    ```bash
    RAWG_API_KEY=tu_clave_secreta_de_rawg
    🔒 Nota de Seguridad: El proyecto está configurado para consumir esta clave a través de config/services.php mediante
     el helper config('services.rawg.key'). Esto garantiza que la API seguirá funcionando de forma segura incluso si 
     ejecutas los comandos de optimización de cache (php artisan config:cache) en entornos de producción.

5. **Lanzar el servidor local**
    ```bash
    php artisan serve


## 📂 Estructura Clave del Proyecto

- **app/Services/RawgService.php:** Encapsula los métodos de conexión HTTP::get con reenvío de headers corporativos y manejo de respuestas caídas.
- **app/Http/Controllers/GamesController.php:** Recibe la inyección automática del servicio, procesa los arrays bidimensionales de la API mediante array_column / array_slice y envía los datos limpios a la vista.
- **config/services.php:** Registra y protege el índice de configuración de RAWG.
- **resources/views/juegos/index.blade.php:** Vista de la landing con la rejilla elástica de videojuegos, buscador y botoneras de filtros y paginación.
- **esources/views/juegos/show.blade.php:** Ficha técnica extendida con el script seguro para el intercambio de imágenes de la galería.

---

    
