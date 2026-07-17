# SITEC - App Flutter Mobile

## Guía Completa de Desarrollo

---

## 1. Visión General

**SITEC** (Sistema de Gestión de Soporte Técnico) es una aplicación web construida en Laravel + Livewire que será replicada como app móvil con **Flutter**. El backend API REST ya está implementado con **Laravel Sanctum** para autenticación token-based.

### Stack Tecnológico

| Capa | Tecnología |
|---|---|
| Backend API | Laravel 13 + Sanctum |
| Frontend Móvil | Flutter 3.x + Dart |
| State Management | Riverpod 2.x |
| HTTP Client | Dio 5.x |
| Navegación | GoRouter |
| Almacenamiento Local | Hive / Shared Preferences |
| Cámara | image_picker |
| PDF | flutter_pdfview / syncfusion_flutter_pdf |
| Firmas | CustomPainter |
| Notificaciones Push | firebase_messaging |

---

## 2. Arquitectura y Estructura Flutter

### Estructura de Carpetas

```
lib/
├── main.dart
├── app.dart                          # MaterialApp + routing
├── config/
│   ├── api_config.dart               # URL base, timeouts
│   ├── theme.dart                    # Tema de la app (colores, tipografía)
│   └── constants.dart                # Enums, constantes
│
├── models/                           # Modelos de datos (fromJson/toJson)
│   ├── usuario.dart
│   ├── tarea.dart
│   ├── atencion.dart
│   ├── evidencia.dart
│   ├── comentario.dart
│   ├── notificacion.dart
│   ├── oficina.dart
│   ├── equipo.dart
│   ├── formato_atencion.dart
│   └── asignacion_tarea.dart
│
├── services/                         # Capa de servicios API
│   ├── api_service.dart              # Cliente HTTP base (Dio)
│   ├── auth_service.dart             # Login, register, logout, token
│   ├── tarea_service.dart            # CRUD tareas + acciones
│   ├── usuario_service.dart          # CRUD usuarios
│   ├── oficina_service.dart          # CRUD oficinas
│   ├── equipo_service.dart           # CRUD equipos
│   ├── atencion_service.dart         # CRUD atenciones
│   ├── evidencia_service.dart        # Subir/eliminar evidencias
│   ├── comentario_service.dart       # Comentarios
│   ├── notificacion_service.dart     # Notificaciones
│   ├── formato_service.dart          # Formatos de atención + PDF
│   ├── dashboard_service.dart        # Estadísticas kanban
│   └── storage_service.dart          # Almacenamiento local (tokens)
│
├── providers/                        # State management (Riverpod)
│   ├── auth_provider.dart
│   ├── tarea_provider.dart
│   ├── dashboard_provider.dart
│   ├── notificacion_provider.dart
│   └── ...
│
├── screens/                          # Pantallas
│   ├── auth/
│   │   ├── login_screen.dart
│   │   └── register_screen.dart
│   ├── splash_screen.dart
│   ├── dashboard/
│   │   └── dashboard_screen.dart
│   ├── tareas/
│   │   ├── tarea_list_screen.dart
│   │   ├── tarea_create_screen.dart
│   │   ├── tarea_detail_screen.dart
│   │   └── tarea_edit_screen.dart
│   ├── atencion/
│   │   ├── atencion_create_screen.dart
│   │   └── atencion_edit_screen.dart
│   ├── evidencias/
│   │   └── evidencia_upload_screen.dart
│   ├── formato/
│   │   ├── formato_create_screen.dart
│   │   ├── formato_detail_screen.dart
│   │   └── formato_pdf_screen.dart
│   ├── usuarios/
│   │   ├── usuario_list_screen.dart
│   │   ├── usuario_create_screen.dart
│   │   └── usuario_edit_screen.dart
│   ├── oficinas/
│   │   ├── oficina_list_screen.dart
│   │   └── oficina_form_screen.dart
│   ├── equipos/
│   │   ├── equipo_list_screen.dart
│   │   └── equipo_form_screen.dart
│   └── notificaciones/
│       └── notificacion_list_screen.dart
│
├── widgets/                          # Componentes reutilizables
│   ├── priority_badge.dart
│   ├── status_badge.dart
│   ├── task_card.dart
│   ├── stat_card.dart
│   ├── custom_text_field.dart
│   ├── custom_select.dart
│   ├── confirm_dialog.dart
│   ├── toast_snackbar.dart
│   ├── signature_canvas.dart
│   ├── image_picker_widget.dart
│   ├── loading_spinner.dart
│   └── empty_state.dart
│
├── layout/                           # Layout principal
│   ├── app_layout.dart               # Scaffold con Drawer + BottomNav
│   ├── app_drawer.dart               # Sidebar/Drawer
│   └── app_bottom_nav.dart           # Bottom navigation bar
│
└── utils/                            # Utilidades
    ├── validators.dart
    ├── formatters.dart
    └── extensions.dart
```

### Dependencias (pubspec.yaml)

```yaml
dependencies:
  flutter:
    sdk: flutter

  # State Management
  flutter_riverpod: ^2.5.0
  riverpod_annotation: ^2.3.0

  # HTTP
  dio: ^5.4.0

  # Routing
  go_router: ^14.0.0

  # Storage
  shared_preferences: ^2.2.0
  hive_flutter: ^1.1.0

  # UI
  google_fonts: ^6.1.0
  flutter_svg: ^2.0.0
  cached_network_image: ^3.3.0
  shimmer: ^3.0.0

  # Camera & Files
  image_picker: ^1.0.0
  path_provider: ^2.1.0

  # PDF
  flutter_pdfview: ^1.3.0
  syncfusion_flutter_pdf: ^25.1.0

  # Signatures
  # (CustomPainter implementation - no package needed)

  # Push Notifications
  firebase_core: ^2.32.0
  firebase_messaging: ^14.8.0

  # Utils
  intl: ^0.19.0
  provider: ^6.1.0
  url_launcher: ^6.2.0

dev_dependencies:
  flutter_test:
    sdk: flutter
  flutter_lints: ^4.0.0
  build_runner: ^2.4.0
  riverpod_generator: ^2.4.0
  json_serializable: ^6.7.0
```

---

## 3. Paleta de Colores y Tipografía

### Colores Principales

| Nombre | Hex | Uso |
|---|---|---|
| `primary` | `#166534` | Verde oscuro - color principal de marca |
| `primaryLight` | `#22c55e` | Verde claro - botones secundarios |
| `background` | `#f4f7f5` | Gris-verde claro - fondo general |
| `card` | `#ffffff` | Blanco - fondo de tarjetas |
| `muted` | `#64748b` | Gris azulado - texto secundario |
| `line` | `#dbe4de` | Verde claro - bordes y separadores |
| `sidebarBg` | `#111827` | Gris oscuro - fondo del sidebar/drawer |
| `sidebarText` | `#ffffff` | Blanco - texto del sidebar |
| `sidebarHover` | `#374151` | Gris - hover del sidebar |
| `sidebarActive` | `#374151` | Gris - item activo del sidebar |
| `sidebarMuted` | `#9ca3af` | Gris claro - texto secundario sidebar |
| `danger` | `#ef4444` | Rojo - eliminar, errores |
| `warning` | `#f59e0b` | Amarillo - observar, warnings |
| `info` | `#3b82f6` | Azul - información, links |
| `success` | `#22c55e` | Verde - éxito, finalizar |

### Colores de Prioridad

| Prioridad | Background | Texto | Valor |
|---|---|---|---|
| CRITICA | `#fee2e2` | `#b91c1c` | Rojo intenso |
| ALTA | `#fee2e2` | `#b91c1c` | Rojo claro |
| MEDIA | `#fef3c7` | `#92400e` | Amarillo/naranja |
| BAJA | `#dcfce7` | `#166534` | Verde claro |

### Colores de Estado

| Estado | Background | Texto |
|---|---|---|
| `pendiente` | `#e5e7eb` (gray-200) | `#374151` (gray-700) |
| `asignado` | `#dbeafe` (blue-100) | `#1e40af` (blue-800) |
| `en_proceso` | `#dbeafe` (blue-100) | `#1e40af` (blue-800) |
| `observado` | `#fef3c7` (yellow-100) | `#92400e` (yellow-800) |
| `finalizado` | `#22c55e` (green-600) | `#ffffff` (white) |
| `cancelado` | `#ef4444` (red-600) | `#ffffff` (white) |

### Colores de Botones

| Tipo | Background | Texto | Borde |
|---|---|---|---|
| Primario | `#166534` | `white` | sin borde |
| Secundario | `white` | `#374151` | `#d1d5db` |
| Guardar/Firmar | `white` | `#166534` | `#bbf7d0` |
| Cancelar/Eliminar | `white` | `#ef4444` | `#fecaca` |
| Observar | `#f59e0b` | `white` | sin borde |
| Nuevo registro | `#3b82f6` | `white` | sin borde |

