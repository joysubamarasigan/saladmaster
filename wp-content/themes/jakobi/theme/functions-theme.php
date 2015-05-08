<?php
/**
 * Your Inspiration Themes
 *
 * @package WordPress
 * @subpackage Your Inspiration Themes
 * @author Your Inspiration Themes Team <info@yithemes.com>
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

/**
 * Theme setup file
 */



/**
 * Set up all theme data.
 *
 * @return void
 * @since 1.0.0
 */
function yit_setup_theme() {

    /**
     * Set up the content width value based on the theme's design.
     *
     * @see yit_content_width()
     *
     * @since Twenty Fourteen 1.0
     */
    if ( ! isset( $GLOBALS['content_width'] ) ) {
        $GLOBALS['content_width'] = apply_filters( 'yit-container-width-std', 1170 );
    }

    //This theme have a CSS file for the editor TinyMCE
    add_editor_style( 'css/editor-style.css' );

    //This theme support post thumbnails
    add_theme_support( 'post-thumbnails' );

    //This theme uses the menus
    add_theme_support( 'menus' );

    //Add default posts and comments RSS feed links to head
    add_theme_support( 'automatic-feed-links' );

    //This theme support post formats
    add_theme_support( 'post-formats', apply_filters( 'yit_post_formats_support', array( 'gallery', 'audio', 'video', 'quote' ) ) );

    if ( ! defined( 'HEADER_TEXTCOLOR' ) )
        define( 'HEADER_TEXTCOLOR', '' );

    // The height and width of your custom header. You can hook into the theme's own filters to change these values.
    // Add a filter to twentyten_header_image_width and twentyten_header_image_height to change these values.
    define( 'HEADER_IMAGE_WIDTH', apply_filters( 'yiw_header_image_width', 1170 ) );
    define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'yiw_header_image_height', 410 ) );

    // Don't support text inside the header image.
    if ( ! defined( 'NO_HEADER_TEXT' ) )
        define( 'NO_HEADER_TEXT', true );

    //This theme support custom header
    add_theme_support( 'custom-header' );

    //This theme support custom backgrounds
    add_theme_support( 'custom-backgrounds' );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'search-form', 'comment-form', 'comment-list',
    ) );

    // We'll be using post thumbnails for custom header images on posts and pages.
    // We want them to be 940 pixels wide by 198 pixels tall.
    // Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
    // set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );
    $image_sizes = array(
        'blog_small'                        => array( 368, 266, true ),
        'blog_single_small'                 => array( 1140, 491, true ),
        'blog_thumb'                        => array( 49, 49, true ),
        'blog_section'                      => array(269, 122, true),
        'blog_section_mobile'               => array(716, 325, true)
    );

    $image_sizes = apply_filters( 'yit_add_image_size', $image_sizes );

    foreach ( $image_sizes as $id_size => $size ) {
        add_image_size( $id_size, apply_filters( 'yit_' . $id_size . '_width', $size[0] ), apply_filters( 'yit_' . $id_size . '_height', $size[1] ), isset( $size[2] ) ? $size[2] : false );
    }

    //Set localization and load language file
    $locale = get_locale();
    $locale_file = YIT_THEME_PATH . "/languages/$locale.php";
    if ( is_readable( $locale_file ) )
        require_once( $locale_file );



    // Add support to woocommerce
    if ( defined('YIT_IS_SHOP') && YIT_IS_SHOP ) {
        add_theme_support( 'woocommerce' );
    }

    //Register menus
    register_nav_menus(
        array(
            'nav' => __( 'Main Navigation', 'yit' ),
            'mobile-nav' => __( 'Mobile Navigation', 'yit' ),
            'copyright_right' => __( 'Copyright Right', 'yit' ),
            'copyright_left' => __( 'Copyright Left', 'yit' ),
            'copyright_centered' => __( 'Copyright Centered', 'yit' )
        )
    );

    //Register footer sidebar
    for( $i = 1; $i <= yit_get_option( 'footer-rows', 0 ); $i++ ) {
        register_sidebar( yit_sidebar_args( "Footer Row $i", sprintf(  __( "The widget area #%d used in Footer section", 'yit' ), $i ), 'widget col-sm-' . ( 12 / yit_get_option( 'footer-columns' ) ), apply_filters( 'yit_footer_sidebar_' . $i . '_wrap', 'h5' ) ) );
    }
}

