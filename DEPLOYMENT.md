# Documentación de Despliegue en Render - Web Práctica

## Resumen
Este documento detalla todas las configuraciones y archivos modificados para desplegar exitosamente la aplicación Laravel "Web Práctica" en Render usando Docker con arquitectura multi-etapa.

---

## 🐳 Configuración de Docker

### Dockerfile
**Archivo:** `Dockerfile`
**Descripción:** Dockerfile multi-etapa optimizado para Laravel + Vite

#### Etapas del Build:

1. **Stage 1: Composer Dependencies**
   - Imagen: `composer:2.7`
   - Instala dependencias PHP de producción
   - Optimiza autoloader

2. **Stage 2: Node Build (Frontend Assets)**
   - Imagen: `node:20-bullseye`
   - Instala dependencias de Node.js
   - Compila assets con Vite
   - Genera archivos en `public/build/`

3. **Stage 3: Runtime (PHP-FPM + Nginx + Supervisor)**
   - Imagen base: `php:8.2-fmp-bullseye`
   - Instala extensiones PHP necesarias
   - Configura Nginx y Supervisor

#### Principales Correcciones Realizadas:

```dockerfile
# ✅ CORREGIDO: Usar npm install/ci correctamente
COPY package.json package-lock.json ./
RUN npm ci --prefer-offline --no-audit --progress=false

# ✅ CORREGIDO: Crear directorio public para Vite
RUN mkdir -p public
RUN npm run build

# ✅ CORREGIDO: Copiar assets desde ubicación correcta
COPY --from=node-builder /app/public/build /var/www/html/public/build

# ✅ AGREGADO: Crear directorio de logs de Nginx
&& mkdir -p /var/log/nginx \
&& chown -R www-data:www-data /var/log/nginx
```

### .dockerignore
**Archivo:** `.dockerignore` *(Creado)*
**Propósito:** Optimizar el contexto de Docker excluyendo archivos innecesarios

```dockerignore
# Archivos excluidos del build
node_modules
vendor
.git
.env*
public/build
dist
storage/logs/*
```

---

## ⚙️ Configuración de Servicios

### Nginx Configuration
**Archivo:** `docker/nginx/nginx.conf`
**Principales cambios:**

```nginx
# ✅ CORREGIDO: Usuario correcto para imagen php:fmp-bullseye
user www-data;  # Antes: user nginx;

# ✅ AGREGADO: Configuración para proxies (Render)
real_ip_header X-Forwarded-For;
set_real_ip_from 0.0.0.0/0;

# ✅ AGREGADO: Headers de seguridad
add_header X-Frame-Options "SAMEORIGIN" always;
add_header X-Content-Type-Options "nosniff" always;
add_header X-XSS-Protection "1; mode=block" always;

# ✅ AGREGADO: Parámetros FastCGI para HTTPS
fastcgi_param HTTPS $https if_not_empty;
fastcgi_param HTTP_SCHEME $scheme;
fastcgi_param SERVER_PORT $server_port;
```

### Supervisor Configuration
**Archivo:** `docker/supervisord.conf`
**Cambios realizados:**

```ini
[supervisord]
nodaemon=true
user=root  # ✅ AGREGADO: Evita warnings de ejecución como root
```

### Docker Entrypoint
**Archivo:** `docker/docker-entrypoint.sh`
**Funcionalidades:**
- Configuración de certificados SSL opcionales
- Ajuste de permisos para directorios Laravel
- Soporte para migraciones automáticas
- Inicio de servicios con Supervisor

---

## 🔧 Configuración de Laravel

### AppServiceProvider
**Archivo:** `app/Providers/AppServiceProvider.php`
**Configuraciones añadidas:**

