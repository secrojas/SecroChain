# SecroChain - Sistema Fintech con Blockchain

<p align="center">
  <strong>Red wallet. Immutable chain.</strong>
</p>

## Descripción del Proyecto

SecroChain es un sistema de gestión para una fintech que ofrece servicios bancarios a sus clientes. El proyecto combina una billetera digital clásica con un ledger inspirado en blockchain, asegurando que cada transacción sea trazable, verificable y resistente a la manipulación.

Este proyecto es parte del curso de **Programación Orientada a Objetos con IA** de EducaciónIT.

## Stack Tecnológico

- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** HTML5, CSS3, JavaScript (Vanilla)
- **Base de Datos:** MySQL
- **Servidor:** Laragon (Desarrollo local)
- **Paradigma:** Programación Orientada a Objetos (POO)

## Características Principales

### 1. Gestión de Clientes
- Creación, modificación y eliminación de clientes
- Cada cliente tiene: ID único, nombre, apellido, DNI
- Autenticación: email y password

### 2. Gestión de Cuentas
- Creación de cuentas para clientes
- Cada cuenta tiene: código único, saldo inicial
- Una cuenta está asociada a un cliente

### 3. Realización de Movimientos
- Depósitos y retiros
- Registro de: tipo de transacción, monto, fecha

### 4. Consulta de Saldo
- Los clientes pueden consultar el saldo actual de sus cuentas en tiempo real

### 5. Blockchain (Opcional)
- Estructura de blockchain para registro seguro de movimientos
- Cada movimiento vinculado al anterior
- Cadena de bloques que garantiza integridad

## Estructura del Proyecto

```
SecroChain/
├── app/                    # Lógica de la aplicación
│   ├── Models/            # Modelos POO (Cliente, Cuenta, Movimiento, Blockchain)
│   ├── Http/
│   │   ├── Controllers/   # Controladores
│   │   └── Middleware/    # Middleware
│   └── Services/          # Servicios de negocio
├── database/
│   └── migrations/        # Migraciones de BD
├── public/
│   └── landing/          # Archivos HTML/CSS/JS del frontend
│       ├── index.html    # Landing page
│       └── app/
│           ├── index.html      # Login/Register
│           └── dashboard.html  # Dashboard
├── resources/
│   └── views/            # Vistas Blade
├── routes/               # Rutas de la aplicación
└── docs/                 # Documentación adicional
```

## Instalación

### Requisitos Previos
- PHP 8.2 o superior
- Composer
- MySQL
- Laragon (recomendado) o servidor web similar

### Pasos de Instalación

1. Clonar el repositorio:
```bash
git clone <repository-url>
cd SecroChain
```

2. Instalar dependencias de PHP:
```bash
composer install
```

3. Configurar el archivo `.env`:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configurar la base de datos en `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=secrochain
DB_USERNAME=root
DB_PASSWORD=
```

5. Crear la base de datos:
```sql
CREATE DATABASE secrochain CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

6. Ejecutar migraciones:
```bash
php artisan migrate
```

7. Iniciar el servidor:
```bash
php artisan serve
```

8. Acceder a la aplicación:
- Landing: `http://localhost:8000/landing`
- App: `http://localhost:8000/landing/app`

## Documentación Adicional

- [📋 Especificaciones del Proyecto](./docs/PROYECTO.md)
- [🏗️ Arquitectura y Modelo de Datos](./docs/ARQUITECTURA.md)
- [📈 Progreso del Desarrollo](./docs/PROGRESO.md)

## Buenas Prácticas Implementadas

- ✅ Programación Orientada a Objetos (POO)
- ✅ Modularización del código
- ✅ Encapsulamiento de datos
- ✅ Comentarios descriptivos
- ✅ Principios SOLID
- ✅ Documentación UML

## Autor

**Sebastian Rojas** - [srojasweb.dev](https://srojasweb.dev)

## Licencia

Este proyecto es parte de un curso educativo y está destinado solo para fines de aprendizaje.

---

© 2025 SecroChain - Fintech project · Built by secrojas
