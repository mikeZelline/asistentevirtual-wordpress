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

