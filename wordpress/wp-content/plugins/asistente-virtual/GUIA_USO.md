# Guía de Uso del Plugin Asistente Virtual IBUX

## 📋 Índice

1. [Instalación Rápida](#instalación-rápida)
2. [Configuración](#configuración)
3. [Uso del Plugin](#uso-del-plugin)
4. [Personalización](#personalización)
5. [Preguntas Frecuentes](#preguntas-frecuentes)

---

## Instalación Rápida

### Paso 1: Iniciar el Backend Flask

Abre una terminal y ejecuta:

```bash
cd asistente-virtual-audios
python api.py
```

Deberías ver:
```
============================================================
API REST iniciada en http://localhost:5002
Modo Debug: True
============================================================
```

**Importante:** Deja esta terminal abierta mientras uses el plugin.

### Paso 2: Activar el Plugin en WordPress

1. Ve a **WordPress Admin → Plugins**
2. Busca **"Asistente Virtual IBUX"**
3. Haz clic en **"Activar"**

### Paso 3: Configurar el Plugin

1. Ve a **WordPress Admin → Ajustes → Asistente Virtual**
2. Configura:
   - **URL del servidor Flask**: `http://localhost:5002`
   - **Token de API**: (déjalo vacío si no configuraste uno en `config.env`)
3. Haz clic en **"Guardar configuración"**

### Paso 4: Agregar el Chat a una Página

1. Ve a **Páginas → Añadir nueva**
2. Escribe el shortcode: `[asistente_virtual]`
3. Publica la página
4. ¡Listo! Visita la página para ver el chat

---

## Configuración

### Configuración Básica

En **WordPress Admin → Ajustes → Asistente Virtual** puedes configurar:

- **URL del servidor Flask**: La dirección donde corre tu API (ej: `http://localhost:5002` o `https://api.tudominio.com`)
- **Token de API**: Token de seguridad (opcional, pero recomendado en producción)
- **Habilitar audio**: Activa la conversión de texto a voz (requiere Eleven Labs configurado)

### Configuración Avanzada del Backend

Edita `asistente-virtual-audios/config.env`:

```env
# Puerto de la API (por defecto 5002)
API_PORT=5002

# Token de autenticación (debe coincidir con WordPress)
API_TOKEN=mi_token_secreto

# Puerto de la app Flask original (opcional)
PORT=5001

# API Keys
OPENAI_API_KEY=tu_key_aqui
ELEVENLABS_API_KEY=tu_key_aqui
```

---

## Uso del Plugin

### Uso Básico: Shortcode

El shortcode más simple:

```
[asistente_virtual]
```

### Personalizar Título y Subtítulo

```
[asistente_virtual title="💬 Mi Asistente Personal" subtitle="Asistente de ventas IBUX"]
```

### Ubicaciones donde Puedes Usarlo

✅ **Páginas y Entradas**
- Simplemente escribe el shortcode en el editor

✅ **Widgets**
- Ve a **Apariencia → Widgets**
- Agrega un widget de "Texto" o "HTML"
- Inserta el shortcode

✅ **Templates PHP**
```php
<?php echo do_shortcode('[asistente_virtual]'); ?>
```

✅ **Bloques Gutenberg**
- Agrega un bloque "Shortcode"
- Escribe: `[asistente_virtual]`

---

## Personalización

### Cambiar Estilos CSS

Edita: `wordpress/wp-content/plugins/asistente-virtual/assets/css/style.css`

Ejemplo: Cambiar el color del header

```css
.chat-header {
    background: linear-gradient(135deg, #tu-color-1 0%, #tu-color-2 100%);
}
```

### Cambiar el Template HTML

Edita: `wordpress/wp-content/plugins/asistente-virtual/templates/chat-template.php`

### Cambiar Funcionalidad JavaScript

Edita: `wordpress/wp-content/plugins/asistente-virtual/assets/js/chat.js`

---

## Preguntas Frecuentes

### ¿Puedo usar el chat en múltiples páginas?

✅ **Sí**, puedes usar el shortcode `[asistente_virtual]` en tantas páginas como quieras. Cada página tendrá su propio chat independiente.

### ¿Cómo funcionan las sesiones?

El plugin usa cookies del navegador para mantener el historial de conversación durante ~2 horas. Cada usuario tiene su propia sesión.

### ¿Puedo usar el chat sin conexión a internet?

❌ **No**, el chat requiere conexión a internet porque se comunica con:
- El servidor Flask (que puede estar local o remoto)
- La API de OpenAI (para generar respuestas)
- La API de Eleven Labs (si el audio está habilitado)

### ¿El chat funciona en móviles?

✅ **Sí**, el chat es completamente responsivo y funciona en dispositivos móviles.

### ¿Puedo usar reconocimiento de voz?

✅ **Sí**, el botón de micrófono está disponible. Funciona en navegadores modernos (Chrome, Edge, Safari) y requiere permisos del micrófono.

### ¿Puedo personalizar el comportamiento del asistente?

✅ **Sí**, puedes editar el prompt base en `asistente-virtual-audios/app.py` en la función `build_base_prompt()`.

### ¿Cómo actualizo el plugin?

1. Reemplaza la carpeta `asistente-virtual` en `wp-content/plugins/`
2. O desactiva y reactiva el plugin en WordPress

### ¿Necesito mantener `api.py` corriendo siempre?

✅ **Sí**, para que el plugin funcione, el servidor API debe estar corriendo. En producción, considera usar un servicio como:
- **systemd** (Linux)
- **Supervisor**
- **PM2**
- Un servicio de Windows

### ¿Puedo usar HTTPS?

✅ **Sí**, y es recomendado en producción:
1. Configura HTTPS en tu servidor Flask
2. En WordPress, configura la URL como: `https://tu-servidor.com:5002`

---

## Solución de Problemas

### El chat no aparece

1. ✅ Verifica que el plugin esté activado
2. ✅ Verifica que el shortcode esté correcto: `[asistente_virtual]`
3. ✅ Abre la consola del navegador (F12) y busca errores JavaScript

### Error de conexión

1. ✅ Verifica que `python api.py` esté corriendo
2. ✅ Verifica la URL en WordPress (debe ser accesible)
3. ✅ Prueba acceder a `http://localhost:5002/api/health` en el navegador

### Error 401 (No autorizado)

1. ✅ Verifica que el token de API sea el mismo en `config.env` y WordPress
2. ✅ O deja ambos vacíos si estás en desarrollo

### El asistente no responde bien

1. ✅ Verifica que el índice FAISS esté cargado correctamente
2. ✅ Revisa los logs del servidor Flask para ver errores
3. ✅ Verifica que la API key de OpenAI esté configurada correctamente

---

## Soporte

Para más ayuda, consulta:
- **README.md**: Documentación completa del plugin
- **INSTALACION.md**: Guía detallada de instalación
- Logs del servidor Flask para ver errores

---

¡Disfruta usando el Asistente Virtual IBUX! 🚀