/**
 * Remove the class no-js when javascript is activated
 *
 * We add the action at the start of head, to do this operation immediatly, without gap of all libraries loading
 */
function yit_detect_javascript() {
	?>
	<script type="text/javascript">document.documentElement.className = document.documentElement.className.replace( 'no-js', '' ) + ' yes-js js_active js'</script>
	<?php
}

/**
 * Adjust content_width value for image attachment template.
 *
 * @since Twenty Fourteen 1.0
 *
 * @return void
 */
function yit_content_width() {
    $full_width = $GLOBALS['content_width'];
    $sidebar_width = $full_width * ( 25 / 100 );   // 25% (col-3)
    $sidebar = YIT_Layout()->sidebars;
    $sidebar = is_array( $sidebar ) ? $sidebar : array( 'layout' => $sidebar );

    if ( 'sidebar-double' == $sidebar['layout'] ) {
        $GLOBALS['content_width'] -= $sidebar_width * 2;
    } elseif ( 'sidebar-no' != $sidebar['layout'] ) {
        $GLOBALS['content_width'] -= $sidebar_width;
    }

    $GLOBALS['content_width'] -= 30;
}
add_action( 'template_redirect', 'yit_content_width' );


/**
 * Register the extra body classes to add in the pages
 *
 * @param array $classes
 *
 * @return array
 * @since 1.0.0
 */
function yit_add_body_class( $classes ) {
    $classes[] = yit_get_option('general-layout-type') . '-layout';
    $classes = yit_detect_browser_body_class( $classes );

    if( is_singular( 'post' ) ){
        $classes[] = 'blog-single-' . yit_get_option( 'blog-single-type' );
    }

    if( yit_get_option( 'general-activate-responsive' ) == 'yes' ){
        $classes[] = 'responsive';
    }

    return $classes;
}

/**
 * Extend the default WordPress post classes.
 *
 * Adds a post class to denote:
 * Non-password protected page with a post thumbnail.
 *
 * @since Twenty Fourteen 1.0
 *
 * @param array $classes A list of existing post class values.
 * @return array The filtered post class list.
 */
function yit_post_classes( $classes ) {
    if ( ! post_password_required() && has_post_thumbnail() ) {
        $classes[] = 'has-post-thumbnail';
    }

    return $classes;
}
add_filter( 'post_class', 'yit_post_classes' );

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
if ( ! function_exists( 'yit_wp_title' ) ) {
    function yit_wp_title( $title = '', $sep = '' ) {
        global $paged, $page;

        if ( is_feed() ) {
            return $title;
        }

        // Add the site name.
        $title .= get_bloginfo( 'name' );

        // Add the site description for the home/front page.
        $site_description = get_bloginfo( 'description', 'display' );
        if ( $site_description && ( is_home() || is_front_page() ) ) {
            $title = "$title $sep $site_description";
        }

        // Add a page number if necessary.
        if ( $paged >= 2 || $page >= 2 ) {
            $title = "$title $sep " . sprintf( __( 'Page %s', 'yit' ), max( $paged, $page ) );
        }

        return $title;
    }
}
add_filter( 'wp_title', 'yit_wp_title', 10, 2 );

if( ! function_exists( 'remove_equals_from_special_chars' ) ){
    function remove_equals_from_special_chars( $chars ){

        unset( $chars['/[=\[](.*?)[=\]]/'] );
        $chars[ '/[\[](.*?)[\]]/' ] = '<span class="title-highlight">$1</span>';

        return $chars;
    }
}

// Remove Open Sans that WP adds from frontend

if ( ! function_exists( 'remove_wp_open_sans' ) ) :
    function remove_wp_open_sans() {
        wp_deregister_style( 'open-sans' );
        wp_register_style( 'open-sans', false );
    }

    add_action( 'wp_enqueue_scripts', 'remove_wp_open_sans' );
    // Uncomment below to remove from admin
    // add_action('admin_enqueue_scripts', 'remove_wp_open_sans');
