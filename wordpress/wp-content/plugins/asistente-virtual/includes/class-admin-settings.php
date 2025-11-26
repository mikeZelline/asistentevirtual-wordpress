<?php
/**
 * Maneja la página de configuración del plugin en el admin
 */
class Asistente_Virtual_Admin_Settings {
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
    }
    
    /**
     * Agrega el menú en el admin
     */
    public function add_admin_menu() {
        add_options_page(
            'Asistente Virtual IBUX',
            'Asistente Virtual',
            'manage_options',
            'asistente-virtual',
            array($this, 'render_settings_page')
        );
    }
    
    /**
     * Registra las opciones del plugin
     */
    public function register_settings() {
        register_setting('asistente_virtual_settings', 'asistente_virtual_flask_url');
        register_setting('asistente_virtual_settings', 'asistente_virtual_api_token');
        register_setting('asistente_virtual_settings', 'asistente_virtual_enable_audio');
    }
    
    /**
     * Renderiza la página de configuración
     */
    public function render_settings_page() {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        // Guardar configuración
        if (isset($_POST['submit']) && check_admin_referer('asistente_virtual_settings')) {
            update_option('asistente_virtual_flask_url', sanitize_text_field($_POST['flask_url']));
            update_option('asistente_virtual_api_token', sanitize_text_field($_POST['api_token']));
            update_option('asistente_virtual_enable_audio', isset($_POST['enable_audio']) ? '1' : '0');
            
            echo '<div class="notice notice-success"><p>Configuración guardada correctamente.</p></div>';
        }
        
        // Obtener valores actuales
        $flask_url = get_option('asistente_virtual_flask_url', 'http://localhost:5001');
        $api_token = get_option('asistente_virtual_api_token', '');
        $enable_audio = get_option('asistente_virtual_enable_audio', '0') == '1';
        
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            
            <form method="post" action="">
                <?php wp_nonce_field('asistente_virtual_settings'); ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="flask_url">URL del servidor Flask</label>
                        </th>
                        <td>
                            <input type="url" 
                                   id="flask_url" 
                                   name="flask_url" 
                                   value="<?php echo esc_attr($flask_url); ?>" 
                                   class="regular-text"
                                   placeholder="http://localhost:5001">
                            <p class="description">
                                URL completa donde está corriendo el servidor Flask (por defecto: http://localhost:5001)
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="api_token">Token de API</label>
                        </th>
                        <td>
                            <input type="text" 
                                   id="api_token" 
                                   name="api_token" 
                                   value="<?php echo esc_attr($api_token); ?>" 
                                   class="regular-text"
                                   placeholder="Tu token de autenticación">
                            <p class="description">
                                Token de autenticación para comunicarse con la API de Flask (opcional, no es necesario - la API funciona sin autenticación)
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="enable_audio">Habilitar audio</label>
                        </th>
                        <td>
                            <input type="checkbox" 
                                   id="enable_audio" 
                                   name="enable_audio" 
                                   value="1" 
                                   <?php checked($enable_audio); ?>>
                            <label for="enable_audio">Habilitar conversión de texto a voz (TTS)</label>
                            <p class="description">
                                Si está habilitado, las respuestas del asistente se convertirán automáticamente a voz usando Eleven Labs
                            </p>
                        </td>
                    </tr>
                </table>
                
                <?php submit_button('Guardar configuración'); ?>
            </form>
            
            <hr>
            
            <h2>Uso del plugin</h2>
            <p>Para mostrar el asistente virtual en cualquier página o entrada, usa el siguiente shortcode:</p>
            <code style="display: block; padding: 10px; background: #f5f5f5; margin: 10px 0;">
                [asistente_virtual]
            </code>
            
            <p>También puedes personalizar el título y subtítulo:</p>
            <code style="display: block; padding: 10px; background: #f5f5f5; margin: 10px 0;">
                [asistente_virtual title="Mi Asistente" subtitle="Descripción personalizada"]
            </code>
            
            <h3>Requisitos</h3>
            <ul>
                <li>El servidor Flask debe estar corriendo y accesible desde la URL configurada</li>
                <li>Para producción, se recomienda usar HTTPS</li>
                <li>El servidor Flask debe tener habilitado CORS para permitir peticiones desde WordPress</li>
            </ul>
        </div>
        <?php
    }
}

