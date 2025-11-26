<?php
/**
 * Script para crear contenido de ejemplo
 * Ejecutar desde WordPress Admin o vía WP-CLI
 */

// Prevenir acceso directo
if (!defined('ABSPATH')) {
    require_once('../../../wp-load.php');
}

/**
 * Crear páginas de ejemplo
 */
function crear_paginas_ejemplo() {
    $paginas = array(
        array(
            'titulo' => 'Inicio',
            'contenido' => '<div class="hero-section">
                <h1>Bienvenido al Asistente Virtual IBUX</h1>
                <p>Tu mentor comercial experto en ventas B2B</p>
            </div>
            
            <div class="cards-grid">
                <div class="card">
                    <h3>💬 Asistente Inteligente</h3>
                    <p>Obtén respuestas instantáneas a tus preguntas sobre ventas y estrategias comerciales.</p>
                </div>
                <div class="card">
                    <h3>📚 Conocimiento Especializado</h3>
                    <p>Accede a información basada en metodologías probadas del mundo comercial B2B.</p>
                </div>
                <div class="card">
                    <h3>🎯 Enfoque 3C</h3>
                    <p>Aprende sobre Cliente, Competencia y Compañía para desarrollar estrategias efectivas.</p>
                </div>
            </div>
            
            <h2>Chatea con tu Mentor Comercial</h2>
            <p>Haz cualquier pregunta sobre ventas, estrategias comerciales o técnicas de negociación.</p>
            
            [asistente_virtual]',
            'slug' => 'inicio'
        ),
        array(
            'titulo' => 'Sobre Nosotros',
            'contenido' => '<h2>Acerca del Asistente Virtual IBUX</h2>
            
            <p>El Asistente Virtual IBUX es una herramienta diseñada para profesionales de ventas que buscan mejorar sus habilidades y resultados. Utiliza inteligencia artificial avanzada para proporcionar respuestas precisas y contextualizadas.</p>
            
            <h3>Nuestra Misión</h3>
            <p>Ayudar a profesionales de ventas a alcanzar su máximo potencial mediante el acceso a conocimiento especializado y estrategias probadas.</p>
            
            <h3>Características Principales</h3>
            <ul>
                <li>Respuestas instantáneas basadas en metodologías probadas</li>
                <li>Conocimiento especializado en ventas B2B</li>
                <li>Enfoque en las 3C: Cliente, Competencia y Compañía</li>
                <li>Interfaz intuitiva y fácil de usar</li>
            </ul>',
            'slug' => 'sobre-nosotros'
        ),
        array(
            'titulo' => 'Servicios',
            'contenido' => '<h2>Nuestros Servicios</h2>
            
            <div class="cards-grid">
                <div class="card">
                    <h3>Consultoría en Ventas</h3>
                    <p>Asesoría personalizada para mejorar tus técnicas de ventas y aumentar tus resultados.</p>
                </div>
                <div class="card">
                    <h3>Entrenamiento Comercial</h3>
                    <p>Programas de capacitación diseñados para desarrollar habilidades comerciales de alto nivel.</p>
                </div>
                <div class="card">
                    <h3>Análisis Estratégico</h3>
                    <p>Evaluación de tu situación comercial y desarrollo de estrategias personalizadas.</p>
                </div>
            </div>
            
            <h3>¿Necesitas ayuda?</h3>
            <p>Utiliza nuestro asistente virtual para obtener respuestas inmediatas a tus preguntas sobre ventas y estrategias comerciales.</p>
            
            [asistente_virtual]',
            'slug' => 'servicios'
        ),
        array(
            'titulo' => 'Contacto',
            'contenido' => '<h2>Contáctanos</h2>
            
            <p>¿Tienes alguna pregunta o necesitas más información? Estamos aquí para ayudarte.</p>
            
            <h3>Información de Contacto</h3>
            <p><strong>Email:</strong> contacto@ibux.com</p>
            <p><strong>Teléfono:</strong> +57 1 234 5678</p>
            
            <h3>Chatea con nuestro Asistente</h3>
            <p>También puedes hacer tus preguntas directamente a nuestro asistente virtual:</p>
            
            [asistente_virtual]',
            'slug' => 'contacto'
        )
    );
    
    foreach ($paginas as $pagina) {
        $pagina_existente = get_page_by_path($pagina['slug']);
        
        if (!$pagina_existente) {
            $nueva_pagina = array(
                'post_title'    => $pagina['titulo'],
                'post_content'  => $pagina['contenido'],
                'post_status'   => 'publish',
                'post_type'     => 'page',
                'post_name'     => $pagina['slug']
            );
            
            wp_insert_post($nueva_pagina);
        }
    }
}

/**
 * Crear entradas de blog de ejemplo
 */