```php
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

public function boot(): void
{
    // ✅ AGREGADO: Forzar HTTPS en producción
    if (config('app.env') === 'production') {
        URL::forceScheme('https');
    }

    // ✅ AGREGADO: Confiar en proxies (Render)
    Request::setTrustedProxies(['*'], 
        Request::HEADER_X_FORWARDED_FOR | 
        Request::HEADER_X_FORWARDED_HOST | 
        Request::HEADER_X_FORWARDED_PORT | 
        Request::HEADER_X_FORWARDED_PROTO
    );
}
```

---

## 📦 Gestión de Dependencias

### Package Management
**Archivos modificados:**
- `package.json` *(existente)*
- `package-lock.json` *(generado)*

#### package.json
```json
{
    "private": true,
    "type": "module",
    "scripts": {
        "build": "vite build",
        "dev": "vite"
    },
    "devDependencies": {
        "@tailwindcss/vite": "^4.0.0",
        "axios": "^1.11.0",
        "laravel-vite-plugin": "^2.0.0",
        "tailwindcss": "^4.0.0",
        "vite": "^7.0.7"
    }
}
```

### Vite Configuration
**Archivo:** `vite.config.js`
**Configuración para Laravel + TailwindCSS:**

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
```

---

## 🌐 Configuración de Render

### Variables de Entorno Requeridas

**Archivo:** `.env.example` *(creado)*

```env
# Aplicación
APP_NAME="Web Práctica"
APP_ENV=production
APP_KEY=base64:your-app-key-here
APP_DEBUG=false
APP_URL=https://your-domain.onrender.com

