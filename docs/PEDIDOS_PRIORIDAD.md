# Sistema de Prioridades en Pedidos

## ¿Qué es la Prioridad?

La **prioridad** es un campo que indica el nivel de urgencia o importancia de un pedido. Permite al equipo de trabajo identificar rápidamente qué pedidos requieren atención inmediata y cuáles pueden procesarse en el orden normal de trabajo.

---

## Niveles de Prioridad

### 1. Normal (Valor por defecto)
- **Descripción:** Pedido estándar sin urgencia especial
- **Indicador visual:** Etiqueta gris con texto "Normal"
- **Tiempo de atención:** Se procesa en el orden habitual de llegada (FIFO - First In, First Out)
- **Uso típico:**
  - Pedidos regulares de clientes
  - Solicitudes sin fecha límite cercana
  - Productos de stock disponible

### 2. Urgente
- **Descripción:** Pedido que requiere atención inmediata
- **Indicador visual:** Etiqueta roja con icono de advertencia y texto "Urgente"
- **Tiempo de atención:** Debe procesarse antes que los pedidos normales
- **Uso típico:**
  - Cliente necesita el producto/servicio con urgencia
  - Fecha de vencimiento próxima
  - Reparaciones críticas de vehículos
  - Clientes VIP o mayoristas importantes
  - Pedidos con penalidades por demora

---

## Indicadores Visuales en el Sistema

### En la Tabla de Pedidos (Index)
```
Normal:   [Normal]        - Fondo gris claro, texto gris
Urgente:  [⚠ Urgente]    - Fondo rojo claro, texto rojo, con icono de advertencia
```

### En las Estadísticas
Los pedidos urgentes se cuentan junto con los demás pero se destacan visualmente para identificación rápida.

---

## Casos de Uso Detallados

### Caso 1: Taller Mecánico
**Situación:** Un cliente llega con su vehículo averiado y necesita la reparación urgente porque lo usa para trabajar.

**Acción:**
- Crear pedido con prioridad "Urgente"
- El mecánico verá el pedido destacado en rojo
- Se atenderá antes que otros pedidos pendientes

### Caso 2: Venta Mayorista
**Situación:** Un cliente mayorista necesita 50 unidades de un producto para una fecha específica muy cercana.

**Acción:**
- Crear pedido con prioridad "Urgente"
- Establecer fecha de expiración
- El equipo de ventas priorizará la preparación

### Caso 3: Pedido Regular
**Situación:** Un cliente solicita repuestos para su vehículo sin urgencia particular.

**Acción:**
- Crear pedido con prioridad "Normal" (valor por defecto)
- Se procesará en orden de llegada

---

## Flujo de Trabajo con Prioridades

```
┌─────────────────┐
│  Nuevo Pedido   │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│ ¿Es urgente?    │
└────────┬────────┘
         │
    ┌────┴────┐
    │         │
   SÍ        NO
    │         │
    ▼         ▼
┌───────┐ ┌───────┐
│Urgente│ │Normal │
└───┬───┘ └───┬───┘
    │         │
    ▼         ▼
┌─────────────────┐
│ Cola de Pedidos │
│ (Urgentes       │
│  primero)       │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│   Procesamiento │
└─────────────────┘
```

---

## Campos Relacionados

### Fecha de Expiración (`expires_at`)
Complementa la prioridad indicando cuándo debe completarse el pedido.

| Prioridad | Fecha Expiración | Interpretación |
|-----------|------------------|----------------|
| Normal    | Sin fecha        | Sin urgencia, procesar cuando sea posible |
| Normal    | Con fecha        | Completar antes de la fecha indicada |
| Urgente   | Sin fecha        | Atender lo antes posible |
| Urgente   | Con fecha        | Máxima prioridad, fecha límite estricta |

### Observaciones (`observation`)
Campo de texto libre para agregar contexto adicional sobre la urgencia:
- "Cliente viaja mañana"
- "Vehículo inmovilizado"
- "Pedido para evento del sábado"

---

## Implementación Técnica

### Base de Datos
```sql
ALTER TABLE pedidos ADD COLUMN priority ENUM('normal', 'urgente') DEFAULT 'normal';
```

### Modelo (Pedido.php)
```php
protected $fillable = [
    // ...
    'priority',
    // ...
];
```

### Controlador
```php
// Al crear pedido
'priority' => $request->priority ?? 'normal',
```

### Vista (Blade)
```html
<select id="priority" class="w-full p-2 border rounded">
    <option value="normal">Normal</option>
    <option value="urgente">Urgente</option>
</select>
```

---

## Recomendaciones de Uso

### DO (Hacer)
- Usar "Urgente" solo cuando realmente sea necesario
- Agregar observaciones explicando la razón de urgencia
- Establecer fecha de expiración para pedidos urgentes
- Revisar pedidos urgentes al inicio de cada turno

### DON'T (No hacer)
- No marcar todos los pedidos como urgentes (pierde el sentido)
- No ignorar la prioridad al procesar pedidos
- No cambiar prioridad sin notificar al cliente
- No dejar pedidos urgentes sin atender por más de 24 horas

---

## Posibles Mejoras Futuras

1. **Más niveles de prioridad:**
   - Baja
   - Normal
   - Alta
   - Urgente
   - Crítica

2. **Notificaciones automáticas:**
   - Alerta cuando un pedido urgente lleva más de X horas sin atender
   - Email/SMS al responsable

3. **Reportes:**
   - Tiempo promedio de atención por prioridad
   - Porcentaje de pedidos urgentes vs normales
   - Cumplimiento de fechas de expiración

4. **Asignación automática:**
   - Asignar pedidos urgentes a personal específico
   - Balance de carga de trabajo

---

## Preguntas Frecuentes

### ¿Puedo cambiar la prioridad después de crear el pedido?
Sí, mientras el pedido esté en estado "pendiente" o "confirmado" puedes editarlo y cambiar la prioridad.

### ¿Qué pasa si no selecciono prioridad?
El sistema asigna automáticamente "Normal" como valor por defecto.

### ¿Los pedidos urgentes aparecen primero en la lista?
Por defecto, la tabla ordena por fecha de creación (más recientes primero). Puedes ordenar manualmente por la columna de prioridad haciendo clic en el encabezado.

### ¿Afecta la prioridad al precio?
No, la prioridad es solo para gestión interna. Si deseas cobrar extra por servicio urgente, debes agregarlo como un servicio adicional.
