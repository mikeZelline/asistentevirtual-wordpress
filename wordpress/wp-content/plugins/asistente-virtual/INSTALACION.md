# Guía Rápida de Instalación - Plugin Asistente Virtual IBUX

## Resumen

Este plugin conecta WordPress con el backend Flask del Asistente Virtual mediante API REST.

## Pasos de Instalación

### 1. Preparar el Backend Flask

#### a. Instalar dependencias adicionales

Si no tienes `flask-cors` instalado, agrégalo:

```bash
cd asistente-virtual-audios
pip install flask-cors
```

O agrégalo al `requirements.txt`:
```
flask-cors==4.0.0
```

#### b. Configurar variables de entorno

Edita el archivo `config.env` y agrega/verifica estas líneas:

```env
# Puerto para la API REST (por defecto 5002)
API_PORT=5002

# Token de autenticación (opcional pero recomendado)
API_TOKEN=tu_token_seguro_aqui_12345
```

**Nota:** Si no configuras `API_TOKEN`, el acceso será sin autenticación (solo para desarrollo).

#### c. Iniciar el servidor API

```bash
cd asistente-virtual-audios
python api.py
```

Deberías ver algo como:
```
============================================================
API REST iniciada en http://localhost:5002
Modo Debug: True
Token de API configurado: tu_token_...
============================================================
```

#### d. Verificar que funciona

Abre tu navegador y ve a: `http://localhost:5002/api/health`

Deberías ver un JSON con `{"status": "ok", ...}`

### 2. Instalar el Plugin en WordPress

El plugin ya está en `wordpress/wp-content/plugins/asistente-virtual/`

#### a. Activar el plugin

1. Ve a WordPress Admin
2. Plugins → Plugins instalados
3. Busca "Asistente Virtual IBUX"
4. Haz clic en "Activar"

#### b. Configurar el plugin

1. Ve a WordPress Admin → **Ajustes → Asistente Virtual**
2. Configura:
   - **URL del servidor Flask**: `http://localhost:5002` (o la URL donde corre tu API)
   - **Token de API**: El mismo token que configuraste en `config.env` (o déjalo vacío si no configuraste uno)
   - **Habilitar audio**: Opcional (requiere Eleven Labs configurado)
3. Haz clic en "Guardar configuración"

### 3. Usar el Plugin

#### Opción más simple: Shortcode en una página

1. Ve a WordPress Admin → **Páginas → Añadir nueva**
2. En el editor, escribe:
   ```
   [asistente_virtual]
   ```
3. Publica la página
4. Visita la página para ver el chat

#### Personalizar título y subtítulo

```
[asistente_virtual title="💬 Mi Asistente" subtitle="Asistente de ventas IBUX"]
```

### 4. Verificar que Todo Funciona

1. Abre la página donde agregaste el shortcode
2. Deberías ver el chat del asistente
3. Escribe una pregunta (ej: "¿Qué es IBUX?")
4. El asistente debería responder

## Solución Rápida de Problemas

### ❌ El chat no aparece

- ✅ Verifica que el plugin esté activado
- ✅ Verifica que escribiste el shortcode correctamente: `[asistente_virtual]`
- ✅ Abre la consola del navegador (F12) y busca errores

### ❌ Error de conexión

- ✅ Verifica que `api.py` esté corriendo (`python api.py`)
- ✅ Verifica que la URL en WordPress sea correcta (ej: `http://localhost:5002`)
- ✅ Prueba acceder a `http://localhost:5002/api/health` en el navegador

### ❌ Error 401 (No autorizado)

- ✅ Verifica que el token de API sea el mismo en `config.env` y en WordPress
- ✅ O deja ambos vacíos si estás en desarrollo

### ❌ El sistema no inicializa

- ✅ Verifica que `app.py` tenga todas las dependencias instaladas
- ✅ Verifica que el índice FAISS esté disponible en `faiss_index/`
- ✅ Revisa los logs del servidor Flask para ver errores

## Comandos Útiles

### Iniciar solo la API (sin interfaz web)

```bash
cd asistente-virtual-audios
python api.py
```

### Iniciar la aplicación Flask original (con interfaz web)

```bash
cd asistente-virtual-audios
python app.py
```

**Nota:** Puedes tener ambos corriendo al mismo tiempo en puertos diferentes:
- `app.py` en puerto 5001 (interfaz web original)
- `api.py` en puerto 5002 (API REST para WordPress)

## Estructura de Archivos

```
asistentevirtual/
├── asistente-virtual-audios/        # Backend Flask
│   ├── app.py                       # Aplicación Flask original
│   ├── api.py                       # API REST (NUEVO)
│   ├── config.env                   # Configuración
│   └── ...
└── wordpress/
    └── wp-content/
        └── plugins/
            └── asistente-virtual/   # Plugin WordPress
                ├── asistente-virtual.php
                ├── includes/
                ├── templates/
                └── assets/
```

## Próximos Pasos

Una vez que todo funcione:

1. **Producción:**
   - Usa HTTPS
   - Configura un token de API seguro
   - Considera usar un servidor WSGI como Gunicorn

2. **Personalización:**
   - Edita `templates/chat-template.php` para cambiar el diseño
   - Edita `assets/css/style.css` para cambiar los estilos
   - Edita `assets/js/chat.js` para cambiar la funcionalidad

¡Listo! Tu asistente virtual ya está disponible en WordPress 🎉

