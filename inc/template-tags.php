<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package peacock_beach
 */
if (!function_exists('peacock_beach_posted_on')) :

    /**
     * Prints HTML with meta information for the current post-date/time.
     */
    function peacock_beach_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if (get_the_time('U') !== get_the_modified_time('U')) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf($time_string, esc_attr(get_the_date('c')), esc_html(get_the_date()), esc_attr(get_the_modified_date('c')), esc_html(get_the_modified_date())
        );

        $posted_on = sprintf(
                /* translators: %s: post date. */
                esc_html_x('Published %s', 'post date', 'peacock_beach'), '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
        );

        echo ' <span class="posted-on">' . $posted_on . ' </span> '; // WPCS: XSS OK.

        if (!post_password_required() && ( comments_open() || get_comments_number() )) {
            echo '<span class="comments-link">';
            comments_popup_link(
                    sprintf(
                            wp_kses(
                                    /* translators: %s: post title */
                                    __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'peacock_beach'), array(
                'span' => array(
                    'class' => array(),
                ),
                                    )
                            ), get_the_title()
                    )
            );
            echo '</span>';
        }
    }

endif;

if (!function_exists('peacock_beach_posted_by')) :

    /**
     * Prints HTML with meta information for the current author.
     */
    function peacock_beach_posted_by() {
        $byline = sprintf(
                /* translators: %s: post author. */
                esc_html_x('by %s', 'post author', 'peacock_beach'), '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );

        // Display the author avatar if the author has a Gravatar
        $author_id = get_the_author_meta('ID');
        if (peacock_beach_validate_gravatar($author_id)) {
            echo '<div class="meta-content has-avatar">';

            echo '<div class="author-avatar">' . get_avatar($author_id) . '</div>';
        } else {
            echo '<div class="meta-content">';
        }

        echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
        peacock_beach_posted_on();
    }

endif;

if (!function_exists('peacock_beach_index_posted_by')) :

    /**
     * Prints HTML with meta information for the current author.
     */
    function peacock_beach_index_posted_by() {
        $byline = sprintf(
                /* translators: %s: post author. */
                esc_html_x('by %s', 'post author', 'peacock_beach'), '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
        );
       
        echo '<div class="meta-content">';
       
        echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
        peacock_beach_posted_on();
    }

endif;

if (!function_exists('peacock_beach_entry_footer')) :

    /**
     * Prints HTML with meta information for the categories, tags and comments.
     */
    function peacock_beach_entry_footer() {
        // Hide category and tag text for pages.
        if ('post' === get_post_type()) {
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(esc_html__(', ', 'peacock_beach'));
            if ($categories_list) {
                /* translators: 1: list of categories. */
                printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'peacock_beach') . '</span>', $categories_list); // WPCS: XSS OK.
            }

            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', esc_html_x(', ', 'list item separator', 'peacock_beach'));
            if ($tags_list) {
                /* translators: 1: list of tags. */
                printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'peacock_beach') . '</span>', $tags_list); // WPCS: XSS OK.
            }
        }

        if (!is_single() && !post_password_required() && ( comments_open() || get_comments_number() )) {
            echo '<span class="comments-link">';
            comments_popup_link(
                    sprintf(
                            wp_kses(
                                    /* translators: %s: post title */
                                    __('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'peacock_beach'), array(
                'span' => array(
                    'class' => array(),
                ),
                                    )
                            ), get_the_title()
                    )
            );
            echo '</span>';
        }

        edit_post_link(
                sprintf(
                        wp_kses(
                                /* translators: %s: Name of current post. Only visible to screen readers */
                                __('Edit <span class="screen-reader-text">%s</span>', 'peacock_beach'), array(
            'span' => array(
                'class' => array(),
            ),
                                )
                        ), get_the_title()
                ), '<span class="edit-link">', '</span>'
        );
    }

endif;

if (!function_exists('peacock_beach_post_thumbnail')) :

    /**
     * Displays an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index views, or a div
     * element when on single views.
     */
    function peacock_beach_post_thumbnail() {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) :
            ?>

            <div class="post-thumbnail">
            <?php the_post_thumbnail(); ?>
            </div><!-- .post-thumbnail -->

        <?php else : ?>

            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
            <?php
            the_post_thumbnail('post-thumbnail', array(
                'alt' => the_title_attribute(array(
                    'echo' => false,
                )),
            ));
            ?>
            </a>

            <?php
            endif; // End is_singular().
        }

    endif;

    /**
     * Utility function to check if a gravatar exists for a given email or id
     * @param int|string|object $id_or_email A user ID,  email address, or comment object
     * @return bool if the gravatar exists or not
     */
    function peacock_beach_validate_gravatar($id_or_email) {
        //id or email code borrowed from wp-includes/pluggable.php
        $email = '';
        if (is_numeric($id_or_email)) {
            $id = (int) $id_or_email;
            $user = get_userdata($id);
            if ($user)
                $email = $user->user_email;
        } elseif (is_object($id_or_email)) {
            // No avatar for pingbacks or trackbacks
            $allowed_comment_types = apply_filters('get_avatar_comment_types', array('comment'));
            if (!empty($id_or_email->comment_type) && !in_array($id_or_email->comment_type, (array) $allowed_comment_types))
                return false;

            if (!empty($id_or_email->user_id)) {
                $id = (int) $id_or_email->user_id;
                $user = get_userdata($id);
                if ($user)
                    $email = $user->user_email;
            } elseif (!empty($id_or_email->comment_author_email)) {
                $email = $id_or_email->comment_author_email;
            }
        } else {
            $email = $id_or_email;
        }

        $hashkey = md5(strtolower(trim($email)));
        $uri = 'http://www.gravatar.com/avatar/' . $hashkey . '?d=404';

        $data = wp_cache_get($hashkey);
        if (false === $data) {
            $response = wp_remote_head($uri);
            if (is_wp_error($response)) {
                $data = 'not200';
            } else {
                $data = $response['response']['code'];
            }
            wp_cache_set($hashkey, $data, $group = '', $expire = 60 * 5);
        }
        if ($data == '200') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Customize the excerpt read-more indicator
     */
    function peacock_beach_excerpt_more($more) {
        return " …";
    }

    add_filter('excerpt_more', 'peacock_beach_excerpt_more');
    
    if ( ! function_exists( 'peacock_beach_paging_nav' ) ) :
	/**
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 * @since peacock_beach 1.0
	 *
	 * @global WP_Query   $wp_query   WordPress Query object.
	 * @global WP_Rewrite $wp_rewrite WordPress Rewrite object.
	 */
	function peacock_beach_paging_nav() {
		global $wp_query, $wp_rewrite;
	
		// Don't print empty markup if there's only one page.
		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}
	
		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );
	
		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}
	
		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';
	
		$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';
	
		// Set up paginated links.
		$links = paginate_links( array(
			'base'     => $pagenum_link,
			'format'   => $format,
			'total'    => $wp_query->max_num_pages,
			'current'  => $paged,
			'mid_size' => 1,
			'add_args' => array_map( 'urlencode', $query_args ),
			'prev_text' => __( '&larr; Previous', 'peacock_beach' ),
			'next_text' => __( 'Next &rarr;', 'peacock_beach' ),
			'type'		=> 'list',
		) );
	
		if ( $links ) :
	
		?>
		<nav class="navigation paging-navigation" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'peacock_beach' ); ?></h1>			
				<?php echo $links; ?>			
		</nav><!-- .navigation -->
		<?php
		endif;
	}
	endif;
    