endif;

/**
 * === Start Blog Functions ===
 */

if( ! function_exists( 'yit_add_blog_stylesheet' ) ) {

    /**
     * Register/Enqueue the blog stylesheet
     *
     * @return void
     * @since 2.0.0
     * @author Andrea Grillo    <andrea.grillo@yithems.com>
     */

    function yit_add_blog_stylesheet(){
        $blog = array(
            'src'           => YIT_THEME_ASSETS_URL . '/css/blog.css',
            'enqueue'       => true,
            'registered'    => false
        );

        if( is_page_template( 'blog.php' ) || is_search() || is_singular( 'post' ) || is_home()|| is_archive() || is_category() || is_tag() || yit_is_old_ie() ){
            YIT_Asset()->set( 'style', 'blog-stylesheet', $blog, 'before', 'comment-stylesheet' );

        }
    }
}

if( ! function_exists( 'yit_blog_big_post_start' ) ){
    /**
     * Start the blog post
     *
     * @return void
     * @since 2.0.0
     * @author Antonio La Rocca <antonio.larocca@yithems.com>
     * @author Andrea Grillo    <andrea.grillo@yithems.com>
     */

    function yit_blog_big_post_start( $position = 'next-post' ){
		global $post;

        if ( is_null( $post ) || empty( $post ) ) { return; }

		if( YIT_Request()->is_ajax && isset( $_REQUEST['post_id'] ) ){
			$post = get_post( intval( $_REQUEST['post_id'] ) );
		}

		if( ( is_singular( 'post' ) || YIT_Request()->is_ajax && $post->post_type == 'post' ) && yit_get_option( 'blog-single-type' ) == 'big' ) {
            $post_format    = ( ! get_post_format() ) ? 'standard' : get_post_format();
            $show_thumbnail = ( yit_get_option( 'blog-single-show-featured-image' ) == 'yes' && has_post_thumbnail() && $post_format == 'standard' ) ? true : false;
            ?>

            <?php if( $position != 'next-post' ) : ?>
                <div id="current" class="slide-tab current-post blog_big">
            <?php endif; ?>
            <?php if( $show_thumbnail && $post_format == 'standard' ) : ?>
                <?php yit_get_template( 'blog/post-formats/' . $post_format . '.php', array( 'show_date' => false, 'blog_type' => yit_get_option( 'blog-single-type' ), 'doing_ajax'     => ( defined( 'DOING_AJAX' )  && DOING_AJAX  ) ? true : false ) ) ?>
            <?php else: ?>
                <?php $args = array(
                    'post_format'    => $post_format,
                    'image_size'     => YIT_Registry::get_instance()->image->get_size( 'blog_single_big' ),
                    'show_date'      => ( yit_get_option( 'blog-single-show-date' ) == 'yes' ) ? true : false,
                    'blog_type'      => yit_get_option( 'blog-single-type' ),
                    'doing_ajax'     => ( defined( 'DOING_AJAX' )  && DOING_AJAX  ) ? true : false
                );


                if( $post_format != 'quote' ) {
                    yit_get_template( 'blog/post-formats/' . $post_format . '.php', $args );
                }elseif( $post_format == 'quote' && has_post_thumbnail() ) {
                    yit_image( 'size=blog_single_big&class=img-responsive' );
                }
            endif;
        }
    }
}

if( ! function_exists( 'yit_blog_big_post_end' ) ){

    function yit_blog_big_post_end(){

        if( is_singular( 'post' ) && yit_get_option( 'blog-single-type' ) == 'big' ){
            echo '</div>';
        }
    }
}

add_action( 'wp_ajax_blog_next_post', 'yit_blog_big_next_post' );
add_action( 'wp_ajax_nopriv_blog_next_post', 'yit_blog_big_next_post');

