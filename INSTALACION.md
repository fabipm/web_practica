# 🎓 SISTEMA DE CONSEJERÍA UPT

## 📋 Descripción del Sistema

Sistema web desarrollado en Laravel para la gestión de consejerías y tutorías de estudiantes en la Universidad Privada de Tacna (UPT).

### Características Principales

✅ **Autenticación de Docentes** con validación de correos institucionales (@upt.pe y @virtual.upt.pe)  
✅ **CRUD Completo de Atenciones** (Crear, Leer, Actualizar, Eliminar)  
✅ **Sistema de Reportes** (Por Semestre, Por Docente, Por Tema, Detallado)  
✅ **Subida de Evidencias** (PDF, Imágenes, Documentos Word)  
✅ **Dashboard con Estadísticas** en tiempo real  
✅ **Filtros Avanzados** para búsqueda de atenciones  

---

## 🔧 Requisitos del Sistema

- **PHP** >= 8.2
- **Composer** >= 2.0
- **MySQL** >= 8.0 o MariaDB >= 10.3
- **Node.js** >= 18.0 (para assets)
- **Extensiones PHP requeridas:**
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - XML
  - Ctype
  - JSON
  - BCMath
  - Fileinfo

---

## 📦 Instalación Paso a Paso

### 1️⃣ Clonar o Descargar el Proyecto

```bash
cd c:\Users\HP\Pictures\fa\web_practica\sistema_consejeria
```

### 2️⃣ Instalar Dependencias de PHP

```bash
composer install
```

### 3️⃣ Instalar Dependencias de Node.js

```bash
npm install
```

### 4️⃣ Configurar Variables de Entorno

Copiar el archivo de ejemplo y configurarlo:

```bash
copy .env.example .env
```

Editar el archivo `.env` con los siguientes valores:

```env
APP_NAME="Sistema de Consejería UPT"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=consejeria_upt
DB_USERNAME=root
DB_PASSWORD=tu_contraseña_mysql
```

### 5️⃣ Generar la Clave de Aplicación

```bash
php artisan key:generate
```

### 6️⃣ Importar la Base de Datos

**Opción A: Importar el archivo SQL completo**

1. Abrir **phpMyAdmin** o **MySQL Workbench**
2. Crear la base de datos: `consejeria_upt`
3. Importar el archivo `basededatos.sql` ubicado en la raíz del proyecto

**Opción B: Usando línea de comandos**

```bash
mysql -u root -p < ../basededatos.sql
```

### 7️⃣ Ejecutar Migraciones (Agregar campo password)

```bash
php artisan migrate
```

### 8️⃣ Asignar Contraseñas a los Docentes

```bash
php artisan db:seed --class=DocentePasswordSeeder
```

**Contraseña por defecto:** `password123`

### 9️⃣ Crear el Enlace Simbólico para Storage

```bash
php artisan storage:link
```

### 🔟 Compilar Assets (CSS/JS)

**Para desarrollo:**
```bash
npm run dev
```

**Para producción:**
```bash
npm run build
```

### 1️⃣1️⃣ Iniciar el Servidor de Desarrollo

```bash
php artisan serve
```

El sistema estará disponible en: **http://localhost:8000**

---

## 🔐 Credenciales de Acceso

### Docentes Registrados

| Nombre | Correo | Contraseña |
|--------|--------|------------|
| Juan Carlos Mamani Flores | jmamanif@upt.pe | password123 |
| Diana Quispe Huamani | dquispe@virtual.upt.pe | password123 |
| Mario Apaza Sucapuca | mapaza@upt.pe | password123 |

---

## 📁 Estructura del Proyecto

```
sistema_consejeria/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   └── LoginController.php
│   │   │   ├── AtencionController.php
│   │   │   ├── DashboardController.php
│   │   │   └── ReporteController.php
│   │   ├── Middleware/
│   │   │   └── ValidateUptEmail.php
│   │   └── Requests/
│   │       └── AtencionRequest.php
│   └── Models/
│       ├── Atencion.php
│       ├── Docente.php
│       ├── Estudiante.php
│       └── Tema.php
├── config/
│   ├── auth.php (configurado para guard 'docente')
│   └── database.php
├── database/
│   ├── migrations/
│   │   └── 2024_01_01_000001_add_password_to_docentes_table.php
│   └── seeders/
│       └── DocentePasswordSeeder.php
├── resources/
│   └── views/
│       ├── auth/
│       │   └── login.blade.php
│       ├── atenciones/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   ├── edit.blade.php
│       │   └── show.blade.php
│       ├── reportes/
│       │   ├── index.blade.php
│       │   ├── por-semestre.blade.php
│       │   ├── por-docente.blade.php
│       │   ├── por-tema.blade.php
│       │   └── detallado.blade.php
│       ├── layouts/
│       │   └── app.blade.php
│       └── dashboard.blade.php
├── routes/
│   └── web.php
└── storage/
    └── app/
        └── public/
            └── evidencias/
```