### Tipografía

- **Fuente principal:** Figtree (Google Fonts)
- **Fallback:** sans-serif
- **Weights:** 400 (regular), 500 (medium), 600 (semibold), 700 (bold)

```dart
// En theme.dart
TextTheme(
  fontFamily: 'Figtree',
  headlineLarge: TextStyle(fontSize: 28, fontWeight: FontWeight.w700),
  headlineMedium: TextStyle(fontSize: 22, fontWeight: FontWeight.w600),
  titleLarge: TextStyle(fontSize: 18, fontWeight: FontWeight.w600),
  titleMedium: TextStyle(fontSize: 16, fontWeight: FontWeight.w500),
  bodyLarge: TextStyle(fontSize: 16, fontWeight: FontWeight.w400),
  bodyMedium: TextStyle(fontSize: 14, fontWeight: FontWeight.w400),
  bodySmall: TextStyle(fontSize: 12, fontWeight: FontWeight.w400),
  labelLarge: TextStyle(fontSize: 14, fontWeight: FontWeight.w500),
  labelSmall: TextStyle(fontSize: 11, fontWeight: FontWeight.w500),
)
```

---

## 4. Documentación Completa de la API

### URL Base

```
http://TU_SERVIDOR/api
```

### Autenticación

Las peticiones autenticadas llevan el header:

```
Authorization: Bearer {token}
Content-Type: application/json
Accept: application/json
```

---

### AUTH

#### POST `/api/auth/login`
Login y obtener token.

**Request:**
```json
{
  "correo": "usuario@correo.com",
  "password": "123456"
}
```

**Response 200:**
```json
{
  "success": true,
  "data": {
    "user": {
      "id": 1,
      "nombres": "Juan",
      "apellidos": "Pérez",
      "correo": "juan@correo.com",
      "telefono": "999999999",
      "rol": "jefe",
      "activo": true
    },
    "token": "1|abc123def456..."
  }
}
```

**Response 422 (credenciales incorrectas):**
```json
{
  "message": "Las credenciales proporcionadas son incorrectas."
}
```

**Response 403 (cuenta desactivada):**
```json
{
  "success": false,
  "message": "Tu cuenta está desactivada."
}
```

---

#### POST `/api/auth/register`
Registrar nuevo usuario (rol: solicitante).

**Request:**
```json
{
  "nombres": "María",
  "apellidos": "García",
  "correo": "maria@correo.com",
  "telefono": "999888777",
  "password": "123456",
  "password_confirmation": "123456"
}
```

**Response 201:**
```json
{
  "success": true,
  "data": {
    "user": { ... },
    "token": "2|xyz789..."
  }
}
```

---

#### POST `/api/auth/logout`
Cerrar sesión (elimina el token actual).

**Headers:** `Authorization: Bearer {token}`

**Response 200:**
```json
{
  "success": true,
  "message": "Sesión cerrada correctamente."
}
```

---

#### GET `/api/auth/profile`
Obtener perfil del usuario autenticado.

**Response 200:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "nombres": "Juan",
    "apellidos": "Pérez",
    "correo": "juan@correo.com",
    "rol": "jefe",
    "activo": true
  }
}
```

---

#### PUT `/api/auth/profile`
Actualizar perfil del usuario autenticado.

**Request:**
```json
{
  "nombres": "Juan Carlos",
  "apellidos": "Pérez López",
  "telefono": "999999999",
  "password": "nueva_pass"
}
```

**Response 200:**
```json
{
  "success": true,
  "data": { "id": 1, "nombres": "Juan Carlos", ... }
}
```

---

### DASHBOARD

#### GET `/api/dashboard`
Obtener estadísticas y datos del kanban.

**Response 200:**
```json
{
  "success": true,
  "data": {
    "kanban": {
      "pendiente": [ { "tarea_object": "..." } ],
      "asignado": [ ... ],
      "en_proceso": [ ... ],
      "observado": [ ... ],
      "finalizado": [ ... ],
      "cancelado": [ ... ]
    },
    "estadisticas": {
      "total": 45,
      "pendientes": 5,
      "en_curso": 12,
      "finalizadas": 25,
      "observadas": 2,
      "canceladas": 1,
      "total_usuarios": 10,
      "total_practicantes": 6,
      "tareas_hoy": 3
    }
  }
}
```

---

### TAREAS

#### GET `/api/tareas`
Listar tareas (filtrado por rol).

**Query params:**
- `estado` - Filtrar por estado (pendiente, asignado, en_proceso, etc.)
- `estado=curso` - Solo practicante: tareas asignadas en proceso
- `busqueda` - Buscar por código, título o descripción

**Response 200:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "codigo": "T-001",
      "titulo": "Impresora no funciona",
      "descripcion": "La impresora del 2do piso no imprime",
      "tipo_soporte": "impresion",
      "prioridad": "alta",
      "estado": "en_proceso",
      "ubicacion_detalle": "Oficina 201",
      "fecha_registro": "2026-07-16T10:00:00.000000Z",
      "fecha_asignacion": "2026-07-16T11:00:00.000000Z",
      "fecha_inicio": "2026-07-16T11:30:00.000000Z",
      "fecha_finalizacion": null,
      "solicitante": { "id": 3, "nombres": "María", "apellidos": "García" },
      "oficina": { "id": 1, "nombre": "Oficina Central" },
      "practicanteAsignado": { "id": 2, "nombres": "Carlos", "apellidos": "López" }
    }
  ]
}
```

---

#### POST `/api/tareas`
Crear nueva tarea.

**Request:**
```json
{
  "titulo": "Impresora no funciona",
  "descripcion": "La impresora del 2do piso no imprime",
  "tipo_soporte": "impresion",
  "prioridad": "alta",
  "ubicacion_detalle": "Oficina 201",
  "oficina_id": 1,
  "solicitante_id": 3
}
```

**Response 201:**
```json
{
  "success": true,
  "data": { "id": 1, "codigo": "T-001", ... },
  "message": "Tarea creada correctamente"
}
```

---

#### GET `/api/tareas/{id}`
Obtener tarea con todas sus relaciones.

**Response 200:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "codigo": "T-001",
    "titulo": "Impresora no funciona",
    "solicitante": { ... },
    "oficina": { ... },
    "practicanteAsignado": { ... },
    "atencion": { "id": 1, "diagnostico": "...", ... },
    "evidencias": [ { "id": 1, "nombre_archivo": "foto.jpg", ... } ],
    "comentarios": [ { "id": 1, "comentario": "...", "usuario": { ... } } ],
    "asignaciones": [ ... ],
    "notificaciones": [ ... ],
    "formatoAtencion": { ... }
  }
}
```

---

#### PUT `/api/tareas/{id}`
Actualizar tarea.

**Request:**
```json
{
  "titulo": "Nuevo título",
  "prioridad": "critica"
}
```

---

#### DELETE `/api/tareas/{id}`
Eliminar tarea.

---

#### POST `/api/tareas/{id}/asignar`
Asignar practicante(s) a una tarea. **(Solo jefe)**

**Request:**
```json
{
  "practicante_ids": [2, 5]
}
```

---

#### POST `/api/tareas/{id}/aceptar`
Aceptar tarea (cambia a `en_proceso`). **(Jefe/Practicante)**

---

#### POST `/api/tareas/{id}/iniciar`
Iniciar tarea (igual que aceptar). **(Jefe/Practicante)**

---

#### POST `/api/tareas/{id}/autoasignar`
Auto-asignarse una tarea pendiente. **(Solo practicante)**

---

#### POST `/api/tareas/{id}/finalizar`
Finalizar tarea. **(Jefe/Practicante)**

---

#### POST `/api/tareas/{id}/observar`
Marcar tarea como observada. **(Solo jefe)**

---

#### POST `/api/tareas/{id}/cancelar`
Cancelar tarea. **(Solo jefe)**

---

### USUARIOS

#### GET `/api/usuarios` **(Solo jefe)**
```json
{
  "success": true,
  "data": [
    { "id": 1, "nombres": "Juan", "apellidos": "Pérez", "correo": "...", "rol": "jefe", "activo": true }
  ]
}
```

#### POST `/api/usuarios` **(Solo jefe)**
```json
{
  "nombres": "Nuevo",
  "apellidos": "Usuario",
  "correo": "nuevo@correo.com",
  "telefono": "999999999",
  "rol": "practicante",
  "password": "123456"
}
```

#### PUT `/api/usuarios/{id}` **(Solo jefe)**
```json
{
  "nombres": "Nombre Actualizado",
  "activo": false,
  "password": "nueva_pass"  // opcional
}
```

#### DELETE `/api/usuarios/{id}` **(Solo jefe)**

---

### OFICINAS

#### GET `/api/oficinas` **(Solo jefe)**
```json
{
  "success": true,
  "data": [
    { "id": 1, "nombre": "Oficina Central", "ubicacion": "Piso 2", "descripcion": "...", "equipos": [...] }
  ]
}
```

#### POST `/api/oficinas` **(Solo jefe)**
```json
{
  "nombre": "Nueva Oficina",
  "ubicacion": "Piso 3",
  "descripcion": "Descripción de la oficina"
}
```

#### PUT `/api/oficinas/{id}` **(Solo jefe)**
#### DELETE `/api/oficinas/{id}` **(Solo jefe)**

---

### EQUIPOS

#### GET `/api/equipos` **(Solo jefe)**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "tipo_equipo": "computadora",
      "codigo_patrimonial": "CP-001",
      "numero_serie": "SN12345",
      "marca": "HP",
      "modelo": "ProDesk 400",
      "activo": true,
      "oficina": { "id": 1, "nombre": "Oficina Central" },
      "usuarioResponsable": { "id": 3, "nombres": "María" }
    }
  ]
}
```

