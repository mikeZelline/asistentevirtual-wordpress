<?php
/**
 * Template principal
 */
get_header();
?>

<main class="site-main">
    <div class="site-container">
        <?php if (have_posts()) : ?>
            <ul class="posts-list">
                <?php while (have_posts()) : the_post(); ?>
                    <li class="post-item">
                        <article id="post-<?php the_ID(); ?>">
                            <h2>
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <div class="post-meta">
                                Publicado el <?php echo get_the_date(); ?>
                            </div>
                            
                            <div class="post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="btn">Leer más</a>
                        </article>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else : ?>
            <div class="content-area">
                <h1>No hay entradas aún</h1>
                <p>Las entradas aparecerán aquí cuando las publiques.</p>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>

