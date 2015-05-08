<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package TA Pluton
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function ta_pluton_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'ta_pluton_body_classes' );

if ( version_compare( $GLOBALS['wp_version'], '4.1', '<' ) ) :
	/**
	 * Filters wp_title to print a neat <title> tag based on what is being viewed.
	 *
	 * @param string $title Default title text for current view.
	 * @param string $sep Optional separator.
	 * @return string The filtered title.
	 */
	function ta_pluton_wp_title( $title, $sep ) {
		if ( is_feed() ) {
			return $title;
		}

		global $page, $paged;

		// Add the blog name
		$title .= get_bloginfo( 'name', 'display' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			$title .= " $sep $site_description";
		}

		// Add a page number if necessary:
		if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
			$title .= " $sep " . sprintf( __( 'Page %s', 'ta-pluton' ), max( $paged, $page ) );
		}

		return $title;
	}
	add_filter( 'wp_title', 'ta_pluton_wp_title', 10, 2 );

	/**
	 * Title shim for sites older than WordPress 4.1.
	 *
	 * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
	 * @todo Remove this function when WordPress 4.3 is released.
	 */
	function ta_pluton_render_title() {
		?>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<?php
	}
	add_action( 'wp_head', 'ta_pluton_render_title' );
endif;

/**
 * Sets the authordata global when viewing an author archive.
 *
 * This provides backwards compatibility with
 * http://core.trac.wordpress.org/changeset/25574
 *
 * It removes the need to call the_post() and rewind_posts() in an author
 * template to print information about the author.
 *
 * @global WP_Query $wp_query WordPress Query object.
 * @return void
 */
function ta_pluton_setup_author() {
	global $wp_query;

	if ( $wp_query->is_author() && isset( $wp_query->post ) ) {
		$GLOBALS['authordata'] = get_userdata( $wp_query->post->post_author );
	}
}
add_action( 'wp', 'ta_pluton_setup_author' );


/**
 * Custom Tag Links.
 */
function post_tag_term_links( $term_links ) {

	$term_links = str_replace( 'rel="tag"', 'rel="tag" class="btn btn-default btn-xs"', $term_links );
	return $term_links;
}
add_filter( 'term_links-post_tag', 'post_tag_term_links' );

/**
 * Add Bootstrap thumbnail style to images with caption.
 */
function cleaner_caption( $output, $attr, $content ) {

	/* We're not worried abut captions in feeds, so just return the output here. */
	if ( is_feed() )
		return $output;

	/* Set up the default arguments. */
	$defaults = array(
		'id' => '',
		'align' => 'alignnone',
		'width' => '',
		'caption' => ''
	);

	/* Merge the defaults with user input. */
	$attr = shortcode_atts( $defaults, $attr );

	/* If the width is less than 1 or there is no caption, return the content wrapped between the [caption]< tags. */
	if ( 1 > $attr['width'] || empty( $attr['caption'] ) )
		return $content;

	/* Set up the attributes for the caption <div>. */
	$attributes = ( !empty( $attr['id'] ) ? ' id="' . esc_attr( $attr['id'] ) . '"' : '' );
	$attributes .= ' class="thumbnail wp-caption ' . esc_attr( $attr['align'] ) . '"';
	$attributes .= ' style="width: ' . esc_attr( $attr['width'] + 10 ) . 'px"';

	/* Open the caption <div>. */
	$output = '<div' . $attributes .'>';

	/* Allow shortcodes for the content the caption was created for. */
	$output .= do_shortcode( $content );

	/* Append the caption text. */
	$output .= '<p class="wp-caption-text">' . $attr['caption'] . '</p>';

	/* Close the caption </div>. */
	$output .= '</div>';

	/* Return the formatted, clean caption. */
	return $output;
}
add_filter( 'img_caption_shortcode', 'cleaner_caption', 10, 3 );

/**
 * Posts Page Custom Template.
 */
function posts_page_custom_template($template)
{
	global $wp_query;
	if( true == ( $posts_per_page_id = get_option( 'page_for_posts' )) ){
		$page_id = $wp_query->get_queried_object_id();
		if( $page_id == $posts_per_page_id ){
			$theme_directory = get_stylesheet_directory() ."/";
			$page_template   = get_post_meta( $page_id, '_wp_page_template', true );
			if( $page_template != 'default' ){
				if( is_child_theme() && !file_exists( $theme_directory . $page_template ) ){
					$theme_directory = get_template_directory();
				}
				return $theme_directory . $page_template;
			}
		}
	}
	return $template;
}

add_filter('template_include', 'posts_page_custom_template');

/**
 * Add Skype URI support for the social media icon.
 */
function allow_skype_protocol( $protocols ) {
    $protocols[] = 'skype';
    return $protocols;
}
add_filter( 'kses_allowed_protocols' , 'allow_skype_protocol' );