#### POST `/api/equipos` **(Solo jefe)**
```json
{
  "tipo_equipo": "computadora",
  "codigo_patrimonial": "CP-002",
  "numero_serie": "SN67890",
  "marca": "Dell",
  "modelo": "OptiPlex 7090",
  "oficina_id": 1,
  "usuario_responsable_id": 3
}
```

#### PUT `/api/equipos/{id}` **(Solo jefe)**
#### DELETE `/api/equipos/{id}` **(Solo jefe)**

---

### ATENCIONES

#### POST `/api/tareas/{tarea_id}/atenciones`
Registrar atención. **(Jefe/Practicante)**

**Request:**
```json
{
  "diagnostico": "Impresora con cartucho vacío",
  "actividades_realizadas": "Se reemplazó cartucho",
  "solucion_aplicada": "Nuevo cartucho instalado",
  "observaciones": "Se recomienda revisar mensualmente",
  "tiempo_atencion_minutos": 30
}
```

#### GET `/api/atenciones/{id}`
Obtener atención.

#### PUT `/api/atenciones/{id}`
Actualizar atención.

---

### EVIDENCIAS

#### POST `/api/tareas/{tarea_id}/evidencias`
Subir evidencia. **(Jefe/Practicante)**

**Opción 1 - Multipart (recomendado para fotos):**
```
Content-Type: multipart/form-data

archivo: [file]
nombre_archivo: "foto_001.jpg"
descripcion: "Foto del equipo dañado"
tipo_evidencia: "imagen"
```

**Opción 2 - Base64:**
```json
{
  "archivo_base64": "data:image/png;base64,iVBORw0KGgo...",
  "nombre_archivo": "foto_001.png",
  "descripcion": "Foto del equipo dañado",
  "tipo_evidencia": "imagen"
}
```

**Response 201:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "nombre_archivo": "foto_001.jpg",
    "url_archivo": "evidencias/T-001_1234567890.jpg",
    "tipo_evidencia": "imagen",
    "descripcion": "Foto del equipo dañado"
  }
}
```

#### DELETE `/api/evidencias/{id}`

---

### COMENTARIOS

#### POST `/api/tareas/{tarea_id}/comentarios`

**Request:**
```json
{
  "comentario": "Ya revisé la impresora, está en proceso"
}
```

**Response 201:**
```json
{
  "success": true,
  "data": {
    "id": 1,
    "comentario": "Ya revisé la impresora, está en proceso",
    "usuario": { "id": 2, "nombres": "Carlos", "apellidos": "López" },
    "created_at": "2026-07-16T12:00:00.000000Z"
  }
}
```

---

### NOTIFICACIONES

#### GET `/api/notificaciones`
```json
{
  "success": true,
  "data": {
    "notificaciones": [
      {
        "id": 1,
        "titulo": "Tarea asignada",
        "mensaje": "Se te ha asignado la tarea T-001",
        "leida": false,
        "tarea": { "id": 1, "codigo": "T-001" },
        "created_at": "2026-07-16T11:00:00.000000Z"
      }
    ],
    "no_leidas": 3
  }
}
```

#### POST `/api/notificaciones/{id}/leida`
Marcar una notificación como leída.

#### POST `/api/notificaciones/leer-todas`
Marcar todas como leídas.

---

### FORMATOS DE ATENCIÓN

#### GET `/api/tareas/{tarea_id}/formatos-atencion/defaults`
Obtener valores por defecto para el formulario.

**Response 200:**
```json
{
  "success": true,
  "data": {
    "defaults": {
      "nombres_solicitante": "María",
      "apellidos_solicitante": "García",
      "telefono_movil": "999999999",
      "tipo_soporte_informatico": "impresion",
      "reporte_usuario": "La impresora no imprime",
      "diagnostico_tecnico": "Cartucho vacío",
      "fecha_atencion": "2026-07-16",
      "hora_atencion": "11:30",
      "fecha_entrega": "2026-07-16",
      "hora_entrega": "14:00",
      "nombre_responsable": "Carlos López"
    },
    "equipos": [
      { "id": 1, "tipo_equipo": "impresora", "codigo_patrimonial": "IMP-001", "marca": "HP" }
    ]
  }
}
```

#### POST `/api/tareas/{tarea_id}/formatos-atencion`
Crear/actualizar formato de atención.

**Request:**
```json
{
  "equipo_id": 1,
  "nombres_solicitante": "María",
  "apellidos_solicitante": "García",
  "dni_solicitante": "12345678",
  "telefono_movil": "999999999",
  "regimen_laboral": "Nombrado",
  "cargo": "Asistente",
  "unidad_organizacion": "Oficina Central",
  "tipo_soporte_informatico": "impresion",
  "reporte_usuario": "La impresora no imprime",
  "diagnostico_tecnico": "Cartucho vacío",
  "observaciones": "Se reemplazó cartucho",
  "fecha_atencion": "2026-07-16",
  "hora_atencion": "11:30",
  "fecha_entrega": "2026-07-16",
  "hora_entrega": "14:00",
  "nombre_responsable": "Carlos López",
  "firma_responsable_base64": "data:image/png;base64,...",
  "firma_solicitante_base64": "data:image/png;base64,..."
}
```

#### GET `/api/formatos-atencion`
Listar todos los formatos.

#### GET `/api/formatos-atencion/{id}`
Obtener formato específico.

#### PUT `/api/formatos-atencion/{id}`
Actualizar formato.

#### DELETE `/api/formatos-atencion/{id}`
Eliminar formato.

#### GET `/api/formatos-atencion/{id}/pdf`
Descargar PDF del formato.

#### POST `/api/formatos-atencion/{id}/firma`
Guardar firma digital.

**Request:**
```json
{
  "firma": "data:image/png;base64,...",
  "tipo": "responsable"
}
```

---

### ASIGNACIONES

#### POST `/api/tareas/{tarea_id}/asignaciones`
Crear asignación. **(Solo jefe)**

**Request:**
```json
{
  "practicante_id": 2,
  "tipo_asignacion": "manual"
}
```

#### DELETE `/api/asignaciones/{id}`
Eliminar asignación. **(Solo jefe)**

---

## 5. Modelos de Datos

### Enums

```dart
enum Rol { jefe, practicante, solicitante }

enum EstadoTarea { pendiente, asignado, en_proceso, observado, finalizado, cancelado }

enum Prioridad { baja, media, alta, critica }

enum TipoSoporte { hardware, software, red, impresion, otro }

enum TipoEquipo { computadora, laptop, impresora, monitor, router, switch, otro }

enum RegimenLaboral { nombrado, permanente, cas, casConfianza, dl276, dl728, dl1057, otro }

enum EstadoFormato { borrador, completado }
```

### Modelo Tarea (JSON de la API)

```dart
class Tarea {
  final int id;
  final String codigo;
  final String titulo;
  final String descripcion;
  final String? tipoSoporte;
  final String prioridad;
  final String estado;
  final String? ubicacionDetalle;
  final DateTime? fechaRegistro;
  final DateTime? fechaAsignacion;
  final DateTime? fechaInicio;
  final DateTime? fechaFinalizacion;
  final Usuario? solicitante;
  final Oficina? oficina;
  final Usuario? practicanteAsignado;
  final Atencion? atencion;
  final List<Evidencia> evidencias;
  final List<Comentario> comentarios;
  final List<AsignacionTarea> asignaciones;
  final FormatoAtencion? formatoAtencion;
}
```

### Modelo Usuario

```dart
class Usuario {
  final int id;
  final String nombres;
  final String apellidos;
  final String correo;
  final String? telefono;
  final String rol;
  final bool activo;