---

## 🚀 Uso del Sistema

### 1. Login

1. Acceder a: `http://localhost:8000`
2. Ingresar correo institucional (debe terminar en @upt.pe o @virtual.upt.pe)
3. Ingresar contraseña: `password123`

### 2. Dashboard

- Visualiza estadísticas generales del sistema
- Atenciones recientes
- Gráficos por semestre, tema y docente

### 3. Gestión de Atenciones

**Crear Atención:**
- Seleccionar docente, estudiante y tema
- Ingresar semestre, fecha y hora
- Describir consulta y atención realizada
- Subir evidencia (opcional)

**Editar Atención:**
- Modificar cualquier campo de la atención
- Cambiar o actualizar evidencia

**Eliminar Atención:**
- Confirmación antes de eliminar
- Elimina automáticamente la evidencia asociada

### 4. Reportes

**Por Semestre:**
- Muestra total de atenciones por cada semestre
- Porcentajes y gráficos de barras

**Por Docente:**
- Ranking de docentes por cantidad de atenciones
- Información de correo institucional

**Por Tema:**
- Temas más consultados
- Análisis de necesidades estudiantiles

**Reporte Detallado:**
- Filtros múltiples (semestre, docente, tema, fechas)
- Exportable a PDF (usando impresión del navegador)

---

## 🔍 Validaciones Implementadas

### Correo Institucional
- Debe terminar en `@upt.pe` o `@virtual.upt.pe`
- Validación en el middleware `ValidateUptEmail`

### Campos Obligatorios
- Docente, Estudiante, Tema
- Semestre, Fecha, Hora
- Consulta del estudiante
- Descripción de la atención

### Archivos de Evidencia
- Formatos permitidos: PDF, JPG, JPEG, PNG, DOC, DOCX
- Tamaño máximo: 10 MB
- Almacenamiento: `storage/app/public/evidencias/`

---

## 🛠️ Comandos Útiles de Laravel

```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Ver rutas
php artisan route:list

# Recrear base de datos (CUIDADO: borra datos)
php artisan migrate:fresh --seed

# Crear nuevo controlador
php artisan make:controller NombreController

# Crear nuevo modelo
php artisan make:model NombreModelo
```

---

## 🐛 Solución de Problemas Comunes

### Error: "Storage link already exists"
```bash
php artisan storage:link
```
Si persiste, eliminar manualmente `public/storage` y volver a ejecutar.

### Error de conexión a la base de datos
1. Verificar que MySQL esté corriendo
2. Confirmar credenciales en `.env`
3. Asegurarse que existe la base de datos `consejeria_upt`

### No se pueden subir archivos
1. Verificar permisos de carpeta: `storage/app/public`
2. Ejecutar: `php artisan storage:link`
3. En Windows, ejecutar como Administrador

### Sesión no persiste después del login
1. Verificar que SESSION_DRIVER esté configurado en `.env`
2. Limpiar caché: `php artisan cache:clear`

---

## 📊 Base de Datos

### Tablas Principales

**docentes**
- id_docente (PK)
- nombres
- apellidos
- correo (UNIQUE)
- password
- remember_token

**estudiantes**
- id_estudiante (PK)
- codigo (UNIQUE)
- apellidos
- nombres

**temas**
- id_tema (PK)
- nombre_tema

**atenciones**
- id_atencion (PK)
- id_docente (FK)
- id_estudiante (FK)
- id_tema (FK)
- semestre
- fecha_atencion
- hora_atencion
- consulta_estudiante
- descripcion_atencion
- evidencia

---

## 📝 Notas Importantes

1. **Seguridad:** El sistema usa guard `docente` para autenticación separada
2. **Evidencias:** Se almacenan en `storage/app/public/evidencias/`
3. **Validaciones:** Todas las validaciones están en `AtencionRequest.php`
4. **Reportes:** Los reportes usan consultas Eloquent optimizadas
5. **Middleware:** El middleware `ValidateUptEmail` valida dominios UPT

---

## 🤝 Soporte

Para dudas o problemas:
- Revisar logs en: `storage/logs/laravel.log`
- Documentación oficial de Laravel: https://laravel.com/docs

---

## ✅ Checklist de Instalación

- [ ] PHP 8.2+ instalado
- [ ] Composer instalado
- [ ] MySQL/MariaDB corriendo
- [ ] Base de datos `consejeria_upt` creada
- [ ] Archivo SQL importado
- [ ] Dependencias instaladas (`composer install`)
- [ ] Archivo `.env` configurado
- [ ] Clave de aplicación generada (`php artisan key:generate`)
- [ ] Migraciones ejecutadas (`php artisan migrate`)
- [ ] Contraseñas asignadas (`php artisan db:seed`)
- [ ] Storage enlazado (`php artisan storage:link`)
- [ ] Servidor iniciado (`php artisan serve`)
- [ ] Login exitoso con credenciales de prueba

---

**¡Sistema listo para usar!** 🎉
