<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package peacock_beach
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        
        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
        <div id="page" class="site">
            <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'peacock_beach'); ?></a>

            <header id="masthead" class="site-header container">
                <div class="site-branding col-xs-12 col-sm-12 col-md-3 noPaddingLeft">
                    <?php
                    //the_custom_logo();
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        if (is_front_page() && is_home()) :
                            ?>
                            <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></h1>
                        <?php else : ?>
                            <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home"><?php bloginfo('name'); ?></a></p>
                        <?php
                        endif;
                    }
                    ?>
                </div><!-- .site-branding -->
                <div id="navigationList" class="col-xs-12 col-sm-12 col-md-9 noPaddingLeft noPaddingRight">
                    <nav id="site-navigation" class="navbar navbar-default ">
                            <!-- <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php //esc_html_e( 'Primary Menu', 'peacock_beach' );  ?></button> -->
                        <div class="container-fluid noPaddingLeft noPaddingRight">
                            <!-- Brand and toggle get grouped for better mobile display -->
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-controls="primary-menu" aria-expanded="false">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand" href="#">Menu</a>
                            </div>
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'menu-1',
                                'menu_id' => 'primary-menu',
                                'menu_class' => 'navbar-collapse collapse noPaddingLeft noPaddingRight',
                            ));
                            ?>
                        </div>
                    </nav><!-- #site-navigation -->
                </div><!-- #navigationList -->


            </header><!-- #masthead -->

            <div id="content" class="site-content">
