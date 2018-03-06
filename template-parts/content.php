<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package peacock_beach
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header">
        <?php
        if ( has_post_thumbnail() ) { ?>
        <figure class="featured-image">
            <?php peacock_beach_post_thumbnail(); ?>
        </figure>
        <?php } 
        

        if (is_singular()) :
            the_title('<h1 class="entry-title">', '</h1>');
        else :
            the_title('<h2 class="entry-title index-excerpt"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
        endif;

        if ('post' === get_post_type()) :
            ?>
            <div class="index-entry-meta">
                <?php
//				peacock_beach_posted_on();
                peacock_beach_index_posted_by();
                ?>
            </div><!-- .entry-meta -->
            <?php endif;
        ?>
    </header><!-- .entry-header -->	

    <div class="entry-content index-excerpt">
        <?php
        the_excerpt();
        // wp_link_pages( array(
        // 	'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'popperscores' ),
        // 	'after'  => '</div>',
        // ) );
        ?>
    </div><!-- .entry-content -->

    <div class="continue-reading">
        <a href="<?php echo esc_url(get_permalink()); ?>" rel="bookmark">
            <?php
            printf(
                    wp_kses(
                            /* translators: %s: Name of current post. Only visible to screen readers */
                            __('Continue reading<span class="screen-reader-text"> "%s"</span>', 'peacock_beach'), array(
                'span' => array(
                    'class' => array(),
                ),
                            )
                    ), get_the_title()
            );
            ?>
        </a>
    </div>

</article><!-- #post-<?php the_ID(); ?> -->
