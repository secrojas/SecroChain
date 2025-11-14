# SecroChain - Sistema Fintech con Blockchain

<p align="center">
  <strong>Red wallet. Immutable chain.</strong>
</p>

## Descripción del Proyecto

SecroChain es un sistema de gestión para una fintech que ofrece servicios bancarios a sus clientes. El proyecto combina una billetera digital clásica con un ledger inspirado en blockchain, asegurando que cada transacción sea trazable, verificable y resistente a la manipulación.

Este proyecto es parte del curso de **Programación Orientada a Objetos con IA** de EducaciónIT.

## Stack Tecnológico

- **Backend:** Laravel 12 (PHP 8.2+)
- **API:** RESTful API con Laravel Sanctum (Token Authentication)
- **Arquitectura:** Repository-Service Pattern
- **Frontend:** HTML5, CSS3, JavaScript (Vanilla)
- **Base de Datos:** MySQL
- **Blockchain:** SHA-256 con Proof of Work
- **Servidor:** Laragon (Desarrollo local)
- **Paradigma:** Programación Orientada a Objetos (POO)

## Características Principales

### 1. API REST Completa
- **28 endpoints** RESTful
- Autenticación con **Laravel Sanctum** (Token-based)
- Respuestas JSON estandarizadas
- Middleware de autenticación en rutas protegidas

### 2. Gestión de Usuarios
- Registro y login con tokens JWT
- Autenticación segura con hashing de passwords
- Perfil de usuario con balance total
- Múltiples cuentas por usuario

### 3. Gestión de Cuentas Bancarias
- Creación de cuentas con códigos únicos
- Depósitos y retiros con validaciones
- Transferencias entre cuentas
- Activación/desactivación de cuentas
- Estadísticas detalladas por cuenta

### 4. Transacciones
- Registro completo de deposits y withdrawals
- Filtros por tipo, fecha, cuenta
- Balance antes y después de cada operación
- Historial completo de movimientos

### 5. Blockchain Integrado
- **Proof of Work** (SHA-256) con dificultad configurable
- Cada transacción genera un bloque inmutable
- Verificación de integridad de la cadena
- Consulta de bloques por hash, ID o transacción
- Genesis block automático

### 6. Arquitectura Robusta
- **Repository Pattern:** Abstracción de acceso a datos
- **Service Layer:** Lógica de negocio centralizada
- **Dependency Injection:** Inversión de dependencias
- **SOLID Principles:** Código mantenible y testeable

## Estructura del Proyecto

```
SecroChain/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── Api/              # API Controllers (REST)
│   │           ├── AuthController.php
│   │           ├── AccountController.php
│   │           ├── TransactionController.php
│   │           └── BlockchainController.php
│   ├── Models/                   # Eloquent Models
│   │   ├── User.php
│   │   ├── Account.php
│   │   ├── Transaction.php
│   │   └── Block.php
│   ├── Repositories/             # Repository Pattern
│   │   ├── Contracts/            # Interfaces
│   │   └── Eloquent/             # Implementaciones
│   ├── Services/                 # Business Logic Layer
│   │   ├── AccountService.php
│   │   ├── TransactionService.php
│   │   └── BlockchainService.php
│   └── Providers/
│       └── RepositoryServiceProvider.php
├── database/
│   ├── migrations/               # Database Migrations
│   └── seeders/                  # Data Seeders
├── routes/
│   ├── web.php                   # Web Routes
│   └── api.php                   # API Routes (28 endpoints)
├── resources/
│   └── views/                    # Blade Templates
│       ├── landing.blade.php
│       ├── auth.blade.php
│       └── dashboard.blade.php
└── docs/                         # Documentación (local only)
    ├── PROYECTO.md
    ├── ARQUITECTURA.md
    └── PROGRESO.md
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

6. Ejecutar migraciones y seeders:
```bash
php artisan migrate:fresh --seed
```

Esto creará:
- ✅ 5 usuarios de prueba
- ✅ 8 cuentas bancarias
- ✅ 43 transacciones
- ✅ 43 bloques en blockchain

7. Iniciar el servidor:
```bash
php artisan serve
```

8. Acceder a la aplicación:
- **Landing:** `http://localhost:8000/`
- **Auth:** `http://localhost:8000/auth`
- **Dashboard:** `http://localhost:8000/dashboard`
- **API Base:** `http://localhost:8000/api`