if( ! function_exists( 'yit_blog_big_next_post' ) ){
    /**
     * Get the next blog post with an ajax call
     *
     * @return void
     * @since 2.0.0
     * @author Antonio La Rocca <antonio.larocca@yithems.com>
     * @author Andrea Grillo    <andrea.grillo@yithems.com>
     */
    function yit_blog_big_next_post(){
		global $post;

        if ( is_null( $post ) || empty( $post ) ) { return; }

		if( YIT_Request()->is_ajax && isset( $_REQUEST['post_id'] ) ){
			$post = get_post( intval( $_REQUEST['post_id'] ) );
		}

		if( ( is_singular( 'post' ) || YIT_Request()->is_ajax && $post->post_type == 'post' ) && yit_get_option( 'blog-single-type' ) == 'big' ) {

            $blog_type_options = array(
                'blog_single_type'  => yit_get_option( 'blog-single-type' ),
                'is_next_post'      => true
            );

            $image_size = YIT_Registry::get_instance()->image->get_size( 'blog_single_big' );

            $next_post = get_previous_post( );

            if( $next_post == '' || $next_post == null ){

                $args = array(
                    'order' => 'DESC',
                    'order_by' => 'date'
                );

                $posts = get_posts( $args );

                if( ! empty( $posts ) ){
                    $next_post = $posts[0];
                }
            }

            $post = $next_post;
            setup_postdata($post);
            $has_post_thumbnail = has_post_thumbnail();
            $placeholder = ! $has_post_thumbnail ? 'class="placeholder no-featured" style="height: ' . $image_size['height'] .'px;"' : 'class="placeholder" style="max-height: ' . $image_size['height'] .'px;"';
            ?>
            <div id="next" class='slide-tab next-post hidden-content' data-post_id="<?php the_ID() ?>">
                <div class='big-image'>
                    <div <?php echo $placeholder; ?>>
                        <?php if( $has_post_thumbnail ) : ?>
                            <?php yit_image( array( 'post_id' =>  get_the_ID(), 'size' => 'blog_single_big', 'class' => 'img-responsive' ) ); ?>
                        <?php endif; ?>
                        <div class="inner">
                            <div class="info-overlay">
                                <div class="read-more-label"><?php _e( 'VIEW NEXT POST', 'yit' ) ?></div>
                                <div class="read-more-title"><?php the_title() ?></div>
                            </div>
                        </div>
                    </div>
                    <?php yit_blog_big_post_start( 'next-post' ) ?>
                </div>
                <div class='container'>
                    <?php
                    remove_action( 'yit_primary', 'yit_start_primary', 5 );
                    remove_action( 'yit_primary', 'yit_end_primary', 90 );
                    remove_action( 'yit_content_loop', 'yit_content_loop', 10 );
                    add_action( 'yit_content_loop', 'yit_blog_single_loop' );
                    yit_get_template( 'primary/loop/single.php', $blog_type_options );
                    if( ! YIT_Request()->is_ajax ){
                        comments_template();
                    }
                    add_action( 'yit_primary', 'yit_end_primary', 90 );
                    ?>
                </div>
            </div>
            <?php

            if( defined('DOING_AJAX') && DOING_AJAX ){
                die();
            }
        }
    }
}

if( ! function_exists( 'yit_blog_single_loop' ) ){
    /**
     * Add the loop in the single template
     *
     * @return void
     * @since 2.0.0
     * @author Antonio La Rocca <antonio.larocca@yithems.com>
     * @author Andrea Grillo    <andrea.grillo@yithems.com>
     */
    function yit_blog_single_loop(){
        if( is_singular( 'post' ) && yit_get_option( 'blog-single-type' ) == 'big' ){
            do_action( 'yit_loop' );
        }
    }
}

if( ! function_exists( 'yit_get_comments_template' ) ){
    /**
     * Get the comments template
     *
     * @return mixed
     * @since 2.0.0
     * @author Andrea Grillo <andrea.grillo@yithems.com>
     */

    function yit_get_comments_template(){
        return include( YIT_PATH . '/comments.php' );
    }
}

//Hide the footer
if( ! function_exists( 'yit_hide_footer' ) ) {

    /**
     * Change the footer type options to hide the footer
     *
     * @return void
     * @since 2.0.0
     * @author Andrea Grillo    <andrea.grillo@yithems.com>
     */
    function yit_hide_footer() {
        return 'none';
    }
}


