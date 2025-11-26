<?php
/**
 * Template para la página de inicio
 */
get_header();
?>

<main class="site-main">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="site-container">
            <h1>Bienvenido al Asistente Virtual IBUX</h1>
            <p>Tu mentor comercial experto en ventas B2B con enfoque 3C y alto rendimiento. Obtén respuestas instantáneas a todas tus preguntas sobre estrategias comerciales.</p>
            <a href="#chat" class="btn">Comenzar Ahora</a>
        </div>
    </section>
    
    <div class="site-container">
        <!-- Sección de Características -->
        <section class="features-section">
            <h2 class="section-title">¿Por qué elegir nuestro asistente?</h2>
            <div class="cards-grid">
                <div class="card">
                    <div class="card-icon">💬</div>
                    <h3>Asistente Inteligente</h3>
                    <p>Obtén respuestas instantáneas a tus preguntas sobre ventas, estrategias comerciales y técnicas de alto rendimiento.</p>
                </div>
                
                <div class="card">
                    <div class="card-icon">📚</div>
                    <h3>Conocimiento Especializado</h3>
                    <p>Accede a información basada en metodologías probadas y mejores prácticas del mundo comercial B2B.</p>
                </div>
                
                <div class="card">
                    <div class="card-icon">🎯</div>
                    <h3>Enfoque 3C</h3>
                    <p>Aprende sobre Cliente, Competencia y Compañía para desarrollar estrategias de ventas efectivas.</p>
                </div>
            </div>
        </section>
        
        <!-- Sección del Chat -->
        <section id="chat" class="content-area chat-section">
            <h2 class="section-title">Chatea con tu Mentor Comercial</h2>
            <p class="section-description">Haz cualquier pregunta sobre ventas, estrategias comerciales o técnicas de negociación. El asistente está aquí para ayudarte 24/7.</p>
            
            <?php
            // Mostrar el shortcode del asistente virtual
            echo do_shortcode('[asistente_virtual]');
            ?>
        </section>
        
        <!-- Sección de Información Adicional -->
        <section class="content-area info-section">
            <h2 class="section-title">Sobre el Asistente Virtual IBUX</h2>
            <p>El Asistente Virtual IBUX es una herramienta diseñada para profesionales de ventas que buscan mejorar sus habilidades y resultados. Utiliza inteligencia artificial avanzada para proporcionar respuestas precisas y contextualizadas sobre:</p>
            
            <div class="features-list">
                <div class="feature-item">
                    <span class="feature-icon">✓</span>
                    <span>Técnicas de ventas B2B</span>
                </div>
                <div class="feature-item">
                    <span class="feature-icon">✓</span>
                    <span>Estrategias de negociación</span>
                </div>
                <div class="feature-item">
                    <span class="feature-icon">✓</span>
                    <span>Gestión de clientes</span>
                </div>
                <div class="feature-item">
                    <span class="feature-icon">✓</span>
                    <span>Análisis de competencia</span>
                </div>
                <div class="feature-item">
                    <span class="feature-icon">✓</span>
                    <span>Desarrollo de propuestas comerciales</span>
                </div>
                <div class="feature-item">
                    <span class="feature-icon">✓</span>
                    <span>Y mucho más...</span>
                </div>
            </div>
            
            <p class="highlight-text">Simplemente escribe tu pregunta en el chat y obtén respuestas inmediatas basadas en metodologías probadas y mejores prácticas del sector.</p>
        </section>
        
        <!-- Sección de CTA -->
        <section class="cta-section">
            <h2>¿Listo para mejorar tus ventas?</h2>
            <p>Comienza a usar el asistente virtual ahora mismo</p>
            <a href="#chat" class="btn btn-large">Iniciar Conversación</a>
        </section>
    </div>
</main>

<?php get_footer(); ?>