  String get nombreCompleto => '$nombres $apellidos';
}
```

### Modelo Atención

```dart
class Atencion {
  final int id;
  final int tareaId;
  final int practicanteId;
  final String diagnostico;
  final String? actividadesRealizadas;
  final String? solucionAplicada;
  final String? observaciones;
  final int? tiempoAtencionMinutos;
  final DateTime? fechaAtencion;
}
```

### Modelo Evidencia

```dart
class Evidencia {
  final int id;
  final int tareaId;
  final String nombreArchvo;
  final String urlArchivo;
  final String tipoEvidencia;
  final String? descripcion;
}
```

### Modelo Notificación

```dart
class Notificacion {
  final int id;
  final String titulo;
  final String mensaje;
  final bool leida;
  final Tarea? tarea;
  final DateTime createdAt;
}
```

### Modelo Oficina

```dart
class Oficina {
  final int id;
  final String nombre;
  final String? ubicacion;
  final String? descripcion;
}
```

### Modelo Equipo

```dart
class Equipo {
  final int id;
  final String tipoEquipo;
  final String? codigoPatrimonial;
  final String? numeroSerie;
  final String? marca;
  final String? modelo;
  final Oficina? oficina;
  final Usuario? usuarioResponsable;
  final bool activo;
}
```

### Modelo FormatoAtención

```dart
class FormatoAtencion {
  final int id;
  final int tareaId;
  final int? equipoId;
  final String nombresSolicitante;
  final String apellidosSolicitante;
  final String? dniSolicitante;
  final String? telefonoMovil;
  final String? regimenLaboral;
  final String? cargo;
  final String? unidadOrganizacion;
  final String? tipoSoporteInformatico;
  final String? reporteUsuario;
  final String? diagnosticoTecnico;
  final String? observaciones;
  final String? fechaAtencion;
  final String? horaAtencion;
  final String? fechaEntrega;
  final String? horaEntrega;
  final String? nombreResponsable;
  final String? firmaResponsableUrl;
  final String? firmaSolicitanteUrl;
  final String? estadoFormato;
  final String? pdfUrl;
}
```

---

## 6. Navegación y Layout

### Estructura de Pantallas

```
SplashScreen
  │
  ├── (no autenticado) → LoginScreen
  │     └── RegisterScreen
  │
  └── (autenticado) → AppLayout
        │
        ├── BottomNavigationBar (4 tabs)
        │     ├── [0] Dashboard (Kanban)
        │     ├── [1] Tareas (Listado)
        │     ├── [2] Notificaciones
        │     └── [3] Perfil
        │
        └── Drawer (menú lateral)
              ├── Dashboard
              ├── Tareas
              ├── Tareas en curso (solo practicante)
              ├── Notificaciones
              ├── ─── (separador) ───
              ├── Oficinas (solo jefe)
              ├── Equipos (solo jefe)
              ├── Usuarios (solo jefe)
              ├── Formatos de Atención (jefe/practicante)
              ├── ─── (separador) ───
              ├── Solicitudes WhatsApp (solo jefe)
              └── Cerrar sesión
```

### Rutas (GoRouter)

```dart
final router = GoRouter(
  initialLocation: '/splash',
  routes: [
    GoRoute(path: '/splash', builder: (_, __) => SplashScreen()),
    GoRoute(path: '/login', builder: (_, __) => LoginScreen()),
    GoRoute(path: '/register', builder: (_, __) => RegisterScreen()),
    ShellRoute(
      builder: (_, __, child) => AppLayout(child: child),
      routes: [
        GoRoute(path: '/dashboard', builder: (_, __) => DashboardScreen()),
        GoRoute(path: '/tareas', builder: (_, __) => TareaListScreen()),
        GoRoute(path: '/tareas/crear', builder: (_, __) => TareaCreateScreen()),
        GoRoute(path: '/tareas/:id', builder: (_, state) => TareaDetailScreen(id: state.pathParameters['id']!)),
        GoRoute(path: '/tareas/:id/editar', builder: (_, state) => TareaEditScreen(id: state.pathParameters['id']!)),
        GoRoute(path: '/tareas/:id/atencion/crear', builder: (_, state) => AtencionCreateScreen(tareaId: state.pathParameters['id']!)),
        GoRoute(path: '/tareas/:id/formato/crear', builder: (_, state) => FormatoCreateScreen(tareaId: state.pathParameters['id']!)),
        GoRoute(path: '/formatos/:id', builder: (_, state) => FormatoDetailScreen(id: state.pathParameters['id']!)),
        GoRoute(path: '/notificaciones', builder: (_, __) => NotificacionListScreen()),
        GoRoute(path: '/usuarios', builder: (_, __) => UsuarioListScreen()),
        GoRoute(path: '/usuarios/crear', builder: (_, __) => UsuarioCreateScreen()),
        GoRoute(path: '/usuarios/:id/editar', builder: (_, state) => UsuarioEditScreen(id: state.pathParameters['id']!)),
        GoRoute(path: '/oficinas', builder: (_, __) => OficinaListScreen()),
        GoRoute(path: '/oficinas/crear', builder: (_, __) => OficinaFormScreen()),
        GoRoute(path: '/equipos', builder: (_, __) => EquipoListScreen()),
        GoRoute(path: '/equipos/crear', builder: (_, __) => EquipoFormScreen()),
        GoRoute(path: '/perfil', builder: (_, __) => ProfileScreen()),
      ],
    ),
  ],
);
```

### Layout Principal (AppLayout)

```dart
// Scaffold con Drawer + BottomNavigationBar
Scaffold(
  appBar: AppBar(title: Text('SITEC'), actions: [...]),
  drawer: AppDrawer(),           // Solo en mobile portrait
  bottomNavigationBar: BottomNavigationBar(
    items: [
      BottomNavigationBarItem(icon: Icon(Icons.dashboard), label: 'Dashboard'),
      BottomNavigationBarItem(icon: Icon(Icons.task_alt), label: 'Tareas'),
      BottomNavigationBarItem(icon: Badge(count: noLeidas, child: Icon(Icons.notifications)), label: 'Notificaciones'),
      BottomNavigationBarItem(icon: Icon(Icons.person), label: 'Perfil'),
    ],
  ),
  body: child,  // GoRouter outlet
)
```

---

## 7. Pantallas - Autenticación

### Login Screen

```
┌─────────────────────────────┐
│                             │
│         [Logo SITEC]        │
│                             │
│  ┌───────────────────────┐  │
│  │ Correo electrónico    │  │
│  └───────────────────────┘  │
│  ┌───────────────────────┐  │
│  │ Contraseña            │  │
│  └───────────────────────┘  │
│  ☐ Recordarme               │
│                             │
│  ┌───────────────────────┐  │
│  │   INICIAR SESIÓN      │  │
│  └───────────────────────┘  │
│                             │
│  ¿No tienes cuenta?         │
│  Regístrate aquí            │
│                             │
└─────────────────────────────┘
```

**Campos:**
- `correo`: email, required, autofocus
- `password`: password, required

**Acciones:**
- Botón "Iniciar sesión" → llama `POST /api/auth/login`
- Link "Regístrate aquí" → navega a `/register`
- Guardar token en SharedPreferences

---

### Register Screen

```
┌─────────────────────────────┐
│                             │
│         [Logo SITEC]        │
│                             │
│  ┌───────────────────────┐  │
│  │ Nombres               │  │
│  └───────────────────────┘  │
│  ┌───────────────────────┐  │
│  │ Apellidos             │  │
│  └───────────────────────┘  │
│  ┌───────────────────────┐  │
│  │ Correo electrónico    │  │
│  └───────────────────────┘  │
│  ┌───────────────────────┐  │
│  │ Contraseña            │  │
│  └───────────────────────┘  │
│  ┌───────────────────────┐  │
│  │ Confirmar contraseña  │  │
│  └───────────────────────┘  │
│                             │
│  ┌───────────────────────┐  │
│  │    REGISTRARSE        │  │
│  └───────────────────────┘  │
│                             │
│  ¿Ya tienes cuenta?         │
│  Inicia sesión              │
│                             │
└─────────────────────────────┘
```

---

## 8. Pantallas - Dashboard (Kanban)

### Layout General

```
┌─────────────────────────────────────────┐
│  Tablero de solicitudes                  │
│  Control de tareas, técnicos y evidencias│
│                           [+ Nueva sol.] │
├─────────────────────────────────────────┤
│  🔍 [Buscar...]  [Estado ▼] [Prioridad ▼]│
├─────────────────────────────────────────┤
│  ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐   │
│  │  5   │ │  12  │ │  25  │ │  6   │   │
│  │Pend. │ │Curso │ │Final.│ │Técni.│   │
│  └──────┘ └──────┘ └──────┘ └──────┘   │
├─────────────────────────────────────────┤
│  ┌──────────┐┌──────────┐┌──────────┐   │
│  │Pendientes││En proceso││Observadas│   │
│  │    (3)   ││    (5)   ││    (2)   │   │
│  │┌────────┐││┌────────┐││          │   │
│  ││T-001   ││││T-003   │││          │   │
│  ││Impresora││││Red no  │││          │   │
│  ││[ALTA]  ││││funciona│││          │   │
│  │└────────┘│││[MEDIA] │││          │   │
│  │┌────────┐││└────────┘││          │   │
│  ││T-002   │││┌────────┐││          │   │
│  ││PC lenta││││T-004   │││          │   │
│  ││[MEDIA] ││││Monitor │││          │   │
│  │└────────┘│││[BAJA]  │││          │   │
│  └──────────┘│└────────┘│└──────────┘   │
│              └──────────┘               │
│  ┌──────────┐                           │
│  │Finalizad.│                           │
│  │   (25)   │                           │
│  │┌────────┐│                           │
│  ││T-005   ││                           │
│  ││Software││                           │
│  ││[CRITIC]││                           │
│  │└────────┘│                           │
│  └──────────┘                           │
└─────────────────────────────────────────┘
```

### Tarjeta de Tarea (expandible)

**Colapsado:**
```
┌──────────────────────────┐
│ T-001 Impresora no fun...│ [▶]
└──────────────────────────┘
```

**Expandido:**
```
┌──────────────────────────┐
│ T-001 Impresora no fun...│ [◀]
├──────────────────────────┤
│ [🔴 ALTA]                │
│                          │
│ 📍 Oficina Central       │
│    Oficina 201           │
│ 👤 María García          │
│ 🔧 Carlos López          │
│ 📷 2 evidencias          │
│                          │
│ [Aceptar] [Ver detalle]  │
└──────────────────────────┘
```

### Colores de la Tarjeta por Prioridad

```dart
Color getPriorityColor(String prioridad) {
  switch (prioridad) {
    case 'critica': return Color(0xFFfee2e2);
    case 'alta': return Color(0xFFfee2e2);
    case 'media': return Color(0xFFfef3c7);
    case 'baja': return Color(0xFFdcfce7);
    default: return Colors.grey.shade100;
  }
}

