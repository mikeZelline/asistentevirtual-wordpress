# Instrucciones para Crear Contenido de Ejemplo

## Opción 1: Desde WordPress Admin (Recomendado)

### 1. Activar el Tema

1. Ve a **WordPress Admin → Apariencia → Temas**
2. Busca **"Asistente IBUX"**
3. Haz clic en **"Activar"**

### 2. Crear Páginas

Ve a **Páginas → Añadir nueva** y crea estas páginas:

#### Página: Inicio
- **Título:** Inicio
- **Contenido:** Usa el shortcode `[asistente_virtual]`
- **Slug:** inicio

#### Página: Sobre Nosotros
- **Título:** Sobre Nosotros
- **Contenido:** Información sobre el asistente virtual

#### Página: Servicios
- **Título:** Servicios
- **Contenido:** Descripción de servicios

#### Página: Contacto
- **Título:** Contacto
- **Contenido:** Información de contacto

### 3. Crear Entradas de Blog

Ve a **Entradas → Añadir nueva** y crea algunas entradas de ejemplo sobre ventas, estrategias comerciales, etc.

### 4. Crear Menú

1. Ve a **Apariencia → Menús**
2. Crea un nuevo menú llamado "Menú Principal"
3. Agrega las páginas creadas
4. Asigna el menú a la ubicación "Menú Principal"

### 5. Configurar Página de Inicio

1. Ve a **Ajustes → Lectura**
2. Selecciona "Una página estática"
3. Elige la página "Inicio" como página de inicio

## Opción 2: Ejecutar Script PHP

Si tienes acceso a ejecutar PHP, puedes ejecutar el archivo:
`wp-content/themes/asistente-ibux/setup-content.php`

Este script creará automáticamente:
- 4 páginas (Inicio, Sobre Nosotros, Servicios, Contacto)
- 3 entradas de blog de ejemplo
- Menú de navegación
- Configuración de página de inicio