function crear_entradas_ejemplo() {
    $entradas = array(
        array(
            'titulo' => '5 Técnicas de Ventas B2B que Debes Conocer',
            'contenido' => '<p>Las ventas B2B requieren un enfoque diferente al B2C. En este artículo, exploramos las técnicas más efectivas para cerrar negocios con empresas.</p>
            
            <h2>1. Investigación Profunda del Cliente</h2>
            <p>Antes de cualquier reunión, investiga a fondo la empresa, sus necesidades, desafíos y objetivos. Esto te permitirá personalizar tu propuesta.</p>
            
            <h2>2. Construcción de Relaciones</h2>
            <p>En B2B, las relaciones son fundamentales. Invierte tiempo en conocer a tus contactos y construir confianza.</p>
            
            <h2>3. Demostración de Valor</h2>
            <p>No vendas características, vende beneficios y resultados. Muestra cómo tu solución resuelve problemas específicos.</p>
            
            <h2>4. Manejo de Objeciones</h2>
            <p>Las objeciones son oportunidades. Prepárate para responder preguntas difíciles con datos y casos de éxito.</p>
            
            <h2>5. Seguimiento Persistente</h2>
            <p>El cierre de ventas B2B puede tomar tiempo. Mantén un seguimiento constante pero respetuoso.</p>
            
            <p>¿Quieres saber más sobre alguna de estas técnicas? Pregúntale a nuestro asistente virtual.</p>',
            'fecha' => date('Y-m-d H:i:s', strtotime('-5 days'))
        ),
        array(
            'titulo' => 'Cómo Aplicar el Enfoque 3C en tus Ventas',
            'contenido' => '<p>El enfoque 3C (Cliente, Competencia, Compañía) es fundamental para desarrollar estrategias de ventas efectivas.</p>
            
            <h2>Cliente</h2>
            <p>Comprende profundamente las necesidades, desafíos y objetivos de tu cliente. Esto te permite ofrecer soluciones realmente valiosas.</p>
            
            <h2>Competencia</h2>
            <p>Conoce a tus competidores: sus fortalezas, debilidades y propuestas de valor. Esto te ayuda a diferenciarte.</p>
            
            <h2>Compañía</h2>
            <p>Identifica las fortalezas únicas de tu empresa y cómo pueden resolver los problemas específicos del cliente.</p>
            
            <p>Al integrar estos tres elementos, puedes crear propuestas comerciales más efectivas y aumentar tus tasas de cierre.</p>',
            'fecha' => date('Y-m-d H:i:s', strtotime('-3 days'))
        ),
        array(
            'titulo' => 'Estrategias para Aumentar tu Tasa de Cierre',
            'contenido' => '<p>Mejorar tu tasa de cierre es uno de los objetivos más importantes en ventas. Aquí te compartimos estrategias probadas.</p>
            
            <h2>1. Calificación de Prospectos</h2>
            <p>No todos los prospectos son iguales. Invierte tiempo en aquellos con mayor probabilidad de compra.</p>
            
            <h2>2. Personalización de Propuestas</h2>
            <p>Cada cliente es único. Personaliza tus propuestas para abordar necesidades específicas.</p>
            
            <h2>3. Creación de Urgencia</h2>
            <p>Ayuda a los clientes a entender por qué deben actuar ahora, no más tarde.</p>
            
            <h2>4. Pruebas Sociales</h2>
            <p>Comparte casos de éxito y testimonios de clientes similares para generar confianza.</p>
            
            <h2>5. Cierre Asertivo</h2>
            <p>No tengas miedo de pedir el cierre. Si has hecho bien tu trabajo, es el momento adecuado.</p>',
            'fecha' => date('Y-m-d H:i:s', strtotime('-1 day'))
        )
    );
    
    foreach ($entradas as $entrada) {
        $entrada_existente = get_page_by_title($entrada['titulo'], OBJECT, 'post');
        
        if (!$entrada_existente) {
            $nueva_entrada = array(
                'post_title'    => $entrada['titulo'],
                'post_content'  => $entrada['contenido'],
                'post_status'   => 'publish',
                'post_type'     => 'post',
                'post_date'      => $entrada['fecha']
            );
            
            wp_insert_post($nueva_entrada);
        }
    }
}

/**
 * Crear menú de navegación
 */
function crear_menu_navegacion() {
    // Crear el menú
    $menu_name = 'Menú Principal';
    $menu_exists = wp_get_nav_menu_object($menu_name);
    
    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);
        
        // Agregar páginas al menú
        $paginas = array('inicio', 'sobre-nosotros', 'servicios', 'contacto');
        
        foreach ($paginas as $index => $slug) {
            $pagina = get_page_by_path($slug);
            if ($pagina) {
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title'  => $pagina->post_title,
                    'menu-item-object' => 'page',
                    'menu-item-object-id' => $pagina->ID,
                    'menu-item-type'   => 'post_type',
                    'menu-item-status' => 'publish',
                    'menu-item-position' => $index + 1
                ));
            }
        }
        
        // Asignar el menú a la ubicación
        $locations = get_theme_mod('nav_menu_locations');
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}

/**
 * Configurar página de inicio
 */
function configurar_pagina_inicio() {
    $pagina_inicio = get_page_by_path('inicio');
    if ($pagina_inicio) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $pagina_inicio->ID);
    }
}

// Ejecutar funciones si se llama directamente
if (defined('ABSPATH')) {
    crear_paginas_ejemplo();
    crear_entradas_ejemplo();
    crear_menu_navegacion();
    configurar_pagina_inicio();
    echo "Contenido creado exitosamente!";
}

