<?php
/**
 * TA Pluton functions and definitions
 *
 * @package TA Pluton
 */

/*
 * Make theme available for translation.
 * Translations can be filed in the /languages/ directory.
 * If you're building a theme based on TA Pluton, use a find and replace
 * to change 'ta-pluton' to the name of your theme in all the template files
 */
load_theme_textdomain( 'ta-pluton', get_template_directory() . '/languages' );

// Include the Redux theme options Framework
if ( !class_exists( 'ReduxFramework' ) ) {
	require_once( get_template_directory() . '/redux/framework.php' );
}

// Register all the theme options
require_once( get_template_directory() . '/inc/redux-config.php' );

// Theme options functions
require_once( get_template_directory() . '/inc/ta-option.php' );

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 770; /* pixels */
}

if ( ! function_exists( 'ta_pluton_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function ta_pluton_setup() {

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'timeline-image', 200, 200, true );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'ta-pluton' ),
		'secondary' => __( 'Secondary Menu', 'ta-pluton' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'ta_pluton_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // ta_pluton_setup
add_action( 'after_setup_theme', 'ta_pluton_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function ta_pluton_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'ta-pluton' ),
		'id'            => 'sidebar-right',
		'description'   => 'Main sidebar that appears on the right.',
		'before_widget' => '<aside id="%1$s" class="widget %2$s well">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'ta_pluton_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ta_pluton_scripts() {
	wp_enqueue_style( 'bootstrap-styles', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.4', 'all' );

	wp_enqueue_style( 'bxslider-css', get_template_directory_uri() . '/css/jquery.bxslider.css', array(), '4.2.3', 'all' );

	wp_enqueue_style( 'cslider-css', get_template_directory_uri() . '/css/jquery.cslider.css', array(), '', 'all' );

	wp_enqueue_style( 'animate-css', get_template_directory_uri() . '/css/animate.css', array(), '', 'all' );

	wp_enqueue_style( 'custom-font', get_template_directory_uri() . '/css/pluton.css', array(), '', 'all' );

	wp_enqueue_style( 'Google-font', 'http://fonts.googleapis.com/css?family=Roboto:400,300,700&amp;subset=latin,latin-ext', array(), '', 'all' );

	wp_enqueue_style( 'ta-pluton-style', get_stylesheet_uri() );

	wp_enqueue_script( 'mixitup-js', get_template_directory_uri() . '/js/jquery.mixitup.min.js', array('jquery'), '2.1.7', true );

	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '3.3.4', true );

	wp_enqueue_script( 'modernizr-js', get_template_directory_uri() . '/js/modernizr.custom.js', array('jquery'), '2.5.3', true );

	wp_enqueue_script( 'bxslider-js', get_template_directory_uri() . '/js/jquery.bxslider.js', array('jquery'), '4.2.3', true );

	wp_enqueue_script( 'cslider-js', get_template_directory_uri() . '/js/jquery.cslider.js', array('jquery'), '', true );

	wp_enqueue_script( 'placeholder-js', get_template_directory_uri() . '/js/jquery.placeholder.min.js', array('jquery'), '2.1.1', true );

	wp_enqueue_script( 'inview-js', get_template_directory_uri() . '/js/jquery.inview.js', array('jquery'), '', true );

	wp_enqueue_script( 'nav-js', get_template_directory_uri() . '/js/jquery.nav.js', array('jquery'), '3.0.0', true );

	wp_enqueue_script( 'google-map-js', 'https://maps.googleapis.com/maps/api/js?sensor=false&amp;callback=initializeMap', array(), '', true );

	wp_enqueue_script( 'app-js', get_template_directory_uri() . '/js/app.js', array('jquery'), '', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ta_pluton_scripts' );

/**
 * Get theme path for app JavaScript file.
 */
function get_theme_directory_uri() {
	$stylesheet_directory_uri = array( 'templateUrl' => get_stylesheet_directory_uri() );
	wp_localize_script( 'app-js', 'app_uri', $stylesheet_directory_uri );
}
add_action( 'wp_enqueue_scripts', 'get_theme_directory_uri' );

/**
 * Get Google map location for app JavaScript file.
 */
function get_location_lat() {
	$location_lat = array( 'lat' => ta_option( 'lat' ) );
	wp_localize_script( 'app-js', 'map_location_lat', $location_lat );
}
add_action( 'wp_enqueue_scripts', 'get_location_lat' );

function get_location_lon() {
	$location_lon = array( 'lon' => ta_option( 'lon' ) );
	wp_localize_script( 'app-js', 'map_location_lon', $location_lon );
}
add_action( 'wp_enqueue_scripts', 'get_location_lon' );

/**
 * Add Respond.js for IE
 */
if( !function_exists( 'ie_scripts' ) ) {
	function ie_scripts() {
	 	echo '<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->';
	   	echo ' <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->';
	   	echo ' <!--[if lt IE 9]>';
	    echo ' <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>';
	    echo ' <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>';
	   	echo ' <![endif]-->';
   	}
   	add_action( 'wp_head', 'ie_scripts' );
} // end if

/**
 * Add Custom Font for IE7
 */
if( !function_exists( 'custom_font_ie7' ) ) {
	function custom_font_ie7() {
	   	echo ' <!--[if IE 7]>';
	    echo ' <link rel="stylesheet" type="text/css" href="css/pluton-ie7.css" />';
	   	echo ' <![endif]-->';
   	}
   	add_action( 'wp_head', 'custom_font_ie7' );
} // end if

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require_once get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require_once get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require_once get_template_directory() . '/inc/customizer.php';

/**
 * Register Custom Navigation Walker.
 */
require_once get_template_directory() . '/inc/wp_bootstrap_navwalker.php';

/**
 * Custom Post Types
 */
require_once get_template_directory() . '/inc/post-types/CPT.php';

/**
 * Portfolio Custom Post Type
 */
require_once get_template_directory() . '/inc/post-types/register-portfolio.php';

/**
 * Add Custom Meta Boxes
 */
require_once get_template_directory() . '/inc/custom-metaboxes/CMB.php';

/**
 * Comments Callback.
 */
require_once get_template_directory() . '/inc/comments-callback.php';

/**
 * Search Results - Highlight.
 */
require_once get_template_directory() . '/inc/search-highlight.php';

/**
 * Theme Options - Custom CSS.
 */
require_once get_template_directory() . '/inc/custom-css.php';