Color getPriorityTextColor(String prioridad) {
  switch (prioridad) {
    case 'critica': return Color(0xFFb91c1c);
    case 'alta': return Color(0xFFb91c1c);
    case 'media': return Color(0xFF92400e);
    case 'baja': return Color(0xFF166534);
    default: return Colors.grey;
  }
}
```

---

## 9. Pantallas - Tareas

### Listado de Tareas

```
┌─────────────────────────────────────────┐
│  ← Tareas                    [+ Nueva]  │
├─────────────────────────────────────────┤
│  🔍 [Buscar por código o título...]     │
├─────────────────────────────────────────┤
│  ┌────────────────────────────────────┐ │
│  │ T-001 │ Impresora... │ Alta  │ ... │ │
│  ├────────────────────────────────────┤ │
│  │ T-002 │ PC lenta    │ Media │ ... │ │
│  ├────────────────────────────────────┤ │
│  │ T-003 │ Red caída  │ Alta  │ ... │ │
│  └────────────────────────────────────┘ │
└─────────────────────────────────────────┘
```

### Crear Tarea

```
┌─────────────────────────────────────────┐
│  ← Nueva Tarea                          │
├─────────────────────────────────────────┤
│  Título *                                │
│  ┌─────────────────────────────────────┐│
│  └─────────────────────────────────────┘│
│  Descripción *                           │
│  ┌─────────────────────────────────────┐│
│  │                                     ││
│  └─────────────────────────────────────┘│
│  Tipo de Soporte *     Prioridad *       │
│  ┌──────────────┐  ┌──────────────┐     │
│  │ Hardware   ▼│  │ Media      ▼│     │
│  └──────────────┘  └──────────────┘     │
│  Ubicación                              │
│  ┌─────────────────────────────────────┐│
│  └─────────────────────────────────────┘│
│  Oficina                                 │
│  ┌─────────────────────────────────────┐│
│  │ Oficina Central                   ▼││
│  └─────────────────────────────────────┘│
│                                         │
│  [Cancelar]              [Guardar]      │
└─────────────────────────────────────────┘
```

### Detalle de Tarea

```
┌─────────────────────────────────────────┐
│  ← T-001                  [🔴 ALTA]     │
│  Impresora no funciona    [en_proceso]  │
├─────────────────────────────────────────┤
│                                         │
│  ┌─ INFORMACIÓN GENERAL ─────────────┐  │
│  │ Código: T-001                     │  │
│  │ Título: Impresora no funciona     │  │
│  │ Tipo: Impresión                   │  │
│  │ Prioridad: Alta                   │  │
│  │ Estado: En proceso                │  │
│  │ Ubicación: Oficina 201            │  │
│  │ Solicitante: María García         │  │
│  │ Oficina: Oficina Central          │  │
│  │ Asignado a: Carlos López          │  │
│  │                                   │  │
│  │ Descripción:                      │  │
│  │ La impresora del 2do piso no      │  │
│  │ imprime, hace ruido extraño.      │  │
│  │                                   │  │
│  │ [Editar] [Cancelar tarea]         │  │
│  └───────────────────────────────────┘  │
│                                         │
│  ┌─ REGISTRAR ATENCIÓN ──────────────┐  │
│  │ Diagnóstico *                     │  │
│  │ ┌────────────────────────────────┐│  │
│  │ └────────────────────────────────┘│  │
│  │ Actividades Realizadas            │  │
│  │ ┌────────────────────────────────┐│  │
│  │ └────────────────────────────────┘│  │
│  │ Solución Aplicada                 │  │
│  │ ┌────────────────────────────────┐│  │
│  │ └────────────────────────────────┘│  │
│  │ Tiempo (min)                      │  │
│  │ ┌──────────┐                      │  │
│  │ │ 30       │                      │  │
│  │ └──────────┘                      │  │
│  │              [Guardar Atención]   │  │
│  └───────────────────────────────────┘  │
│                                         │
│  ┌─ EVIDENCIAS (2) ──────────────────┐  │
│  │ 📄 foto_001.jpg    [Ver] [Eliminar]│  │
│  │ 📄 foto_002.png    [Ver] [Eliminar]│  │
│  │                    [Tomar foto]    │  │
│  └───────────────────────────────────┘  │
│                                         │
│  ┌─ COMENTARIOS ─────────────────────┐  │
│  │ 👤 Carlos López - 16/07 12:00     │  │
│  │ Ya revisé la impresora...          │  │
│  │                                    │  │
│  │ 👤 María García - 16/07 13:00     │  │
│  │ Gracias, ¿ya queda lista?         │  │
│  │                                    │  │
│  │ ┌────────────────────┐ [Enviar]   │  │
│  │ │ Escribir...        │            │  │
│  │ └────────────────────┘            │  │
│  └───────────────────────────────────┘  │
│                                         │
│  ┌─ FORMATO DE ATENCIÓN ─────────────┐  │
│  │ El formato de atención ya fue      │  │
│  │ generado.                          │  │
│  │ [Ver Formato] [Descargar PDF]      │  │
│  └───────────────────────────────────┘  │
│                                         │
│  ┌─ HISTORIAL DE ASIGNACIONES ───────┐  │
│  │ Carlos López │ Manual │ 16/07 11:00│  │
│  │              │ [Activa]            │  │
│  └───────────────────────────────────┘  │
└─────────────────────────────────────────┘
```

---

## 10. Pantallas - Formato de Atención

### Crear Formato

```
┌─────────────────────────────────────────┐
│  ← Formato de Atención                  │
│    T-001: Impresora no funciona         │
├─────────────────────────────────────────┤
│                                         │
│  ┌─ DATOS DEL EQUIPO ────────────────┐  │
│  │ Equipo existente: [Seleccionar ▼] │  │
│  │ Tipo: [Impresora        ]         │  │
│  │ Cod. Patrimonial: [IMP-001]       │  │
│  │ N° Serie: [SN12345       ]        │  │
│  │ Marca: [HP              ]         │  │
│  │ Modelo: [LaserJet Pro   ]         │  │
│  └───────────────────────────────────┘  │
│                                         │
│  ┌─ DATOS DEL SOLICITANTE ───────────┐  │
│  │ Nombres *       Apellidos *        │  │
│  │ [María      ]  [García       ]    │  │
│  │ DNI             Teléfono Móvil     │  │
│  │ [12345678  ]  [999999999    ]     │  │
│  │ Régimen Laboral    Cargo           │  │
│  │ [Nombrado      ] [Asistente  ]    │  │
│  │ Unidad de Organización             │  │
│  │ [Oficina Central            ]      │  │
│  └───────────────────────────────────┘  │
│                                         │
│  ┌─ DETALLE DE ATENCIÓN ─────────────┐  │
│  │ Tipo Soporte Info. *               │  │
│  │ [Impresión                    ▼]  │  │
│  │ Reporte del Usuario *              │  │
│  │ ┌────────────────────────────────┐│  │
│  │ │ La impresora no imprime...     ││  │
│  │ └────────────────────────────────┘│  │
│  │ Diagnóstico Técnico                │  │
│  │ ┌────────────────────────────────┐│  │
│  │ └────────────────────────────────┘│  │
│  │ Observaciones                      │  │
│  │ ┌────────────────────────────────┐│  │
│  │ └────────────────────────────────┘│  │
│  └───────────────────────────────────┘  │
│                                         │
│  ┌─ FECHAS Y RESPONSABLE ────────────┐  │
│  │ Fecha Atención   Hora Atención     │  │
│  │ [2026-07-16]    [11:30        ]   │  │
│  │ Fecha Entrega    Hora Entrega      │  │
│  │ [2026-07-16]    [14:00        ]   │  │
│  │ Responsable                         │  │
│  │ [Carlos López              ]       │  │
│  └───────────────────────────────────┘  │
│                                         │
│  ┌─ FIRMAS ──────────────────────────┐  │
│  │ Responsable:                       │  │
│  │ ┌────────────────────────────────┐│  │
│  │ │   [Firma aquí con el dedo]     ││  │
│  │ │                                ││  │
│  │ └────────────────────────────────┘│  │
│  │ [Limpiar]                          │  │
│  │                                    │  │
│  │ Solicitante:                       │  │
│  │ ┌────────────────────────────────┐│  │
│  │ │   [Firma aquí con el dedo]     ││  │
│  │ │                                ││  │
│  │ └────────────────────────────────┘│  │
│  │ [Limpiar]                          │  │
│  └───────────────────────────────────┘  │
│                                         │
│  [Cancelar]       [Generar Formato]     │
└─────────────────────────────────────────┘
```

### Implementación de Firmas (CustomPainter)

```dart
class SignatureCanvas extends StatefulWidget {
  final Function(String base64) onSignature;