if( !function_exists('yit_curPageURL') ) {
    /**
     * Retrieve the current complete url
     *
     * @since 1.0
     */
    function yit_curPageURL() {
        $pageURL = 'http';
        if ( isset( $_SERVER["HTTPS"] ) AND $_SERVER["HTTPS"] == "on" )
            $pageURL .= "s";

        $pageURL .= "://";

        if ( isset( $_SERVER["SERVER_PORT"] ) AND $_SERVER["SERVER_PORT"] != "80" )
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        else
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

        return $pageURL;
    }
}
/**
 * === END Blog Functions ===
 */


if( !function_exists( 'yit_excerpt_text' ) ) {
    /**
     * Cut the text
     *
     * @author Andrea Grillo  <andrea.grillo@yithemes.com>
     *
     * @param string $text
     * @param int $excerpt_length
     * @param string $excerpt_more
     * @return string
     * @since 1.0.0
     */
    function yit_excerpt_text( $text, $excerpt_length = 50, $excerpt_more = '' ) {
        $words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
        if ( count($words) > $excerpt_length ) {
            array_pop($words);
            $text = implode(' ', $words);
            $text = $text . $excerpt_more;
        } else {
            $text = implode(' ', $words);
        }

        echo $text;
    }
}




if( !function_exists( 'yit_get_registered_nav_menus' ) ) {
    /**
     * Retireve all registered menus
     *
     * @return array
     * @since 1.0.0
     */
    function yit_get_registered_nav_menus() {
        $menus = get_terms( 'nav_menu' );
        $return = array();

        foreach( $menus as $menu ) {
            array_push( $return, $menu->name );
        }

        return $return;
    }
}
if( !function_exists( 'yit_og' ) ) {
    function yit_og(){
        if(  yit_get_option('general-enable-open-graph') == 'no' ) {
            return;
        }

        /**
         * Create the og tag description with properly content, based on the current queried object.
         */
        $queried_object = get_queried_object();

        $ogcontent  = array();
        $ogcontent['site_name'] = get_bloginfo( 'name' );
        $ogcontent['title'] = yit_wp_title();

        // For posts, pages and products
        if( isset( $queried_object->post_type ) ) {
            $post    = get_post( $queried_object->ID );
            $ogcontent['url'] = get_permalink( $post );
            $ogcontent['description'] = $post->post_excerpt ? $post->post_excerpt : wp_trim_words( $post->post_content );


            if( has_post_thumbnail( $post->ID ) ) {
                $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) , 'medium');
                $ogcontent['image'] = $image_url[0];
            }

        } else if( isset( $queried_object->taxonomy ) && $queried_object->taxonomy ) {

            $ogcontent['description'] = $queried_object->description;

            if(  function_exists( 'WC' ) ){
                $term_thumbnail = get_woocommerce_term_meta( $queried_object->term_id, 'thumbnail_id', true );
                $imgs = wp_get_attachment_image_src( $term_thumbnail, 'medium' );
                if( $imgs[0] ){
                    $ogcontent['image'] = $imgs[0];
                }
            }
        }

        // If the taxonomy or post don't have content, use the site description
        if( (is_home() || is_front_page())  && empty( $ogcontent['description'] ) ) {
            $ogcontent['description'] = get_bloginfo( 'description' );
        }

        if( empty( $ogcontent['image'] ) && yit_get_option( 'header-custom-logo' ) == 'yes' && yit_get_option( 'header-custom-logo-image' ) != '' ) {
            $ogcontent['image'] = yit_get_option( 'header-custom-logo-image' );
        }

        $ogcontent['description'] = isset( $ogcontent['description'] ) ? apply_filters( 'yit_og_description', strip_tags(strip_shortcodes(preg_replace("~(?:\[/?)[^/\]]+/?\]~s", '', $ogcontent['description'])))) : '';

        foreach( $ogcontent as $property => $content ){
            echo "<meta property='og:". $property."' content='" . $content . "'/>\n";
        }

    }

}
/**
 * SoundCloud functions
*/
if( ! function_exists( 'soundcloud_oembed_params' ) ){
    function soundcloud_oembed_params( $embed, $params ) {
        global $soundcloud_oembed_params;
        $soundcloud_oembed_params = $params;
        return preg_replace_callback( '/src="(https?:\/\/(?:w|wt)\.soundcloud\.(?:com|dev)\/[^"]*)/i', 'soundcloud_oembed_params_callback', $embed );
    }
}

