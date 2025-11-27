<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="header-content">
        <h1 class="site-title">
            <a href="<?php echo esc_url(home_url('/')); ?>">
                <?php bloginfo('name'); ?>
            </a>
        </h1>
        
        <nav class="main-navigation">
            <?php
            if (has_nav_menu('primary')) {
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_class'     => 'nav-menu',
                    'container'      => false,
                    'fallback_cb'    => false,
                ));
            } else {
                // Menú por defecto si no está configurado
                echo '<ul class="nav-menu">';
                echo '<li><a href="' . esc_url(home_url('/')) . '">Inicio</a></li>';
                echo '<li><a href="' . esc_url(home_url('/chat')) . '">Chat</a></li>';
                echo '</ul>';
            }
            ?>
        </nav>
    </div>
</header>