  @override
  _SignatureCanvasState createState() => _SignatureCanvasState();
}

class _SignatureCanvasState extends State<SignatureCanvas> {
  List<Offset> points = [];

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        GestureDetector(
          onPanUpdate: (details) {
            setState(() {
              points.add(details.localPosition);
            });
          },
          child: CustomPaint(
            painter: SignaturePainter(points),
            size: Size(double.infinity, 150),
          ),
        ),
        TextButton(
          onPressed: () => setState(() => points.clear()),
          child: Text('Limpiar'),
        ),
      ],
    );
  }

  String toBase64() {
    // Convertir puntos a imagen y luego a base64
  }
}

class SignaturePainter extends CustomPainter {
  final List<Offset> points;
  SignaturePainter(this.points);

  @override
  void paint(Canvas canvas, Size size) {
    final paint = Paint()
      ..color = Colors.black
      ..strokeWidth = 2.0
      ..strokeCap = StrokeCap.round;

    for (int i = 0; i < points.length - 1; i++) {
      canvas.drawLine(points[i], points[i + 1], paint);
    }
  }

  @override
  bool shouldRepaint(covariant CustomPainter oldDelegate) => true;
}
```

---

## 11. Pantallas - Notificaciones

```
┌─────────────────────────────────────────┐
│  ← Notificaciones           [Leer todas]│
├─────────────────────────────────────────┤
│  ┌─────────────────────────────────────┐│
│  │ 🔵 Tarea asignada                   ││
│  │ Se te ha asignado la tarea T-001    ││
│  │ Ver tarea T-001                     ││
│  │ 16/07/2026 11:00        [Marcar ✓] ││
│  ├─────────────────────────────────────┤│
│  │ ⚪ Nueva solicitud creada            ││
│  │ Se creó la solicitud T-002: PC lenta││
│  │ Ver tarea T-002                     ││
│  │ 16/07/2026 10:30                    ││
│  ├─────────────────────────────────────┤│
│  │ ⚪ Tarea finalizada                  ││
│  │ La tarea T-003 ha sido finalizada   ││
│  │ Ver tarea T-003                     ││
│  │ 16/07/2026 09:15                    ││
│  └─────────────────────────────────────┘│
└─────────────────────────────────────────┘
```

- **No leídas**: fondo `Color(0xFFdbeafe)` (blue-50), badge azul en el ícono
- **Leídas**: fondo blanco
- Tapping en notificación → navega a detalle de tarea

---

## 12. Pantallas - Gestión (Solo Jefe)

### Usuarios

```
┌─────────────────────────────────────────┐
│  ← Usuarios                 [＋ Nuevo]  │
├─────────────────────────────────────────┤
│  ┌──────┬────────┬──────────┬─────┬───┐ │
│  │Nombre│Apellido│Correo    │Rol  │Act│ │
│  ├──────┼────────┼──────────┼─────┼───┤ │
│  │Juan  │Pérez   │j@correo │Jefe │ ✓│ │
│  │Carlos│López   │c@correo │Prac.│ ✓│ │
│  │María │García  │m@correo │Sol. │ ✓│ │
│  └──────┴────────┴──────────┴─────┴───┘ │
└─────────────────────────────────────────┘
```

### Oficinas

```
┌─────────────────────────────────────────┐
│  ← Oficinas                 [＋ Nueva]  │
├─────────────────────────────────────────┤
│  ┌──────────────┬────────────┬────────┐ │
│  │ Nombre       │ Ubicación  │Acciones│ │
│  ├──────────────┼────────────┼────────┤ │
│  │ Of. Central  │ Piso 2     │ ✏️ 🗑️  │ │
│  │ Of. Sistema  │ Piso 3     │ ✏️ 🗑️  │ │
│  └──────────────┴────────────┴────────┘ │
└─────────────────────────────────────────┘
```

### Equipos

```
┌─────────────────────────────────────────┐
│  ← Equipos                  [＋ Nuevo]  │
├─────────────────────────────────────────┤
│  ┌──────┬──────┬──────┬─────┬────┬───┐  │
│  │Tipo  │Cód.P │Marca │Model│Ofic│Act│  │
│  ├──────┼──────┼──────┼─────┼────┼───┤  │
│  │PC    │CP-001│HP    │ProD │Cen.│ ✓│  │
│  │Impre.│IMP-01│Canon │iR25 │Cen.│ ✓│  │
│  └──────┴──────┴──────┴─────┴────┴───┘  │
└─────────────────────────────────────────┘
```

---

## 13. Componentes UI Reutilizables

### PriorityBadge

```dart
class PriorityBadge extends StatelessWidget {
  final String prioridad;

  Color get _bgColor => switch (prioridad) {
    'critica' => Color(0xFFfee2e2),
    'alta' => Color(0xFFfee2e2),
    'media' => Color(0xFFfef3c7),
    'baja' => Color(0xFFdcfce7),
    _ => Colors.grey.shade100,
  };

  Color get _textColor => switch (prioridad) {
    'critica' => Color(0xFFb91c1c),
    'alta' => Color(0xFFb91c1c),
    'media' => Color(0xFF92400e),
    'baja' => Color(0xFF166534),
    _ => Colors.grey,
  };

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: EdgeInsets.symmetric(horizontal: 10, vertical: 4),
      decoration: BoxDecoration(
        color: _bgColor,
        borderRadius: BorderRadius.circular(20),
      ),
      child: Text(
        prioridad.toUpperCase(),
        style: TextStyle(color: _textColor, fontSize: 11, fontWeight: FontWeight.bold),
      ),
    );
  }
}
```

### StatusBadge

```dart
class StatusBadge extends StatelessWidget {
  final String estado;

  Color get _bgColor => switch (estado) {
    'finalizado' => Color(0xFF22c55e),
    'cancelado' => Color(0xFFef4444),
    _ => Color(0xFFe5e7eb),
  };

  Color get _textColor => switch (estado) {
    'finalizado' => Colors.white,
    'cancelado' => Colors.white,
    _ => Color(0xFF374151),
  };

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: EdgeInsets.symmetric(horizontal: 10, vertical: 4),
      decoration: BoxDecoration(
        color: _bgColor,
        borderRadius: BorderRadius.circular(20),
      ),
      child: Text(
        estado.replaceAll('_', ' ').toUpperCase(),
        style: TextStyle(color: _textColor, fontSize: 11, fontWeight: FontWeight.bold),
      ),
    );
  }
}
```

### StatCard

```dart
class StatCard extends StatelessWidget {
  final int count;
  final String label;
  final Color? color;

