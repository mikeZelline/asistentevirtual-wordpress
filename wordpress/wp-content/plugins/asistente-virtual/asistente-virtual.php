<?php
/**
 * Plugin Name: Asistente Virtual IBUX
 * Plugin URI: https://ibux.com
 * Description: Plugin para integrar el asistente virtual de entrenamiento comercial IBUX en WordPress. Se comunica con el backend Flask mediante API REST.
 * Version: 1.0.0
 * Author: IBUX
 * Author URI: https://ibux.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: asistente-virtual
 */

// Prevenir acceso directo
if (!defined('ABSPATH')) {
    exit;
}

// Definir constantes del plugin
define('ASISTENTE_VIRTUAL_VERSION', '1.0.0');
define('ASISTENTE_VIRTUAL_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('ASISTENTE_VIRTUAL_PLUGIN_URL', plugin_dir_url(__FILE__));
define('ASISTENTE_VIRTUAL_PLUGIN_BASENAME', plugin_basename(__FILE__));

// Cargar las clases principales
require_once ASISTENTE_VIRTUAL_PLUGIN_DIR . 'includes/class-asistente-virtual.php';
require_once ASISTENTE_VIRTUAL_PLUGIN_DIR . 'includes/class-admin-settings.php';
require_once ASISTENTE_VIRTUAL_PLUGIN_DIR . 'includes/class-api-handler.php';

// Inicializar el plugin
function asistente_virtual_init() {
    $plugin = new Asistente_Virtual();
    $plugin->run();
}
add_action('plugins_loaded', 'asistente_virtual_init');

// Hook de activación
register_activation_hook(__FILE__, 'asistente_virtual_activate');
function asistente_virtual_activate() {
    // Configuraciones por defecto
    if (get_option('asistente_virtual_flask_url') === false) {
        update_option('asistente_virtual_flask_url', 'http://localhost:5001');
    }
    if (get_option('asistente_virtual_api_token') === false) {
        update_option('asistente_virtual_api_token', '');
    }
    if (get_option('asistente_virtual_enable_audio') === false) {
        update_option('asistente_virtual_enable_audio', '0');
    }
}

// Hook de desactivación
register_deactivation_hook(__FILE__, 'asistente_virtual_deactivate');
function asistente_virtual_deactivate() {
    // Limpiar transients si es necesario
}

