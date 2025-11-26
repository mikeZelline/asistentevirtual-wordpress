<?php
/**
 * Template para páginas
 */
get_header();
?>

<main class="site-main">
    <div class="site-container">
        <?php while (have_posts()) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" class="content-area">
                <h1 class="page-title"><?php the_title(); ?></h1>
                
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>