  @override
  Widget build(BuildContext context) {
    return Container(
      padding: EdgeInsets.all(18),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: Color(0xFFdbe4de)),
      ),
      child: Column(
        children: [
          Text(
            '$count',
            style: TextStyle(fontSize: 28, fontWeight: FontWeight.bold),
          ),
          SizedBox(height: 4),
          Text(label, style: TextStyle(color: Color(0xFF64748b), fontSize: 13)),
        ],
      ),
    );
  }
}
```

### Toast/SnackBar

```dart
void showToast(BuildContext context, String message, {bool isError = false}) {
  ScaffoldMessenger.of(context).showSnackBar(
    SnackBar(
      content: Row(
        children: [
          Icon(
            isError ? Icons.error_circle : Icons.check_circle,
            color: isError ? Colors.red : Colors.green,
          ),
          SizedBox(width: 12),
          Expanded(child: Text(message)),
        ],
      ),
      backgroundColor: Colors.white,
      behavior: SnackBarBehavior.floating,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
      duration: Duration(seconds: 3),
    ),
  );
}
```

### ConfirmDialog

```dart
Future<bool> showConfirmDialog(BuildContext context, String title, String message) async {
  final result = await showDialog<bool>(
    context: context,
    builder: (ctx) => AlertDialog(
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(16)),
      title: Text(title),
      content: Text(message),
      actions: [
        TextButton(onPressed: () => Navigator.pop(ctx, false), child: Text('Cancelar')),
        TextButton(
          onPressed: () => Navigator.pop(ctx, true),
          child: Text('Confirmar', style: TextStyle(color: Colors.red)),
        ),
      ],
    ),
  );
  return result ?? false;
}
```

---

## 14. Flujos de Negocio

### Flujo Completo de una Tarea

```
1. SOLICITANTE crea tarea
   POST /api/tareas → estado: pendiente

2. JEFE asigna practicante(s)
   POST /api/tareas/{id}/asignar → estado: asignado

3. PRACTICANTE acepta tarea
   POST /api/tareas/{id}/aceptar → estado: en_proceso

4. PRACTICANTE registra atención
   POST /api/tareas/{id}/atenciones

5. PRACTICANTE sube evidencias
   POST /api/tareas/{id}/evidencias (fotos)

6. PRACTICANTE finaliza tarea
   POST /api/tareas/{id}/finalizar → estado: finalizado

7. Se genera formato de atención
   POST /api/tareas/{id}/formatos-atencion

8. Se firman (responsable y solicitante)
   POST /api/formatos-atencion/{id}/firma

9. Se descarga PDF
   GET /api/formatos-atencion/{id}/pdf

En cualquier momento:
- JEFE puede observar → POST /api/tareas/{id}/observar → estado: observado
- JEFE puede cancelar → POST /api/tareas/{id}/cancelar → estado: cancelado
- Cualquiera puede comentar → POST /api/tareas/{id}/comentarios
```

### Flujo de Subir Foto (Cámara)

```dart
// 1. Seleccionar cámara
final picker = ImagePicker();
final XFile? image = await picker.pickImage(
  source: ImageSource.camera,
  preferredCameraDevice: CameraDevice.rear,
  maxWidth: 1920,
  maxHeight: 1080,
  imageQuality: 85,
);

// 2. Convertir a bytes
final bytes = await image!.readAsBytes();

// 3. Enviar como multipart
final formData = FormData.fromMap({
  'archivo': MultipartFile.fromBytes(bytes, filename: image.name),
  'nombre_archivo': image.name,
  'descripcion': 'Foto de evidencia',
  'tipo_evidencia': 'imagen',
});

await dio.post('/api/tareas/$tareaId/evidencias', data: formData);

// Opcional: enviar como base64
final base64Image = base64Encode(bytes);
await dio.post('/api/tareas/$tareaId/evidencias', data: {
  'archivo_base64': 'data:image/jpeg;base64,$base64Image',
  'nombre_archivo': image.name,
  'tipo_evidencia': 'imagen',
});
```

---

## 15. Roles y Permisos

| Funcionalidad | Jefe | Practicante | Solicitante |
|---|---|---|---|
| Ver Dashboard | ✓ | ✓ | ✓ |
| Crear Tareas | ✓ | ✓ | ✓ |
| Ver/Listar Tareas | ✓ | ✓ | ✓ |
| Editar Tareas | ✓ | ✓ | ✗ |
| Eliminar Tareas | ✓ | ✗ | ✗ |
| Asignar Tareas | ✓ | ✗ | ✗ |
| Auto-asignarse Tareas | ✗ | ✓ | ✗ |
| Aceptar/Iniciar Tarea | ✓ | ✓ | ✗ |
| Finalizar Tarea | ✓ | ✓ | ✗ |
| Observar Tarea | ✓ | ✗ | ✗ |
| Cancelar Tarea | ✓ | ✗ | ✗ |
| Registrar Atención | ✓ | ✓ | ✗ |
| Subir Evidencias | ✓ | ✓ | ✗ |
| Comentar | ✓ | ✓ | ✓ |
| Ver Notificaciones | ✓ | ✓ | ✓ |
| Gestionar Usuarios | ✓ | ✗ | ✗ |
| Gestionar Oficinas | ✓ | ✗ | ✗ |
| Gestionar Equipos | ✓ | ✗ | ✗ |
| Ver Formatos Atención | ✓ | ✓ | ✗ |
| Crear/Editar Formatos | ✓ | ✓ | ✗ |
| Firmar Formatos | ✓ | ✓ | ✗ |
| Solicitudes WhatsApp | ✓ | ✗ | ✗ |

---

## 16. Servicios API (Dio)

### ApiService (Base)

```dart
import 'package:dio/dio.dart';
import 'package:shared_preferences/shared_preferences.dart';

class ApiService {
  static const String baseUrl = 'http://TU_SERVIDOR/api';
  late Dio _dio;

  ApiService() {
    _dio = Dio(BaseOptions(
      baseUrl: baseUrl,
      connectTimeout: Duration(seconds: 10),
      receiveTimeout: Duration(seconds: 10),
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
    ));

    _dio.interceptors.add(InterceptorsWrapper(
      onRequest: (options, handler) async {
        final prefs = await SharedPreferences.getInstance();
        final token = prefs.getString('auth_token');
        if (token != null) {
          options.headers['Authorization'] = 'Bearer $token';
        }
        handler.next(options);
      },
      onError: (error, handler) async {
        if (error.response?.statusCode == 401) {
          final prefs = await SharedPreferences.getInstance();
          await prefs.remove('auth_token');
          // Navegar a login
        }
        handler.next(error);
      },
    ));
  }

  Dio get dio => _dio;
}
```

### AuthService

```dart
class AuthService {
  final ApiService _api = ApiService();

  Future<Map<String, dynamic>> login(String correo, String password) async {
    final response = await _api.dio.post('/auth/login', data: {
      'correo': correo,
      'password': password,
    });

    if (response.data['success']) {
      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('auth_token', response.data['data']['token']);
      await prefs.setString('user_json', jsonEncode(response.data['data']['user']));
    }

    return response.data;
  }

  Future<void> logout() async {
    await _api.dio.post('/auth/logout');
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('auth_token');
    await prefs.remove('user_json');
  }

  Future<bool> isLoggedIn() async {
    final prefs = await SharedPreferences.getInstance();
    return prefs.getString('auth_token') != null;
  }

  Usuario? getCurrentUser() {
    // Leer de SharedPreferences
  }
}
```

### TareaService

```dart
class TareaService {
  final ApiService _api = ApiService();

  Future<List<Tarea>> getTareas({String? estado, String? busqueda}) async {
    final response = await _api.dio.get('/tareas', queryParameters: {
      if (estado != null) 'estado': estado,
      if (busqueda != null) 'busqueda': busqueda,
    });
    return (response.data['data'] as List).map((j) => Tarea.fromJson(j)).toList();
  }

  Future<Tarea> getTarea(int id) async {
    final response = await _api.dio.get('/tareas/$id');
    return Tarea.fromJson(response.data['data']);
  }

  Future<Tarea> crearTarea(Map<String, dynamic> data) async {
    final response = await _api.dio.post('/tareas', data: data);
    return Tarea.fromJson(response.data['data']);
  }

  Future<void> asignar(int tareaId, List<int> practicanteIds) async {
    await _api.dio.post('/tareas/$tareaId/asignar', data: {
      'practicante_ids': practicanteIds,
    });
  }

  Future<void> aceptar(int tareaId) async {
    await _api.dio.post('/tareas/$tareaId/aceptar');
  }

  Future<void> finalizar(int tareaId) async {
    await _api.dio.post('/tareas/$tareaId/finalizar');
  }

  Future<void> observar(int tareaId) async {
    await _api.dio.post('/tareas/$tareaId/observar');
  }

  Future<void> cancelar(int tareaId) async {
    await _api.dio.post('/tareas/$tareaId/cancelar');
  }

  Future<void> autoasignar(int tareaId) async {
    await _api.dio.post('/tareas/$tareaId/autoasignar');
  }
}
```

### EvidenciaService

```dart
class EvidenciaService {
  final ApiService _api = ApiService();