# Base de datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Seguridad HTTPS
SESSION_SECURE_COOKIE=true
SANCTUM_STATEFUL_DOMAINS=your-domain.onrender.com
```

### Configuración en Render Dashboard

**Variables críticas a configurar:**
```
APP_ENV=production
APP_URL=https://web-practica-sycm.onrender.com
SESSION_SECURE_COOKIE=true
APP_KEY=base64:generated-key
```

---

## 🚀 Proceso de Despliegue

### Build Process
1. **Composer Stage:** Instala dependencias PHP optimizadas
2. **Node Stage:** Compila assets frontend con Vite
3. **Runtime Stage:** Configura servidor con PHP-FPM + Nginx

### Service Management
- **Supervisor** gestiona PHP-FPM y Nginx
- **Nginx** maneja requests HTTP/HTTPS
- **PHP-FPM** procesa código Laravel

---

## 📝 Archivos Modificados Durante el Despliegue

### ✨ Archivos CREADOS para el despliegue:
```
✅ .dockerignore                   # Optimización de contexto Docker
✅ .env.example                    # Variables de entorno para Render
✅ package-lock.json              # Generado con npm install
✅ DEPLOYMENT.md                   # Esta documentación
```

### 🔧 Archivos MODIFICADOS para el despliegue:
```
🔄 Dockerfile                     # Correcciones multi-etapa
🔄 docker/nginx/nginx.conf        # Usuario www-data + headers seguridad
🔄 docker/supervisord.conf        # Configuración usuario root
🔄 app/Providers/AppServiceProvider.php  # HTTPS + proxy trust
```

### 📋 Archivos EXISTENTES necesarios (no modificados):
```
📁 Toda la aplicación Laravel completa
📁 docker/docker-entrypoint.sh    # Script de inicialización
📁 vite.config.js                 # Configuración Vite
📁 package.json                   # Dependencias Node.js
📁 composer.json/lock             # Dependencias PHP
📁 Todas las vistas, controladores, modelos
📁 Configuraciones de Laravel (config/)
📁 Migraciones y seeders (database/)
📁 Assets (resources/css, resources/js)
```

---

## 🛠️ Problemas Solucionados

### 1. Error de npm ci
**Problema:** `npm ci failed - package-lock.json not found`
**Solución:** Generación de `package-lock.json` y ajuste del Dockerfile

### 2. Error de usuario Nginx  
**Problema:** `getpwnam("nginx") failed`
**Solución:** Cambio de `user nginx` a `user www-data` en nginx.conf

### 3. Assets de Vite no encontrados
**Problema:** Copia desde directorio incorrecto `/app/dist`
**Solución:** Corrección a `/app/public/build`

### 4. Warnings HTTPS
**Problema:** Aplicación servida via HTTP
**Solución:** Configuración de Laravel para forzar HTTPS y headers de proxy

---

## 📋 Checklist de Despliegue

### Antes del Deploy:
- [ ] `package-lock.json` generado
- [ ] Variables de entorno configuradas en Render
- [ ] Dockerfile optimizado
- [ ] Configuraciones de Nginx verificadas

### Después del Deploy:
- [ ] HTTPS funcionando correctamente
- [ ] Assets de Vite cargando
- [ ] PHP-FPM y Nginx ejecutándose
- [ ] No hay warnings de seguridad

---

## 📁 Estructura COMPLETA del Proyecto para Despliegue

### 🔧 Archivos de Configuración Principal
```
web_practica/
├── Dockerfile                      # ✅ Multi-stage optimizado
├── .dockerignore                   # ✅ Creado para optimización
├── .env.example                   # ✅ Creado con vars de Render
├── .gitignore                     # ✅ Excluye archivos sensibles
├── .gitattributes                 # ✅ Normalización de archivos
├── .editorconfig                  # ✅ Consistencia de código
├── composer.json                  # ✅ Dependencias PHP
├── composer.lock                  # ✅ Versiones exactas PHP
├── package.json                   # ✅ Dependencias Node.js
├── package-lock.json             # ✅ Generado - versiones exactas Node
├── vite.config.js                # ✅ Configuración de build frontend
├── phpunit.xml                   # ✅ Configuración de tests
├── artisan                       # ✅ CLI de Laravel
└── DEPLOYMENT.md                 # ✅ Esta documentación
```

### 🐳 Archivos Docker (Todos requeridos)
```
docker/
├── nginx/
│   └── nginx.conf                # ✅ Configuración web server
├── supervisord.conf              # ✅ Gestión de procesos
└── docker-entrypoint.sh         # ✅ Script de inicialización
```

### 🏗️ Estructura Laravel Core
```
app/
├── Providers/
│   └── AppServiceProvider.php   # ✅ Configuración HTTPS/Proxy
├── Http/
│   ├── Controllers/
│   │   ├── Controller.php       # ✅ Controlador base
│   │   ├── DashboardController.php
│   │   ├── AtencionController.php
│   │   ├── ReporteController.php
│   │   └── Auth/
│   │       └── LoginController.php
│   ├── Middleware/
│   │   ├── AuthenticateDocente.php
│   │   └── ValidateUptEmail.php
│   └── Requests/
│       └── AtencionRequest.php
└── Models/
    ├── User.php
    ├── Atencion.php
    ├── Docente.php
    ├── Estudiante.php
    └── Tema.php
```

### 🎨 Frontend Assets
```
resources/
├── css/
│   └── app.css                   # ✅ Estilos principales
├── js/
│   ├── app.js                    # ✅ JavaScript principal
│   └── bootstrap.js              # ✅ Configuración JS
└── views/                        # ✅ Templates Blade (todos)
    ├── welcome.blade.php
    ├── dashboard.blade.php
    ├── layouts/
    │   └── app.blade.php
    ├── auth/
    │   └── login.blade.php
    ├── atenciones/
    │   ├── index.blade.php
    │   ├── create.blade.php
    │   ├── edit.blade.php
    │   └── show.blade.php
    └── reportes/
        ├── index.blade.php
        ├── por-docente.blade.php
        ├── por-tema.blade.php
        ├── por-semestre.blade.php
        └── detallado.blade.php
