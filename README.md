# Simulador-de-turno-bancario
Ejercicio en la clase 20/02/2026

---

## Descripción General

Sistema web de gestión de turnos bancarios desarrollado en Laravel. Permite a los usuarios registrarse en una fila virtual seleccionando su tipo de trámite, recibir un número de turno asignado automáticamente y visualizar cuántas personas están en espera antes que ellos.

---

## Usuarios del Sistema

El sistema contempla dos tipos de actores:

**Cliente (usuario final):** Persona que llega al banco y desea tomar un turno. No requiere registro ni autenticación. Interactúa con el sistema desde cualquier navegador.

**Sistema interno:** Laravel actúa como backend gestionando la lógica de asignación de turnos, almacenamiento en sesión y conteo de espera.

---

## Tipos de Trámite

El cliente puede seleccionar uno de tres servicios disponibles, cada uno con su propio prefijo de turno:

| Trámite | Prefijo | Ejemplo de turno |
|---|---|---|
| Caja | C | C-001 |
| Servicio al Cliente | S | S-001 |
| Créditos | R | R-001 |

Cada fila es independiente. Un turno C-003 y un S-003 coexisten sin conflicto.

---

## Funcionalidades del Sistema

### Registro de turno
- El usuario ingresa su **nombre completo**
- Selecciona su **tipo de trámite**
- El sistema genera automáticamente un **número de turno correlativo** por tipo
- Se muestra la pantalla de confirmación con el turno asignado

### Pantalla de confirmación
Después de registrarse, el cliente ve:
- Su nombre
- Su número de turno (ej: C-004)
- El tipo de trámite seleccionado
- **Cuántas personas hay antes que él** en esa fila

### Estado de las filas *(vista informativa)*
Una sección que muestra el resumen actual de las tres filas: cuántas personas están esperando en Caja, Servicio al Cliente y Créditos.

---

## Interfaz de Usuario

La aplicación tiene **dos vistas principales:**

**Vista 1 — Formulario de registro (`/turno`)**
- Campo de texto: nombre del cliente
- Selector tipo radio o dropdown: tipo de trámite
- Botón: "Tomar turno"
- Panel informativo con el estado actual de las filas

**Vista 2 — Confirmación del turno (tras el POST)**
- Tarjeta destacada con el número de turno asignado
- Mensaje personalizado con el nombre del cliente
- Indicador de personas en espera antes que él
- Botón para volver y registrar otro turno

**Estilo visual:** Interfaz limpia, colores corporativos tipo bancario (azul/blanco), diseño responsivo con CSS propio sin frameworks externos.

---

## Lógica del Programa

### Almacenamiento
Los turnos se guardan en la **sesión de Laravel** (`session()`), sin necesidad de base de datos. La estructura en sesión es la siguiente:

```php
turnos = [
    'caja'     => [['nombre' => 'Juan', 'turno' => 'C-001'], ...],
    'servicio' => [...],
    'creditos' => [...],
]
```

### Asignación del número de turno
Cuando el usuario envía el formulario, el sistema:
1. Lee la sesión para obtener la fila del trámite seleccionado
2. Cuenta cuántos turnos existen ya en esa fila → ese número es la cantidad de personas antes
3. Calcula el siguiente número correlativo (total actual + 1)
4. Formatea el turno con su prefijo usando `str_pad` (ej: `C-004`)
5. Agrega el nuevo registro al arreglo de sesión
6. Retorna la vista de confirmación con los datos

### Cálculo de personas en espera
```
personas_antes = cantidad de turnos en la fila ANTES de agregar el turno actual
```
Si hay 3 personas en Caja y el usuario se registra como cuarto, verá: *"Hay 3 personas antes que usted"*.

---

## Estructura de Archivos en Laravel

```
routes/
  web.php                       ← Rutas GET y POST

app/Http/Controllers/
  TurnoController.php           ← Lógica principal

resources/views/
  turno.blade.php               ← Formulario + confirmación
```

---

## Rutas de la Aplicación

| Método | URL | Acción | Descripción |
|---|---|---|---|
| GET | `/turno` | `TurnoController@index` | Muestra el formulario |
| POST | `/turno` | `TurnoController@registrar` | Procesa y asigna turno |
| GET | `/turno/reset` | `TurnoController@reset` | Limpia todos los turnos |

---

## Restricciones y Consideraciones

- **Sin base de datos:** Todo se maneja con sesión, coherente con el nivel del ejercicio
- **Sin autenticación:** Cualquier usuario puede tomar un turno
- **Validación básica:** El nombre no puede estar vacío y el trámite debe ser uno de los tres válidos
- **La sesión se reinicia** si se cierra el navegador o se ejecuta `/turno/reset`
- Se aplica la misma configuración de proxy y `.env` usada en Codespaces (ver guía de referencia)

---

## Tecnologías Utilizadas

- PHP / Laravel
- Blade Templates
- Session de Laravel (sin base de datos)
- CSS propio
- GitHub Codespaces

---

*Desarrollado como ejercicio académico — Universidad Tecnológica de Santander (UTS)*