  // Upload multipart (fotos desde cámara)
  Future<Evidencia> subirMultipart(int tareaId, XFile archivo, {
    String? descripcion,
  }) async {
    final formData = FormData.fromMap({
      'archivo': await MultipartFile.fromFile(
        archivo.path,
        filename: archivo.name,
      ),
      'nombre_archivo': archivo.name,
      'descripcion': descripcion,
      'tipo_evidencia': 'imagen',
    });

    final response = await _api.dio.post(
      '/tareas/$tareaId/evidencias',
      data: formData,
    );

    return Evidencia.fromJson(response.data['data']);
  }

  // Upload base64
  Future<Evidencia> subirBase64(int tareaId, Uint8List bytes, {
    required String nombreArchivo,
    String? descripcion,
  }) async {
    final base64Str = base64Encode(bytes);

    final response = await _api.dio.post('/tareas/$tareaId/evidencias', data: {
      'archivo_base64': 'data:image/png;base64,$base64Str',
      'nombre_archivo': nombreArchivo,
      'descripcion': descripcion,
      'tipo_evidencia': 'imagen',
    });

    return Evidencia.fromJson(response.data['data']);
  }

  Future<void> eliminar(int evidenciaId) async {
    await _api.dio.delete('/evidencias/$evidenciaId');
  }
}
```

---

## 17. Notas de Implementación

### Cámara y Galería

```dart
// Pubspec dependency: image_picker

final picker = ImagePicker();

// Tomar foto
final photo = await picker.pickImage(source: ImageSource.camera);

// Seleccionar de galería
final gallery = await picker.pickImage(source: ImageSource.gallery);

// Configuración recomendada
await picker.pickImage(
  source: ImageSource.camera,
  preferredCameraDevice: CameraDevice.rear,
  maxWidth: 1920,
  maxHeight: 1080,
  imageQuality: 85,
);
```

### PDF Viewer

```dart
// Para ver el PDF descargado
import 'package:flutter_pdfview/flutter_pdfview.dart';

PDFView(
  filePath: downloadedPdfPath,
  enableSwipe: true,
  swipeHorizontal: false,
  autoSpacing: true,
  pageFling: true,
);
```

### Notificaciones Push (FCM)

```dart
// 1. Configurar Firebase
await Firebase.initializeApp();

// 2. Obtener token
final token = await FirebaseMessaging.instance.getToken();
// Enviar token al backend: POST /api/auth/fcm-token

// 3. Escuchar mensajes
FirebaseMessaging.onMessage.listen((RemoteMessage message) {
  // Mostrar notificación local
});

FirebaseMessaging.onMessageOpenedApp.listen((RemoteMessage message) {
  // Navegar a pantalla específica
});
```

### Manejo de Errores

```dart
// En los servicios, manejar errores de la API
try {
  final response = await _api.dio.post('/tareas', data: data);
  return response.data;
} on DioException catch (e) {
  if (e.response?.statusCode == 422) {
    // Errores de validación
    final errors = e.response?.data['errors'];
    throw ValidationException(errors);
  } else if (e.response?.statusCode == 403) {
    throw UnauthorizedException('No autorizado');
  } else {
    throw Exception('Error de conexión');
  }
}
```

### Formulario de Firmas (CustomPainter)

```dart
class SignatureCanvas extends StatefulWidget {
  final double height;
  final Color strokeColor;
  final Function(Uint8List bytes) onSign;

  const SignatureCanvas({
    this.height = 150,
    this.strokeColor = Colors.black,
    required this.onSign,
  });

  @override
  _SignatureCanvasState createState() => _SignatureCanvasState();
}

class _SignatureCanvasState extends State<SignatureCanvas> {
  final List<Offset?> _points = [];
  final GlobalKey _repaintKey = GlobalKey();

  @override
  Widget build(BuildContext context) {
    return Column(
      children: [
        Container(
          height: widget.height,
          decoration: BoxDecoration(
            border: Border.all(color: Colors.grey.shade300),
            borderRadius: BorderRadius.circular(8),
          ),
          child: GestureDetector(
            onPanUpdate: (details) {
              setState(() {
                _points.add(details.localPosition);
              });
            },
            onPanEnd: (details) {
              _points.add(null);
            },
            child: RepaintBoundary(
              key: _repaintKey,
              child: CustomPaint(
                painter: SignaturePainter(
                  points: _points,
                  strokeColor: widget.strokeColor,
                ),
                size: Size(double.infinity, widget.height),
              ),
            ),
          ),
        ),
        Align(
          alignment: Alignment.centerRight,
          child: TextButton(
            onPressed: () => setState(() => _points.clear()),
            child: Text('Limpiar', style: TextStyle(color: Colors.grey)),
          ),
        ),
      ],
    );
  }

  void saveSignature() async {
    final boundary = _repaintKey.currentContext!
        .findRenderObject() as RenderRepaintBoundary;
    final image = await boundary.toImage(pixelRatio: 3.0);
    final byteData = await image.toByteData(format: ImageByteFormat.png);
    final bytes = byteData!.buffer.asUint8List();
    widget.onSign(bytes);
  }
}
```

---

## 18. Diagrama de Pantallas (ASCII)

```
                    ┌─────────┐
                    │  Splash │
                    └────┬────┘
                         │
              ┌──────────┴──────────┐
              │                     │
        (no auth)              (auth)
              │                     │
        ┌─────┴─────┐       ┌──────┴──────┐
        │   Login   │       │  AppLayout  │
        └─────┬─────┘       └──────┬──────┘
              │                     │
        ┌─────┴─────┐       ┌──────┴──────────────────────┐
        │ Register  │       │  BottomNav  │  Drawer       │
        └───────────┘       │  ┌────────┐ │ ┌───────────┐ │
                            │  │Dashboard│ │ │Usuarios   │ │
                            │  │Tareas   │ │ │Oficinas   │ │
                            │  │Notific. │ │ │Equipos    │ │
                            │  │Perfil   │ │ │Formatos   │ │
                            │  └────────┘ │ │WhatsApp   │ │
                            └─────────────┘ └───────────┘ │
                                                          │
                            ┌─────────────────────────────┘
                            │
                  ┌─────────┼─────────┬──────────┬──────────┐
                  │         │         │          │          │
             ┌────┴───┐ ┌───┴────┐ ┌──┴───┐ ┌───┴───┐ ┌───┴───┐
             │Dashboard│ │Tareas  │ │Crear │ │Detalle│ │Editar │
             │ (Kanban)│ │(Lista) │ │Tarea │ │Tarea  │ │Tarea  │
             └────────┘ └────────┘ └──────┘ └───┬───┘ └───────┘
                                                │
                                    ┌───────────┼───────────┬──────────┐
                                    │           │           │          │
                              ┌─────┴──┐  ┌─────┴──┐  ┌─────┴──┐ ┌────┴───┐
                              │Atencion│  │Evidenc.│  │Formato │ │Comentar│
                              │Crear   │  │Subir   │  │Crear   │ │        │
                              └────────┘  └────────┘  └────────┘ └────────┘
```

---

## 19. Resumen de APIs por Pantalla

| Pantalla | APIs que consume |
|---|---|
| Login | `POST /auth/login` |
| Register | `POST /auth/register` |
| Dashboard | `GET /dashboard` |
| Lista Tareas | `GET /tareas` |
| Crear Tarea | `POST /tareas`, `GET /oficinas`, `GET /usuarios` |
| Detalle Tarea | `GET /tareas/{id}` |
| Editar Tarea | `PUT /tareas/{id}`, `GET /oficinas`, `GET /usuarios` |
| Asignar | `POST /tareas/{id}/asignar`, `GET /usuarios` |
| Aceptar/Finalizar | `POST /tareas/{id}/aceptar`, `POST /tareas/{id}/finalizar` |
| Registrar Atención | `POST /tareas/{id}/atenciones` |
| Subir Evidencia | `POST /tareas/{id}/evidencias` |
| Comentar | `POST /tareas/{id}/comentarios` |
| Formato Atención | `POST /tareas/{id}/formatos-atencion`, `GET /tareas/{id}/formatos-atencion/defaults` |
| Firmar | `POST /formatos-atencion/{id}/firma` |
| Descargar PDF | `GET /formatos-atencion/{id}/pdf` |
| Notificaciones | `GET /notificaciones`, `POST /notificaciones/{id}/leida` |
| Usuarios | `GET/POST/PUT/DELETE /usuarios` |
| Oficinas | `GET/POST/PUT/DELETE /oficinas` |
| Equipos | `GET/POST/PUT/DELETE /equipos` |
| Profile | `GET /auth/profile`, `PUT /auth/profile` |

---

*Documento generado automáticamente. Backend API: Laravel 13 + Sanctum. Frontend: Flutter 3.x*