```

### 🗂️ Configuración Laravel
```
config/                           # ✅ Toda la carpeta se copia
├── app.php                       # ✅ Configuración principal
├── auth.php                      # ✅ Autenticación
├── cache.php                     # ✅ Cache
├── database.php                  # ✅ Base de datos
├── filesystems.php               # ✅ Almacenamiento
├── logging.php                   # ✅ Logs
├── mail.php                      # ✅ Correo
├── queue.php                     # ✅ Colas
├── services.php                  # ✅ Servicios externos
└── session.php                   # ✅ Sesiones
```

### 🗃️ Base de Datos
```
database/
├── migrations/                   # ✅ Todas las migraciones
│   ├── 0001_01_01_000000_create_users_table.php
│   ├── 0001_01_01_000001_create_cache_table.php
│   ├── 0001_01_01_000002_create_jobs_table.php
│   └── 2024_01_01_000001_add_password_to_docentes_table.php
├── seeders/                      # ✅ Seeders
│   ├── DatabaseSeeder.php
│   └── DocentePasswordSeeder.php
├── factories/                    # ✅ Factories
│   └── UserFactory.php
└── .gitignore
```

### 🌐 Archivos Públicos
```
public/
├── index.php                     # ✅ Punto de entrada Laravel
├── .htaccess                     # ✅ Apache rules (si aplica)
├── robots.txt                    # ✅ SEO
├── favicon.ico                   # ✅ Icono del sitio
└── build/                        # ✅ Generado por Vite (no en repo)
```

### 🚀 Bootstrap y Rutas
```
bootstrap/
├── app.php                       # ✅ Bootstrap de aplicación
├── providers.php                 # ✅ Registro de providers
└── cache/                        # ✅ Cache de bootstrap
    └── .gitignore

routes/
├── web.php                       # ✅ Rutas web
└── console.php                   # ✅ Comandos Artisan
```

### 📁 Directorios de Almacenamiento
```
storage/                          # ✅ Todo el directorio (con .gitignore)
├── app/
│   ├── private/
│   │   └── .gitignore
│   └── public/
│       └── .gitignore
├── framework/
│   ├── cache/
│   │   ├── data/
│   │   │   └── .gitignore
│   │   └── .gitignore
│   ├── sessions/
│   │   └── .gitignore
│   ├── testing/
│   │   └── .gitignore
│   ├── views/
│   │   └── .gitignore
│   └── .gitignore
└── logs/
    └── .gitignore
```

### 🧪 Testing (Opcional pero incluido)
```
tests/
├── TestCase.php
├── Feature/
│   └── ExampleTest.php
└── Unit/
    └── ExampleTest.php
```

---

## 📈 Commits Realizados para el Despliegue

### Cronología de cambios:
```bash
1️⃣ "Fix Docker build: add package-lock.json and correct Vite asset paths"
   - ✅ Generación de package-lock.json
   - ✅ Corrección de rutas de assets Vite
   - ✅ Creación de .dockerignore

2️⃣ "Fix nginx user configuration and supervisor setup"  
   - ✅ Cambio user nginx → www-data
   - ✅ Configuración Supervisor user=root
   - ✅ Creación directorio logs nginx

3️⃣ "Configure HTTPS support and security headers for Render deployment"
   - ✅ AppServiceProvider: HTTPS + proxy trust
   - ✅ Nginx: headers de seguridad + proxy config
   - ✅ .env.example con variables Render
```

### Estado del repositorio:
- **Rama principal:** `main`
- **Commits totales:** 3 commits para despliegue
- **Archivos rastreados:** Todos los necesarios para producción
- **Archivos ignorados:** `.env`, `node_modules`, `vendor`, `storage/logs/*`

---

## 🎯 Resultado Final

**✅ APLICACIÓN DESPLEGADA EXITOSAMENTE**

- **URL de Producción:** https://web-practica-sycm.onrender.com
- **Certificado SSL:** ✅ Automático (Render)
- **Servicios activos:** PHP-FPM + Nginx + Supervisor
- **Assets compilados:** ✅ Vite build optimizado
- **Base de datos:** ✅ Configurada via variables de entorno

