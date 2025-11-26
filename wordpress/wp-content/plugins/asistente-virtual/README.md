# Plugin Asistente Virtual IBUX para WordPress

Este plugin permite integrar el Asistente Virtual de entrenamiento comercial IBUX en cualquier sitio WordPress. El plugin se comunica con el backend Flask mediante API REST.

## Requisitos Previos

1. **WordPress** instalado y funcionando
2. **Servidor Flask** corriendo con el backend del asistente virtual
3. **Python 3.11+** con todas las dependencias instaladas (ver `requirements.txt` del backend)

## Estructura del Plugin

```
asistente-virtual/
├── asistente-virtual.php          # Archivo principal del plugin
├── includes/
│   ├── class-asistente-virtual.php    # Clase principal
│   ├── class-admin-settings.php        # Panel de administración
│   └── class-api-handler.php          # Manejo de peticiones AJAX
├── templates/
│   └── chat-template.php              # Template del chat
├── assets/
│   ├── css/
│   │   └── style.css                  # Estilos del chat
│   └── js/
│       └── chat.js                    # Lógica JavaScript del chat
└── README.md                          # Este archivo
```

## Instalación

### Paso 1: Configurar el Backend Flask

1. **Asegúrate de que el servidor Flask está funcionando:**
   ```bash
   cd asistente-virtual-audios
   python app.py
   ```

2. **Iniciar el servidor API REST:**
   ```bash
   cd asistente-virtual-audios
   python api.py
   ```
   
   Por defecto, la API corre en `http://localhost:5002`

3. **Configurar variables de entorno en `config.env`:**
   ```
   # Puerto para la API REST (opcional, por defecto 5002)
   API_PORT=5002
   
   # Token de autenticación para la API (recomendado)
   API_TOKEN=tu_token_seguro_aqui
   
   # Tu OPENAI_API_KEY (ya configurada)
   OPENAI_API_KEY=tu_key_aqui
   
   # Otras configuraciones...
   ```

### Paso 2: Instalar el Plugin en WordPress

1. **Copiar el plugin:**
   - El plugin ya está en `wordpress/wp-content/plugins/asistente-virtual/`
   - Si necesitas moverlo, copia toda la carpeta `asistente-virtual` a la carpeta de plugins de WordPress

2. **Activar el plugin:**
   - Ve a WordPress Admin → Plugins
   - Busca "Asistente Virtual IBUX"
   - Haz clic en "Activar"

3. **Configurar el plugin:**
   - Ve a WordPress Admin → Ajustes → Asistente Virtual
   - Configura la **URL del servidor Flask** (ej: `http://localhost:5002` o `http://tu-servidor.com:5002`)
   - (Opcional) Configura el **Token de API** si lo configuraste en Flask
   - (Opcional) Habilita **Audio** si quieres conversión de texto a voz
   - Guarda los cambios

### Paso 3: Usar el Plugin en tu Sitio

#### Opción 1: Usar el Shortcode

Agrega el shortcode en cualquier página o entrada:

```
[asistente_virtual]
```

También puedes personalizar el título y subtítulo:

```
[asistente_virtual title="Mi Asistente" subtitle="Descripción personalizada"]
```

#### Opción 2: Usar en un Widget

1. Ve a WordPress Admin → Apariencia → Widgets
2. Agrega un widget de "Texto" o "HTML"
3. Inserta el shortcode: `[asistente_virtual]`

#### Opción 3: Usar en un Template PHP

```php
<?php echo do_shortcode('[asistente_virtual]'); ?>
```

## Configuración Avanzada

### Variables de Entorno del Backend

En el archivo `config.env` del backend Flask:

```env
# Puerto para la API REST
API_PORT=5002

# Token de autenticación (debe coincidir con el configurado en WordPress)
API_TOKEN=mi_token_secreto_123

# Puerto para la aplicación Flask original (opcional)
PORT=5001

# API Key de OpenAI
OPENAI_API_KEY=tu_key_aqui

# API Key de Eleven Labs (para TTS, opcional)
ELEVENLABS_API_KEY=tu_key_aqui
ELEVENLABS_VOICE_ID=21m00Tcm4TlvDq8ikWAM

# Modo debug
DEBUG_MODE=True
```

### Seguridad

- **En producción**, siempre usa HTTPS
- Configura un token de API seguro y úsalo tanto en Flask como en WordPress
- Considera usar un firewall para limitar el acceso a la API solo desde tu servidor WordPress

### CORS (Cross-Origin Resource Sharing)

El archivo `api.py` ya tiene CORS habilitado para todas las rutas `/api/*`. Si necesitas restringir el acceso a dominios específicos, modifica la configuración de CORS en `api.py`:

```python
CORS(api_app, resources={r"/api/*": {"origins": ["https://tu-dominio.com"]}})
```

## Solución de Problemas

### El chat no aparece

1. Verifica que el plugin esté activado
2. Asegúrate de que el shortcode esté correctamente escrito: `[asistente_virtual]`
3. Revisa la consola del navegador (F12) para ver errores JavaScript

### Error de conexión con el servidor Flask

1. Verifica que el servidor Flask esté corriendo:
   ```bash
   python api.py
   ```

2. Verifica que la URL configurada en WordPress sea correcta
3. Prueba acceder directamente a `http://tu-servidor:5002/api/health` en el navegador
4. Verifica que no haya un firewall bloqueando el puerto

### Error de autenticación

1. Verifica que el token de API sea el mismo en Flask (`config.env`) y en WordPress (configuración del plugin)
2. Si no configuraste token, asegúrate de dejar el campo vacío en ambos lugares

### El audio no funciona

1. Verifica que tengas configurada la API key de Eleven Labs en `config.env`
2. Verifica que el audio esté habilitado en la configuración del plugin
3. El TTS solo funciona si Eleven Labs está configurado correctamente

## Desarrollo

### Estructura de Endpoints de la API

- `GET /api/health` - Verificar que la API está funcionando
- `POST /api/chat` - Enviar pregunta al asistente (requiere token)
- `POST /api/tts` - Generar audio a partir de texto (requiere token)

### Formato de Petición a /api/chat

```json
{
  "question": "¿Qué es IBUX?",
  "history": [
    {"role": "user", "content": "Hola"},
    {"role": "assistant", "content": "¡Hola! ¿En qué puedo ayudarte?"}
  ],
  "session_id": "unique_session_id"
}
```

### Formato de Respuesta

```json
{
  "answer": "Respuesta del asistente en formato Markdown"
}
```

## Soporte

Para problemas o preguntas, contacta al equipo de desarrollo de IBUX.

## Licencia

GPL v2 or later