## API Endpoints

### Autenticación (Públicas)
```
POST   /api/auth/register    - Registrar usuario
POST   /api/auth/login       - Login (obtiene token)
```

### Usuario Autenticado (Requieren token)
```
GET    /api/auth/me          - Perfil del usuario
POST   /api/auth/logout      - Cerrar sesión
```

### Cuentas
```
GET    /api/accounts                    - Listar cuentas del usuario
POST   /api/accounts                    - Crear cuenta
GET    /api/accounts/{code}             - Detalle de cuenta
POST   /api/accounts/{id}/deposit       - Depositar
POST   /api/accounts/{id}/withdraw      - Retirar
POST   /api/accounts/transfer           - Transferir entre cuentas
GET    /api/accounts/{id}/stats         - Estadísticas
GET    /api/accounts/{id}/transactions  - Historial
```

### Transacciones
```
GET    /api/transactions                - Transacciones del usuario
GET    /api/transactions/{id}           - Detalle
GET    /api/transactions/recent         - Recientes
GET    /api/transactions/type/{type}    - Por tipo
GET    /api/transactions/{id}/block     - Con blockchain
```

### Blockchain
```
GET    /api/blockchain/stats            - Estadísticas
GET    /api/blockchain/verify           - Verificar integridad
GET    /api/blockchain/blocks           - Todos los bloques
GET    /api/blockchain/blocks/recent    - Bloques recientes
GET    /api/blockchain/blocks/{id}      - Detalle de bloque
```

## Datos de Prueba

Después de ejecutar los seeders, puedes usar estas credenciales:

**Usuarios:**
- Email: `john@example.com` | Password: `password123`
- Email: `jane@example.com` | Password: `password123`
- Email: `admin@secrochain.com` | Password: `admin123`

**Ejemplo de Login:**
```bash
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"john@example.com","password":"password123"}'
```

**Respuesta:**
```json
{
  "success": true,
  "data": {
    "user": {...},
    "token": "1|abc123..."
  }
}
```

**Usar el token:**
```bash
curl http://localhost:8000/api/accounts \
  -H "Authorization: Bearer 1|abc123..."
```

## Documentación Adicional

- [📋 Especificaciones del Proyecto](./docs/PROYECTO.md)
- [🏗️ Arquitectura y Modelo de Datos](./docs/ARQUITECTURA.md)
- [📈 Progreso del Desarrollo](./docs/PROGRESO.md)

## Buenas Prácticas Implementadas

### Arquitectura
- ✅ **Repository Pattern:** Abstracción de acceso a datos
- ✅ **Service Layer:** Lógica de negocio separada
- ✅ **Dependency Injection:** Inversión de dependencias
- ✅ **RESTful API:** Endpoints semánticos y estándar
- ✅ **Token Authentication:** Seguridad con Sanctum

### POO y SOLID
- ✅ **Single Responsibility:** Cada clase una responsabilidad
- ✅ **Open/Closed:** Abierto a extensión, cerrado a modificación
- ✅ **Liskov Substitution:** Interfaces intercambiables
- ✅ **Interface Segregation:** Contratos específicos
- ✅ **Dependency Inversion:** Depende de abstracciones

### Código
- ✅ Type hints en PHP 8.2+
- ✅ DocBlocks descriptivos
- ✅ Validaciones robustas
- ✅ Manejo de errores con try-catch
- ✅ Nomenclatura consistente en inglés

### Blockchain
- ✅ SHA-256 hashing
- ✅ Proof of Work configurable
- ✅ Validación de integridad
- ✅ Inmutabilidad garantizada
- ✅ Genesis block automático

## Comandos Útiles

```bash
# Ver rutas API
php artisan route:list --path=api

# Refrescar BD con datos de prueba
php artisan migrate:fresh --seed

# Ver estadísticas de blockchain
php artisan tinker
>>> app(\App\Services\BlockchainService::class)->getBlockchainStats();

# Verificar integridad de blockchain
>>> app(\App\Services\BlockchainService::class)->isChainValid();
```

## Autor

**Sebastian Rojas** - [srojasweb.dev](https://srojasweb.dev)

## Licencia

Este proyecto es parte de un curso educativo y está destinado solo para fines de aprendizaje.

---

© 2025 SecroChain - Fintech project · Built by secrojas
