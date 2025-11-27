<?php
/**
 * Functions and definitions for Asistente IBUX Theme
 */

// Prevenir acceso directo
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Configurar el tema
 */
function asistente_ibux_setup() {
    // Soporte para título del sitio
    add_theme_support('title-tag');
    
    // Soporte para imágenes destacadas
    add_theme_support('post-thumbnails');
    
    // Soporte para HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // Registrar menú de navegación
    register_nav_menus(array(
        'primary' => 'Menú Principal',
    ));
}
add_action('after_setup_theme', 'asistente_ibux_setup');

/**
 * Crear página del chat automáticamente
 */
function asistente_ibux_create_chat_page() {
    $chat_page = get_page_by_path('chat');
    
    if (!$chat_page) {
        $chat_page_data = array(
            'post_title'    => 'Chat con el Asistente',
            'post_content'  => '[asistente_virtual]',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_name'     => 'chat'
        );
        
        $page_id = wp_insert_post($chat_page_data);
        
        // Asignar el template personalizado si se creó correctamente
        if ($page_id && !is_wp_error($page_id)) {
            update_post_meta($page_id, '_wp_page_template', 'template-chat.php');
        }
    } else {
        // Si la página ya existe, asegurarse de que use el template correcto
        $current_template = get_post_meta($chat_page->ID, '_wp_page_template', true);
        if ($current_template !== 'template-chat.php') {
            update_post_meta($chat_page->ID, '_wp_page_template', 'template-chat.php');
        }
        // Asegurar que tenga el contenido correcto
        if (strpos($chat_page->post_content, '[asistente_virtual]') === false) {
            wp_update_post(array(
                'ID' => $chat_page->ID,
                'post_content' => '[asistente_virtual]'
            ));
        }
    }
}
// Ejecutar al iniciar WordPress
add_action('init', 'asistente_ibux_create_chat_page', 1);

/**
 * Usar template personalizado para la página del chat
 */
function asistente_ibux_template_chat($template) {
    if (is_page('chat')) {
        $template_chat = locate_template('template-chat.php');
        if ($template_chat) {
            return $template_chat;
        }
    }
    return $template;
}
add_filter('page_template', 'asistente_ibux_template_chat');

/**
 * Encolar estilos y scripts
 */
function asistente_ibux_scripts() {
    // Estilos del tema
    wp_enqueue_style('asistente-ibux-style', get_stylesheet_uri(), array(), '1.0.0');
}
add_action('wp_enqueue_scripts', 'asistente_ibux_scripts');

/**
 * Registrar áreas de widgets
 */
function asistente_ibux_widgets_init() {
    register_sidebar(array(
        'name'          => 'Sidebar Principal',
        'id'            => 'sidebar-1',
        'description'   => 'Widgets para la barra lateral',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'asistente_ibux_widgets_init');

