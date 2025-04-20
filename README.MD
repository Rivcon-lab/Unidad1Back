# ConIngenio - Evaluación Backend Unidad 1

## Descripción

Este proyecto consiste en el desarrollo de una API RESTful y una página web para una empresa de consultoría y desarrollo de software, cumpliendo con los requisitos de la Evaluación Sumativa Nº 1 de la unidad de Backend.

## Características principales

- **API RESTful en PHP** con endpoints para servicios y sección "Nosotros".
- **Autenticación Bearer** para todas las solicitudes.
- **Operaciones CRUD** completas para ambas entidades.
- **Soporte multilenguaje** (español e inglés) en los endpoints.
- **Frontend responsive** que consume la API y muestra la información en cards.
- **Simulación de base de datos** con MySQL local.
- **Comentarios descriptivos** en todo el código para facilitar el mantenimiento.

## Estructura del proyecto
api/
│
├── config/
│   └── database.php
│
├── controllers/
│   ├── NosotrosController.php
│   └── ServiciosController.php
│
├── models/
│   ├── Nosotros.php
│   └── Servicios.php
│
├── .htaccess
└── index.php

css/
├── styles.css
└── themes.css

img/
├── bg.webp
├── bgservice.webp
├── logob.webp
├── logobsmall.png
├── logow.webp
├── logowsmall.png
└── us.webp

js/
├── about.js
├── script.js
└── service.js

index.html
servicio.html
nosotros.html
contacto.html
README.md

## Endpoints principales

- `GET /api/servicios?lenguaje=esp`  
  Lista los servicios en español (requiere header Authorization: Bearer backcrispity)
- `GET /api/nosotros?lenguaje=esp`  
  Lista la información de "Nosotros" en español (requiere header Authorization: Bearer backcrispity)
- `POST /api/servicios`  
  Crea un nuevo servicio (requiere header Authorization)
- `PUT /api/servicios?id=ID`  
  Actualiza un servicio por ID (requiere header Authorization)
- `DELETE /api/servicios?id=ID`  
  Elimina un servicio por ID (requiere header Authorization)
- (Lo mismo para `/api/nosotros`)

## Instalación y ejecución

1. Clonar el repositorio en máquina local.
2. Configura en entorno local (XAMPP, Laragon, WAMP, etc.) y crea la base de datos con los scripts incluidos.
3. Coloca la carpeta `/api` en tu directorio de servidor local (`htdocs` o `www`).
4. Coloca la carpeta `/frontend` en el mismo directorio y accede a `index.html` desde el navegador.
5. Asegúrate de que la base de datos esté corriendo y configurada correctamente en los archivos de conexión.
6. Usa Postman o el frontend para probar los endpoints (recuerda incluir el header Authorization).

## Pruebas

- Se incluyen capturas de pantalla y ejemplos de pruebas realizadas en Postman para todos los métodos y endpoints.
- El frontend muestra correctamente los datos consumidos desde la API.