if( ! function_exists( 'soundcloud_oembed_params_callback' ) ){
    function soundcloud_oembed_params_callback( $match ) {
        global $soundcloud_oembed_params;

        // Convert URL to array
        $url = parse_url( urldecode( $match[1] ) );
        // Convert URL query to array
        parse_str( $url['query'], $query_array );
        // Build new query string
        $query = http_build_query( array_merge( $query_array, $soundcloud_oembed_params ) );

        $search  = array( 'show_artwork=0', 'show_artwork=1', 'auto_play=0', 'auto_play=1', 'show_comments=0', 'show_comments=1' );
        $replace = array( 'show_artwork=false', 'show_artwork=true', 'auto_play=false', 'auto_play=true', 'show_comments=false', 'show_comments=true' );

        $query = str_replace( $search, $replace, $query );

        return 'src="' . $url['scheme'] . '://' . $url['host'] . $url['path'] . '?' . $query;
    }
}

if( ! function_exists( 'yit_string_is_serialized' ) ) {
     /**
     * Check if a string is serialized
     *
     * @author   Andrea Grillo  <andrea.grillo@yithemes.com>
     *
     * @param $string
     *
     * @internal param string $src
     * @return bool | true if string is serialized, false otherwise
     * @since    2.0.0
     */
    function yit_string_is_serialized( $string ) {
        $data = @unserialize( $string );
        return ! $data ? $data : true;
    }
}

if( ! function_exists( 'yit_string_is_json' ) ){
    /**
     * Check if a string is json
     *
     * @author   Andrea Grillo  <andrea.grillo@yithemes.com>
     *
     * @param $string
     *
     * @internal param string $src
     * @return bool | true if string is json, false otherwise
     * @since    2.0.0
     */
    function yit_string_is_json( $string ) {
        $data = @json_decode( $string );
        return $data == NULL ? false : true;
    }
}

if( ! function_exists( 'yit_remove_script_version' ) ) {
    /**
     * Remove the script version from the script and styles
     *
     * @author Andrea Grillo  <andrea.grillo@yithemes.com>
     *
     * @param string $src
     * @return string
     * @since 1.0.0
     */
    function yit_remove_script_version( $src ) {
        if( yit_get_option( 'general-remove-scripts-version' ) == 'yes' ) {
            $parts = explode( '?v', $src );
            return $parts[0];
        } else {
            return $src;
        }
    }

}

if(!function_exists("yit_exclude_categories_list_widget"))   {
	/*
   * exclude categories(selected in the theme options) from wordpress widget categories
   *
   * @return void
   * @since 2.0
   * @author Andrea Frascaspata <andrea.frascaspata@yithemes.com>
   */
	function yit_exclude_categories_list_widget($args){
		$cat_args = array('exclude' =>str_replace("-","",yit_get_excluded_categories(2)));
		return array_merge($args,$cat_args);
	}
}



// replace "HOME" with icon
function yit_navigation_home_to_icon( $nav_menu, $args ) {
    return preg_replace( '/(<li[^>]*icon-home(-responsive)?[^>]*><a[^>]*>).*?(<\/a><\/li>)/', '$1<span class="glyphicon glyphicon-home"></span>$3', $nav_menu );
}
add_filter( 'wp_nav_menu', 'yit_navigation_home_to_icon', 10, 2 );

if ( ! function_exists( 'yit_category_page_product_counter' ) ) {
    /**
     * Return html code of categories product number
     *
     * @author   Andrea Frascaspata  <andrea.frascaspata@yithemes.com>
     *
     * @param $count
     * @param $category
     *
     * @return string
     * @since    1.2.2
     */
    function yit_category_page_product_counter( $count, $category ) {
        return apply_filters( 'woocommerce_subcategory_count_html', ' <span class="count">(' . $count . ')</span>', $category );
    }
}
