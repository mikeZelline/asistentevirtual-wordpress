<?php
/**
 * Template Name: Página de Chat
 * Template para mostrar solo el chat del asistente virtual
 */
get_header();
?>

<main class="site-main">
    <div class="site-container">
        <article class="content-area chat-page" style="padding: 40px 20px;">
            <h1 class="page-title" style="text-align: center; margin-bottom: 40px; font-size: 32px;">Chat con tu Mentor Comercial</h1>
            
            <?php
            // Mostrar el shortcode del asistente virtual
            echo do_shortcode('[asistente_virtual]');
            ?>
        </article>
    </div>
</main>

<?php get_footer(); ?>

