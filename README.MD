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

```
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
```
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
4. Coloca el resto de archivos en el mismo directorio y accede a `index.html` desde el navegador.
5. Asegúrate de que la base de datos esté corriendo y configurada correctamente en los archivos de conexión.
6. Usa Postman o el frontend para probar los endpoints (recuerda incluir el header Authorization).

1. Url Live Demo: https://website.crispity.tech/Backend

## Script Creacion de BD
Tabla about_us

CREATE TABLE about_us (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo_esp TEXT NOT NULL,
  titulo_eng TEXT NOT NULL,
  descripcion_esp TEXT NOT NULL,
  descripcion_eng TEXT NOT NULL
) ENGINE=InnoDB;

Contenido:
INSERT INTO about_us (titulo_esp, titulo_eng, descripcion_esp, descripcion_eng) VALUES
('Servicios de soporte, gestión y diseño de TI altamente personalizados.', 'Highly Tailored IT Design, Management & Support Services.',
 'Acelere la innovación con equipos tecnológicos de clase mundial. Lo conectaremos con un equipo remoto completo de increíbles talentos independientes para todas sus necesidades de desarrollo de software.',
 'Accelerate innovation with world-class tech teams We’ll match you to an entire remote team of incredible freelance talent for all your software development needs.'),
('Misión', 'Mission',
 'Nuestra misión es ofrecer soluciones digitales innovadoras y de alta calidad que impulsen el éxito de nuestros clientes, ayudándolos a alcanzar sus objetivos empresariales a través de la tecnología y la creatividad.',
 'Our mission is to deliver high-quality, innovative digital solutions that drive our clients'' success, helping them achieve their business goals through technology and creativity.'),
('Visión', 'Vision',
 'Nos visualizamos como líderes en el campo de la consultoría y desarrollo de software, reconocidos por nuestra excelencia en el servicio al cliente, nuestra capacidad para adaptarnos a las necesidades cambiantes del mercado y nuestra contribución al crecimiento y la transformación digital de las empresas.',
 'We see ourselves as leaders in the field of software consulting and development, recognized for our excellence in customer service, our ability to adapt to changing market needs and our contribution to the growth and digital transformation of companies.');

Tabla Servicios
CREATE TABLE servicios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo_esp TEXT NOT NULL,
  titulo_eng TEXT NOT NULL,
  descripcion_esp TEXT NOT NULL,
  descripcion_eng TEXT NOT NULL,
  activo BOOLEAN NOT NULL
) ENGINE=InnoDB;

Contenido:
INSERT INTO servicios (titulo_esp, titulo_eng, descripcion_esp, descripcion_eng, activo) VALUES
('Consultoría digital', 'Digital consulting',
 'Identificamos las fallas y conectamos los puntos entre tu negocio y tu estrategia digital. Nuestro equipo experto cuenta con años de experiencia en la definición de estrategias y hojas de ruta en función de tus objetivos específicos.',
 'We identify failures and connect the dots between your business and your digital strategy. Our expert team has years of experience defining strategies and roadmaps based on your specific objectives.',
 1),
('Soluciones multiexperiencia', 'Multi-experience solutions',
 'Deleitamos a las personas usuarias con experiencias interconectadas a través de aplicaciones web, móviles, interfaces conversacionales, digital twin, IoT y AR. Su arquitectura puede adaptarse y evolucionar para adaptarse a los cambios de tu organización.',
 'We delight users with interconnected experiences through web applications, mobile applications, conversational interfaces, digital twin, IoT and AR. Its architecture can adapt and evolve to adapt to changes in your organization.',
 1),
('Evolución de ecosistemas', 'Ecosystem evolution',
 'Ayudamos a las empresas a evolucionar y ejecutar sus aplicaciones de forma eficiente, desplegando equipos especializados en la modernización y el mantenimiento de ecosistemas técnicos. Creando soluciones robustas en tecnologías de vanguardia.',
 'We help companies evolve and run their applications efficiently, deploying teams specialized in the modernization and maintenance of technical ecosystems. Creating robust solutions in cutting-edge technologies.',
 1),
('Soluciones Low-Code', 'Low-Code Solutions',
 'Traemos el poder de las soluciones low-code y no-code para ayudar a nuestros clientes a acelerar su salida al mercado y añadir valor. Aumentamos la productividad y la calidad, reduciendo los requisitos de cualificación de los desarrolladores.',
 'We bring the power of low-code and no-code solutions to help our clients accelerate time to market and add value. We increase productivity and quality, reducing developer qualification requirements.',
 1);


## Pruebas

- Se incluyen capturas de pantalla y ejemplos de pruebas realizadas en Postman para todos los métodos y endpoints.
- El frontend muestra correctamente los datos consumidos desde la API.