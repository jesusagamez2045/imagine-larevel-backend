# Imagine Apps – Backend (Laravel API)

Prueba técnica **Full Stack** – Backend en **Laravel + JWT**.  
Este módulo expone una **API RESTful** para la gestión de proyectos, tareas y comentarios, con autenticación JWT y eventos de notificación para un microservicio en Node.js.

---

## 🚀 Tecnologías usadas

-   [Laravel 10](https://laravel.com/) – Framework principal
-   [tymon/jwt-auth](https://github.com/tymondesigns/jwt-auth) – Autenticación con JWT
-   [MySQL](https://www.mysql.com/) / [SQLite](https://www.sqlite.org/) – Base de datos
-   [Redis](https://redis.io/) – Cola Pub/Sub para eventos de tareas completadas
-   PHP 8.1+

---

## 📁 Estructura del proyecto

app/
├── Http/
│ ├── Controllers/
│ │ ├── AuthController.php # Login, register, logout, refresh, me
│ │ ├── ProjectController.php # CRUD de proyectos
│ │ ├── TaskController.php # CRUD de tareas + marcar completada
│ │ └── CommentController.php # Crear y listar comentarios
│ └── Middleware/
│ └── ForceJsonResponse.php # Forzar respuestas JSON en API
├── Models/
│ ├── User.php # Implementa JWTSubject
│ ├── Project.php
│ ├── Task.php
│ └── Comment.php
└── Exceptions/
routes/
└── api.php # Endpoints de la API
database/
└── migrations/ # Migraciones para users, projects, tasks, comments
tests/
└── Feature/ # Tests de endpoints (PHPUnit/Pest)

## ⚙️ Instalación y configuración

1. Clona el repo:

    ```bash
    git clone https://github.com/jesusagamez2045/imagine-larevel-backend.git
    cd imagine-larevel-backend

    ```

2. Instala dependencias:

    composer install

3. Copia el archivo de entorno:

    cp .env.example .env

4. Genera la key y el secret JWT:

    php artisan key:generate
    php artisan jwt:secret

5. Configura la base de datos en .env (DB_CONNECTION, DB_DATABASE, etc.).

6. Ejecuta migraciones:

    php artisan migrate --seed

7. Inicia el servidor:

    php artisan serve
