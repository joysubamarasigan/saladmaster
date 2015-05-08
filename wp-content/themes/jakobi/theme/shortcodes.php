<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

/**
 * Return the list of shortcodes and their settings
 *
 * @package Yithemes
 * @author Francesco Licandro  <francesco.licandro@yithemes.com>
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


$config = YIT_Plugin_Common::load();
$awesome_icons = YIT_Plugin_Common::get_awesome_icons();
$animate = $config['animate'];

$shop_shortcodes = array ();

$theme_shortcodes = array(

	/* ====== ONE PAGE ANCHOR ======== */
	'onepage_anchor' => array(
		'title' => __( 'OnePage Anchor', 'yit' ),
		'description' => __( 'Add the anchor for your OnePage', 'yit' ),
		'tab' => 'shortcodes',
		'has_content' => false,
		'in_visual_composer' => true,
		'attributes' => array(
			'name' => array(
				'title' => __('Name anchor (the name of anchor you define in the menu with #)', 'yit'),
				'type' => 'text',
				'std'  => ''
			)
		)

	),

    /*================= TESTIMONIAL ================*/
    'testimonial'        => array(
        'title'       => __( 'Testimonials', 'yit' ),
        'description' => __( 'Show all post on testimonials post types', 'yit' ),
        'tab'         => 'cpt',
        'in_visual_composer' => true,
        'has_content' => false,
        'create'      => false,
        'attributes'  => array(
            'items' => array(
                'title'       => __( 'N. of items', 'yit' ),
                'description' => __( 'Show all with -1', 'yit' ),
                'type'        => 'number',
                'std'         => '-1'
            ),
            'cat'   => array(
                'title'       => __( 'Categories', 'yit' ),
                'description' => __( 'Select the categories of posts to show', 'yit' ),
                'type'        => 'select',
                'options'     => apply_filters( 'yit_get_testimonial_categories', '' ),
                'std'         => ''
            ),
            'animate' => array(
                'title' => __('Animation', 'yit'),
                'type' => 'select',
                'options' => $animate,
                'std'  => ''
            ),
            'animation_delay' => array(
                'title' => __('Animation Delay', 'yit'),
                'type' => 'text',
                'desc' => __('This value determines the delay to which the animation starts once it\'s visible on the screen.', 'yit'),
                'std'  => '0'
            )
        )
    ),

    /*================= BLOG SECTION =================*/
    'blog_section' =>  array(
        'title' => __( 'Blog', 'yit' ),
        'description' => __( 'Print a blog slider', 'yit' ),
        'tab' => 'section',
        'has_content' => false,
        'in_visual_composer' => true,
        'create' => true,
        'attributes' => array(
            'nitems' => array(
                'title' => __( 'Number of items', 'yit' ),
                'description' => __( '-1 to show all elements', 'yit' ),
                'type' => 'number',
                'min' => -1,
                'max' => 99,
                'std' => -1
            ),
            'enable_slider' => array(
                'title' => __( 'Enable Slider', 'yit' ),
                'type' => 'checkbox',
                'std' => 'yes'
            ),
            'enable_thumbnails' => array(
                'title' => __( 'Show Thumbnails', 'yit' ),
                'type' => 'checkbox',
                'std' => 'yes'
            ),
            'enable_date' => array(
                'title' => __( 'Show Date', 'yit' ),
                'type' => 'checkbox',
                'std' => 'yes'
            ),
            'enable_title' => array(
                'title' => __( 'Show Title', 'yit' ),
                'type' => 'checkbox',
                'std' => 'yes'
            ),
            'enable_author' => array(
                'title' => __( 'Show Author', 'yit' ),
                'type' => 'checkbox',
                'std' => 'yes'
            ),
            'enable_comments' => array(
                'title' => __( 'Show Comments', 'yit' ),
                'type' => 'checkbox',
                'std' => 'yes'
            ),
            'animate' => array(
                'title' => __('Animation', 'yit'),
                'type' => 'select',
                'options' => $animate,
                'std'  => ''
            ),
            'animation_delay' => array(
                'title' => __('Animation Delay', 'yit'),
                'type' => 'text',
                'desc' => __('This value determines the delay to which the animation starts once it\'s visible on the screen.', 'yit'),
                'std'  => '0'
            )
        )
    ),

    /*================= SEPARATOR ================*/
    'separator' => array(
        'title' => __( 'Separator', 'yit' ),
        'description' => __( 'Print a separator line', 'yit' ),
        'tab' => 'shortcodes',
        'has_content' => false,
        'create' => true,
        'in_visual_composer' => true,
        'attributes' => array(
            'style' => array(
                'title' => __( 'Separator style', 'yit' ),
                'type' => 'select',
                'options' => array(
                    'single' => __( 'Single line', 'yit' ),
                    'double' => __( 'Double line', 'yit' ),
                    'dotted' => __( 'Dotted line', 'yit' ),
                    'dashed' => __( 'Dashed line', 'yit' )
                ),
                'std' => 'single'
            ),
            'color' => array(
                'title' => __( 'Separator color', 'yit' ),
                'type' => 'colorpicker',
                'std' => '#cdcdcd'
            ),
            'margin_top' => array(
                'title' => __( 'Margin top', 'yit' ),
                'type' => 'number',
                'min' => 0,
                'max' => 999,
                'std' => 40
            ),
            'margin_bottom' => array(
                'title' => __( 'Margin bottom', 'yit' ),
                'type' => 'number',
                'min' => 0,
                'max' => 999,
                'std' => 40
            )
        )
    ),

);


return  $theme_shortcodes;