## ✈️ EcoTravel API - Sistema de Reservas Turísticas

EcoTravel es una API REST profesional desarrollada con Symfony 7 y PHP 8.2, diseñada para la gestión de experiencias turísticas y reservas B2C. El proyecto demuestra el dominio de patrones de diseño modernos, seguridad avanzada y arquitectura desacoplada.

---

## 🚀 Decisiones Arquitectónicas y "Design Patterns"
Para este proyecto se ha evitado el uso de CRUDs automáticos, optando por una estructura robusta y escalable:
## 1. Capa de Transporte: Patrón DTO (Data Transfer Objects)
**Desacoplamiento**: Se han implementado DTOs en la carpeta src/DTO para capturar los Payloads de las peticiones (Registro, Login, Creación de Experiencias).
**Seguridad**: Evitamos el "Mass Assignment" protegiendo las entidades de Doctrine de datos no deseados en las peticiones.
**Validación**: Uso de Symfony Validator directamente sobre los DTOs mediante atributos (NotBlank, Email, Regex).
## 2. Capa de Negocio: Services & Thin Controllers
**Thin Controllers**: Los controladores solo gestionan la entrada/salida HTTP. Toda la lógica de negocio reside en servicios reutilizables (BookingService, AuthService).
**Integridad**: El BookingService garantiza que no se puedan realizar reservas sin stock (plazas) suficiente y centraliza el cálculo de precios en el servidor.
## 3. Seguridad: Autenticación Stateless (JWT)
**JWT (JSON Web Token)**: Implementado mediante LexikJWTAuthenticationBundle para una comunicación segura y sin estado entre cliente y servidor.
**RBAC (Role-Based Access Control)**: Diferenciación de accesos mediante jerarquía de roles (ROLE_USER, ROLE_ADMIN) utilizando el atributo #[IsGranted].
## 4. Capa de Persistencia: Doctrine ORM
**Relaciones Complejas**: Uso de relaciones ManyToOne para vincular Usuarios, Experiencias y Reservas.
**Auditoría**: Implementación de HasLifecycleCallbacks para la gestión automática de marcas temporales (createdAt, updatedAt).

---

## 🛠️ Stack Tecnológico
**Backend**: Symfony 7.x, PHP 8.2.
**Base de Datos**: MySQL 8.0.
**Seguridad**: JWT (OpenSSL RS256).
**Contenedores**: Docker & Docker Compose.

---

## 📂 Estructura de Endpoints Principales
**Método	Endpoint	Acceso	Descripción**
POST	/api/register	Público	Registro de nuevos usuarios.
POST	/api/login	Público	Autenticación y obtención de Token JWT.
GET	/api/experiences	Público	Listado de todas las experiencias.
POST	/api/experiences	Admin	Creación de nuevas experiencias.
POST	/api/bookings	User	Realización de una reserva (valida plazas).

---

## 📦 Instalación y Despliegue con Docker
1. **Levantar el entorno:**
```bash
docker-compose up -d --build
```
2. **Generar llaves para JWT**
```bash
docker-compose exec php bin/console doctrine:migrations:migrate --no-interaction
```
3. **Acceso a la API**: http://localhost:8000
