<?php
/**
 * Template para entradas individuales
 */
get_header();
?>

<main class="site-main">
    <div class="site-container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" class="content-area">
                <h1 class="entry-title"><?php the_title(); ?></h1>
                
                <div class="post-meta">
                    Publicado el <?php echo get_the_date(); ?> por <?php the_author(); ?>
                </div>
                
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>

