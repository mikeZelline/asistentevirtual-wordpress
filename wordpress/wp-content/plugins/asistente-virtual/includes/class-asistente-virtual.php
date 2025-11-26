<?php
/**
 * Clase principal del plugin
 */
class Asistente_Virtual {
    
    private $admin_settings;
    private $api_handler;
    
    public function __construct() {
        $this->admin_settings = new Asistente_Virtual_Admin_Settings();
        $this->api_handler = new Asistente_Virtual_API_Handler();
    }
    
    public function run() {
        // Registrar shortcode
        add_shortcode('asistente_virtual', array($this, 'render_chat_shortcode'));
        
        // Encolar scripts y estilos
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        
        // Registrar AJAX handlers
        add_action('wp_ajax_asistente_virtual_chat', array($this->api_handler, 'handle_chat_request'));
        add_action('wp_ajax_nopriv_asistente_virtual_chat', array($this->api_handler, 'handle_chat_request'));
        
        add_action('wp_ajax_asistente_virtual_tts', array($this->api_handler, 'handle_tts_request'));
        add_action('wp_ajax_nopriv_asistente_virtual_tts', array($this->api_handler, 'handle_tts_request'));
    }
    
    /**
     * Renderiza el chat mediante shortcode
     */
    public function render_chat_shortcode($atts) {
        // Atributos del shortcode
        $atts = shortcode_atts(array(
            'title' => '💬 Mentor comercial IBUX',
            'subtitle' => 'Mentor comercial experto en ventas B2B con enfoque 3C y alto rendimiento.',
        ), $atts);
        
        // Obtener configuración
        $flask_url = get_option('asistente_virtual_flask_url', 'http://localhost:5001');
        $api_token = get_option('asistente_virtual_api_token', '');
        $enable_audio = get_option('asistente_virtual_enable_audio', '0');
        
        // Nonce para seguridad
        $nonce = wp_create_nonce('asistente_virtual_nonce');
        
        // Incluir el template del chat
        ob_start();
        include ASISTENTE_VIRTUAL_PLUGIN_DIR . 'templates/chat-template.php';
        return ob_get_clean();
    }
    
    /**
     * Encolar scripts y estilos
     */
    public function enqueue_scripts() {
        // Solo cargar en páginas que usen el shortcode
        global $post;
        if (is_a($post, 'WP_Post') && has_shortcode($post->post_content, 'asistente_virtual')) {
            
            // CSS
            wp_enqueue_style(
                'asistente-virtual-style',
                ASISTENTE_VIRTUAL_PLUGIN_URL . 'assets/css/style.css',
                array(),
                ASISTENTE_VIRTUAL_VERSION
            );
            
            // JavaScript
            wp_enqueue_script(
                'asistente-virtual-script',
                ASISTENTE_VIRTUAL_PLUGIN_URL . 'assets/js/chat.js',
                array('jquery'),
                ASISTENTE_VIRTUAL_VERSION,
                true
            );
            
            // Pasar datos al JavaScript
            wp_localize_script('asistente-virtual-script', 'asistenteVirtual', array(
                'ajaxUrl' => admin_url('admin-ajax.php'),
                'nonce' => wp_create_nonce('asistente_virtual_nonce'),
                'flaskUrl' => get_option('asistente_virtual_flask_url', 'http://localhost:5001'),
                'apiToken' => get_option('asistente_virtual_api_token', ''),
                'enableAudio' => get_option('asistente_virtual_enable_audio', '0') == '1',
            ));
        }
    }
}

