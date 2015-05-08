<?php
/**
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if (!defined('YIT')) exit('Direct access forbidden.');

/**
 * YIT_Shortcode exists
 */
define('YIT_SHORTCODE', true);

/**
 * Perform shortcodes init
 *
 * @class YIT_Shortcodes
 * @package Yithemes
 * @since 1.0.0
 * @author Your Inspiration Themes
 */

class YIT_Shortcodes {
    /**
     * Shortcodes array
     *
     * @var array() Array containing the shortcodes
     * The array is created by using the following rules:
     *
     * [shortcode_name] => array(
     *     [title] => 'title',
     *     [description] => 'description',
     *     [has_content] => true,
     *     [in_visual_composer] => true, //boolean
     *     [visual_composer_label] => 'param1_name', //param_name/content/hidden
     *     [attributes] => array(
     *       [param1_name] => array(
     *        'type' => 'param1_type',
     * 		  'std'  => 'param1_std'
     * 	    )
     * 	    [param2_name] => array(
     *        'type' => 'param2_type',
     * 		  'std'  => 'param2_std'
     * 	    )
     *    )
     * )
     *
     */
    public $shortcodes = array();

    /**
     * @var string Plugin url
     */
    public $shortcodes_url;

    /**
     * @var string Plugin path
     */
    public $shortcodes_path;

    /**
     * @var string plugin assets path
     */
    public $shortcodes_assets_url;

    /**
     * @var integer A counter for unique shortcode identification
     *
     * @since 1.0
     * @author Andrea Frascaspata <andrea.frascapsata@yithemes.com>
     */
    protected $_index = 0;

    /**
     * @var bool Detect if is inside the shortcode template or not
     *
     * @since 1.0
     * @author Antonino Scarfi' <antonino.scarfi@yithemes.com>
     */
    public $is_inside = false;

    /**
     * @var object The single instance of the class
     * @since 1.0
     */
    protected static $_instance = null;

    /**
     * Constructor
     *
     * Constructor method of the class. Add init method to the init action
     *
     * @since 1.0.0
     * @author Antonio La Rocca <antonio.larocca@yithemes.it>
     */
    public function __construct() {
        //Define local attributes
        $this->shortcodes_url  = YIT_CORE_URL . '/shortcodes';
        $this->shortcodes_path = YIT_CORE_PATH . '/shortcodes';
        $this->shortcodes_assets_url = YIT_CORE_ASSETS_URL;

        //Define global variable tab for shortcode popup
        global $name_tab;
        $name_tab = apply_filters( 'yit_shortcodes_tabs', array(
            'shortcodes' => __('Shortcodes', 'yit'),
            'section' => __('Section', 'yit'),
            'cpt' => __('Post Type', 'yit'),
        ) );

        if( function_exists( 'WC' ) ){
            $name_tab['shop'] =  __('Shop', 'yit');
        }

        //Start shortcode init
        add_action( 'init', array( &$this, 'init' ) );

        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'yit_shortcode_global_object' ), 100 );

    }

    /**
     * Init
     *
     * Get the shortcodes list and save it in @see $shortcode. Add shortcode button to TinyMCE editor
     *
     * @return void
     * @since 1.0.0
     * @author Antonio La Rocca <antonio.larocca@yithemes.it>
     */
    public function init() {
        //Include themechild-defined shortcodes
        $path_to_theme = ( defined( 'YIT_THEME_PATH' ) ) ? YIT_THEME_PATH : get_template_directory()."/theme";
        $path_to_child_theme = get_stylesheet_directory()."/theme";

        //Include theme-defined shortcodes
        $theme_shortcodes = array();
        $child_theme_shortcodes = array();

        //Include plugin shortcodes
        $core_shortcodes = include( $this->shortcodes_path.'/shortcodes.php' );

        //Include plugin shop shortcodes
        $core_shop_shortcodes = array();

        if ( function_exists('WC') ) {
            //function for shop-shortcodes
            include( $this->shortcodes_path.'/functions-shop.php' );

            $core_shop_shortcodes = include( $this->shortcodes_path.'/shop-shortcodes.php');
        }

        if( file_exists( $path_to_theme . '/shortcodes.php' ) ){
            $theme_shortcodes = include( $path_to_theme . '/shortcodes.php' );
        }

        if( file_exists( $path_to_child_theme . '/shortcodes.php' ) ){
            $child_theme_shortcodes = include( $path_to_child_theme . '/shortcodes.php' );
        }

        //Let theme to modify shortcode list
        $core_shortcodes = apply_filters( 'yit-shortcode-plugin-init', array_merge( $core_shortcodes, $core_shop_shortcodes ) );
        $this->shortcodes = array_merge( $core_shortcodes, $theme_shortcodes, $child_theme_shortcodes );

        //Order shortcodes and call add_shortcode to register them
        asort( $this->shortcodes );
        $this->add_shortcodes();

        //Add context menu to TinyMCE editor
        add_action('media_buttons_context', array(&$this,'media_buttons_context'));
        add_action('admin_init', array(&$this,'add_shortcodes_button'));
        add_action('admin_print_footer_scripts',  array(&$this, 'add_quicktags'));
        add_action('admin_action_yit_shortcode_popup', array(&$this, 'shortcode_popup'));
    }

    /**
     * Register shortcodes
     *
     * Foreach element in @see shortcode, call add_shortcode
     *
     * @return void
     * @since 1.0.0
     * @author Antonio La Rocca <antonio.larocca@yithemes.it>
     */
    public function add_shortcodes() {
        //Sorts element by title
        uasort( $this->shortcodes, array( $this, 'sort_shortcodes' ) );

        foreach( $this->shortcodes as $shortcode=> $atts ) {

            if( empty( $atts ) ){
                continue;
            }

            // register the shortcode
            if ( ! isset( $atts['create'] ) || $atts['create'] ) {
                add_shortcode( $shortcode, array( &$this, 'add_shortcode') );
            }

        }
    }

    /**
     * Sorts shortcodes elements
     *
     * Compare shortcode title, returning an integer less than, equal to, or greater than zero
     * if the first argument is considered to be respectively less than, equal to, or greater than the second.
     *
     * @param $a
     * @param $b
     *
     * @return integer
     * @since  1.0.0
     * @author Antonio La Rocca <antonio.larocca@yithemes.it>
     */
    public function sort_shortcodes( $a, $b ){
        return strcmp( $a['title'], $b['title'] );
    }

    /**
     * Shortcode callback
     *
     * Return the html template of the shortcode
     *
     * @param $atts array() Array containing shortcode attribute
     * @param $content mixed The content of the shortcode. Default null
     * @param $shortcode string The shortcode tag
     *
     * @return string
     * @since 1.0.0
     * @author Antonio La Rocca <antonio.larocca@yithemes.it>
     */
    public function add_shortcode( $atts, $content = null, $shortcode ) {
        $all_atts = $atts;
        $all_atts['content'] = $content;
        uasort( $this->shortcodes, array( $this, 'sort_shortcodes' ) );

        if( isset( $this->shortcodes[ $shortcode ]['unlimited'] ) && $this->shortcodes[ $shortcode ]['unlimited'] ) {
            $atts['content'] = $content;
        } else {
            //retrieves default atts
            $default_atts = array();

            if( !empty( $this->shortcodes[ $shortcode ]['attributes'] ) ) {
                foreach( $this->shortcodes[ $shortcode ]['attributes'] as $name=>$type ) {
                    $default_atts[ $name ] = isset( $type['std'] ) ? $type['std'] : '';
                    if( isset( $atts[$name] ) && $type['type'] == "checkbox"  ){

                        if ( $atts[$name] == 1 || $atts[$name] == 'yes' ){
                            $atts[$name] = 'yes';
                        }else{
                            $atts[$name] = 'no';
                        }

                    }
                }
            }

            //combines with user attributes
            $atts = shortcode_atts( $default_atts, $atts );
            $atts['content'] = $content;
        }

        // remove validate attrs
        foreach ( $atts as $att => $v ) {
            unset( $all_atts[ $att ] );
        }

        ob_start();

        if($path_to_template = $this->get_template_directory( $shortcode )){
            $index = $this->_index++;

            $this->is_inside = true;

            extract( array_merge( $atts, array( 'other_atts' => $all_atts ) ) );
            include( $path_to_template );

            $this->is_inside = false;
        }

        $shortcode_html = ob_get_clean();

        return apply_filters( 'yit_shortcode_' . $shortcode, $shortcode_html, $shortcode );
    }

    /**
     * Return the actual index of shortcodes. If outside of template shortcode, it returns false
     *
     * @return mixed
     * @since 1.0.0
     * @author Antonino Scarfi' <antonino.scarfi@yithemes.it>
     */
    public function index() {
        return $this->is_inside ? $this->_index : false;
    }

    /**
     * Get template directory
     *
     * Return path to shortcode template; return false if no template was found
     *
     * @param $shortcode string Shortcode tag
     *
     * @return string|false
     * @since 1.0.0
     * @author Antonio La Rocca <antonio.larocca@yithemes.it>
     */
    public function get_template_directory( $shortcode ){
        //Define path where to search shortcode template
        $path_to_child_template = get_stylesheet_directory()."/theme/templates/shortcodes";
        $path_to_template = ( defined( 'YIT_THEME_PATH' ) ) ? YIT_THEME_PATH."/templates/shortcodes" : get_template_directory()."/theme/templates/shortcodes";
        $alternative_path_to_template = get_template_directory()."/shortcodes";

        //Find shortcode template and return its path; if don't find anything, return false
        if( file_exists( $path_to_child_template.'/'.$shortcode.'.php' ) ){
            return $path_to_child_template.'/'.$shortcode.'.php';
        }
        elseif( file_exists( $path_to_template.'/'.$shortcode.'.php' ) ){
            return $path_to_template.'/'.$shortcode.'.php';
        }
        elseif( file_exists( $alternative_path_to_template.'/'.$shortcode.'.php' ) ){
            return $alternative_path_to_template.'/'.$shortcode.'.php';
        }
        elseif( file_exists( $this->shortcodes_path.'/templates/shortcodes/'.$shortcode.'.php') ){
            return $this->shortcodes_path.'/templates/shortcodes/'.$shortcode.'.php';
        }
        else{
            return false;
        }

    }

    /**
     * Add context button
     *
     * Add shortcode button to context button section; init hooks it to media_buttons_context hook
     *
     * @param $context string Context actual status
     *
     * @return string
     * @since 1.0.0
     * @author Antonio La Rocca <antonio.larocca@yithemes.it>
     */
    public function media_buttons_context($context){
        global $post_ID, $temp_ID;

        $iframe_ID = (int) (0 == $post_ID ? $temp_ID : $post_ID);
        $out = '<a id="add_shortcode" style="display:none" href="'.admin_url( 'admin.php?action=yit_shortcode_popup&post_id='.$iframe_ID.'&TB_iframe=1' ).'" class="hide-if-no-js thickbox" title="'. __("Add shortcode", 'yit').'"><img src="'.$this->shortcodes_assets_url . '/images/icon_shortcodes.png' . '" alt="'. __( "Add Shortcode", 'yit' ) . '" /></a>';

        return $context . $out;
    }

    /**
     * Add shortcode button
     *
     * Add shortcode button to TinyMCE editor, adding filter on mce_external_plugins
     *
     * @return void
     * @since 1.0.0
     * @author Antonio La Rocca <antonio.larocca@yithemes.it>
     */
    public function add_shortcodes_button() {
        if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) )
            return;
        if ( get_user_option( 'rich_editing' ) == 'true') {
            add_filter( 'mce_external_plugins', array( &$this, 'add_shortcodes_tinymce_plugin' ) );
            add_filter( 'mce_buttons', array( &$this, 'register_shortcodes_button' ) );
        }
    }

    /**
     * Add shortcode plugin
     *
     * Add a script to TinyMCE script list
     *
     * @param $plugin_array array() Array containing TinyMCE script list
     *
     * @return array() The edited array containing TinyMCE script list
     * @since 1.0.0
     * @author Antonio La Rocca <antonio.larocca@yithemes.it>
     */
    public function add_shortcodes_tinymce_plugin( $plugin_array ) {
        $plugin_array['yitshortcodes'] = $this->shortcodes_assets_url . '/js/tinymce.js';
        return $plugin_array;
    }

    /**
     * Register shortcode button
     *
     * Make TinyMCE know a new button was included in its toolbar
     *
     * @param $buttons array() Array containing buttons list for TinyMCE toolbar
     *
     * @return array() The edited array containing buttons list for TinyMCE toolbar
     * @since 1.0.0
     * @author Antonio La Rocca <antonio.larocca@yithemes.it>
     */
    public function register_shortcodes_button( $buttons ) {
        array_push( $buttons, "|", "yitshortcodes" );
        return $buttons;
    }

    /**
     * Shortcode popup
     *
     * Include shortcode popup template when needed. Init hooks it to admin_action_yit_shortcode_popup hook
     *
     * @return void
     * @since 1.0.0
     * @author Antonio La Rocca <antonio.larocca@yithemes.it>
     */
    public function shortcode_popup( ){
        global $name_tab;
        require_once( $this->shortcodes_path.'/templates/admin/tinymce/lightbox.php' );
    }

    /**
     * Add quicktags to visual editor
     *
     * Add shortcode button to quicktags section
     *
     * @return void
     * @since 1.0.0
     * @author Antonio La Rocca <antonio.larocca@yithemes.it>
     */
    public function add_quicktags() {
        ?>
        <script type="text/javascript">
            if ( window.QTags !== undefined ) {
                QTags.addButton( 'shortcodes', 'add shortcodes', function(){ jQuery('#add_shortcode').click() } );
            }
        </script>
    <?php
    }

    /**
     * Get shortcode icon
     *
     * Search for shortcode icon and return its url
     *
     * @param $shortcode string Shortcode tag
     *
     * @return string
     * @since 1.0.0
     * @author Antonio La Rocca <antonio.larocca@yithemes.it>
     */
    public function shortcode_icon( $shortcode ){
        //Define url and path where to search shortcode icons
        $path_to_child_icon = get_stylesheet_directory()."/theme/assets/images/shortcodes";
        $url_to_child_icon = get_stylesheet_directory_uri()."/theme/assets/images/shortcodes";
        $path_to_icon = ( defined( 'YIT_THEME_PATH' ) ) ? YIT_THEME_PATH."/assets/images/shortcodes" : get_template_directory()."/theme/assets/images/shortcodes";
        $url_to_icon = ( defined( 'YIT_THEME_URL' ) ) ? YIT_THEME_URL."/assets/images/shortcodes" : get_template_directory_uri()."/theme/assets/images/shortcodes";
        $alternative_path_to_icon = get_template_directory()."/shortcodes/assets/images/shortcodes";
        $alternative_url_to_icon = get_template_directory_uri()."/shortcodes/assets/images/shortcodes";

        $return = "";

        if( file_exists( $path_to_child_icon . '/' . $shortcode . '.png' ) ){
            $return = $url_to_child_icon . '/' . $shortcode . '.png';
        }
        elseif( file_exists( $path_to_icon . '/' . $shortcode . '.png' ) ){
            $return = $url_to_icon.'/' . $shortcode . '.png';
        }
        elseif( file_exists( $alternative_path_to_icon . '/' . $shortcode . '.png' ) ){
            $return = $alternative_url_to_icon.'/' . $shortcode . '.png';
        }
        elseif( file_exists( YIT_CORE_ASSETS_PATH . '/images/' . $shortcode . '.png') ){
            $return = $this->shortcodes_assets_url . '/images/' . $shortcode . '.png';
        }else {
            $return = $this->shortcodes_assets_url . '/images/' . 'default-shortcode-icon.png';
        }

        return apply_filters('yit_shortcode_'.$shortcode.'_icon', $return, $shortcode);
    }

    /**
     * Print shortcode code
     *
     * Returns html markup for the shortcode
     *
     * @param $shortcode string Shortcode tag
     *
     * @return string
     * @since 1.0.0
     * @author Antonio La Rocca <antonio.larocca@yithemes.it>
     */
    public function shortcode_print_code( $shortcode ){
        $shortcode_data = $this->shortcodes[ $shortcode ];

        if( isset( $shortcode_data['code'] ) && $shortcode_data['code'] != '' ) {
            return $shortcode_data['code'];
        } else {
            $return = '[' . $shortcode;
            if( !empty( $shortcode_data['attributes'] ) ) {
                foreach( $shortcode_data['attributes'] as $attribute => $data ) {
                    if( isset($data['std']) ) {
                        $return .= ' ' . $attribute . '="' . $data['std'] . '"';
                    } else {
                        $return .= ' ' . $attribute . '=""';
                    }
                }
            }

            $return .= ']';
            if( isset( $shortcode_data['has_content'] ) && $shortcode_data['has_content'] ) {
                $return .= "Your content" . '[/' . $shortcode . ']';
            }

            return $return;
        }
    }

    /**
     * Print shortcode form
     *
     * Return html markup of the edit form for the shortcode
     *
     * @param $shortcode string Shortcode markup
     *
     * @return string
     * @since 1.0.0
     * @author Antonio La Rocca <antonio.larocca@yithemes.it>
     */
    public function shortcode_print_form( $shortcode ){
        $shortcode_data = $this->shortcodes[ $shortcode ];

        if( isset( $shortcode_data['code'] ) && $shortcode_data['code'] != '' ) {
            $return = '<div id="form-' . $shortcode . '" class="yit-shortcodes-form">';
            $return .= '<h3 class="media-title">' . $shortcode_data['title'] . '</h1>';
            $return .= '<p>' . $shortcode_data['description'] . '</p>';
            $return .= '<input name="sc_name" type="hidden" value="' . $shortcode . '" />';

            $return .= $this->shortcode_print_field( 'code', array( $shortcode_data['code'], $shortcode ) );

            $return .= '<div class="fieldset-buttons">
			                <input type="button" class="button-primary" value="' . __('Insert shortcode', 'yit') . '">
			            </div>';
            $return .= '</div>';
            return $return;

        } else {
            $return = '<div id="form-' . $shortcode . '" class="yit-shortcodes-form">';
            $return .= '<h3 class="media-title">' . $shortcode_data['title'] . '</h1>';
            $return .= '<p>' . $shortcode_data['description'] . '</p>';
            $return .= '<input name="sc_name" type="hidden" value="' . $shortcode . '" />';

            if( !empty( $shortcode_data['attributes'] ) ) {
                foreach( $shortcode_data['attributes'] as $attribute=>$data ) {
                    $return .= $this->shortcode_print_type( $attribute, $data, $shortcode );
                }
            }

            if( isset($shortcode_data['has_content']) && $shortcode_data['has_content'] ) {
                $return .= '<label>Your content</label>' . '<textarea name="shortcode-content"></textarea>';
            }

            if( isset($shortcode_data['multiple']) && $shortcode_data['multiple'] ) {
                $return .= '<div class="more-fields"><a class="add-more-fields" href="#">Add more fields</a></div>';
            }

            $return .= '<div class="fieldset-buttons">';
            $return .= '<input type="button" class="button-primary" value="' . __('Insert shortcode', 'yit') . '">';
            $return .= '</div>';
            $return .= '</div>';
            return $return;
        }
    }

    /**
     * Print shortcode field
     *
     * Use @see shortcode_print_field to print fields with the appropriate container
     *
     * @param $attribute array() Shortcode attribute
     * @param $data array() Shortcode data defined in @see shortcodes array
     * @param $shortcode string Shortcode tag
     *
     * @return string
     * @since 1.0.0
     * @author Antonio La Rocca <antonio.larocca@yithemes.it>
     */
    public function shortcode_print_type( $attribute, $data, $shortcode ){
        if ( ! isset( $data['hide'] ) ) :
            $var = array_merge( array( $attribute ), array( $data ), array( $shortcode ) );

            if ( ! isset( $data['multiple'] ) ) :
                return $this->shortcode_print_field( $data['type'], $var );
            else :
                return '<span class="multiple">' . $this->shortcode_print_field( $data['type'], $var ) . '</span>';
            endif;
        endif;
    }

    /**
     * Enqueue frontend scripts
     *
     * @return void
     * @since 1.0.0
     * @author Antonio La Rocca <antonio.larocca@yithemes.it>
     */
    public function enqueue_scripts() {
        global $is_IE;

        if ( ! wp_is_mobile() ) {
            wp_register_script( 'yit-waypoint', $this->shortcodes_assets_url . '/js/waypoints.min.js', array( 'jquery' ), '', true );
            wp_register_script( 'yit-shortcode-easypiechart', $this->shortcodes_assets_url . '/js/jquery.easypiechart.min.js', array( 'jquery' ), '', true );
        }
        wp_register_script( 'yit-shortcodes', $this->shortcodes_assets_url . '/js/yit-shortcodes.min.js', array( 'jquery', 'yit-shortcode-easypiechart'), '', true );
        wp_register_script( 'yit-shortcodes-twitter', $this->shortcodes_assets_url . '/js/twitter.min.js', array( 'jquery'), '', true );
        wp_register_script( 'yit-shortcodes-twitter-text', $this->shortcodes_assets_url . '/js/twitter-text.min.js', array( 'jquery', 'yit-shortcodes-twitter'), '', true );
        if( $is_IE && yit_ie_version() < 10 && yit_ie_version() != -1 ){
            wp_register_script( 'yit-shortcodes-social', $this->shortcodes_assets_url . '/js/yit-social-shortcodes.js', array( 'jquery' ), '', true );
        }

    }

    /**
     * Enqueue frontend scripts
     *
     * @return void
     * @since 1.0.3
     * @author Andrea Frascaspata <andrea.frascaspata@yithemes.it>
     */
    public function yit_shortcode_global_object() {

        $tinymce_yit_shortcodes_icon = function_exists( 'yit_get_option' ) ? yit_get_option( 'admin-logo-menu' ) : '';

        wp_localize_script( 'jquery', 'yit_shortcode', array(
            'tinymce_yit_shortcodes_icon' => $tinymce_yit_shortcodes_icon,
        ));
    }

    /**
     * Add handler to initialize the slider
     *
     * @return void
     * @since 1.0.0
     * @author Antonino Scarfì <antonino.scarfi@yithemes.com>
     */
    public function add_handler_images_slider() {
        static $shown;

        if ( $shown ) return;
        ?>

        <script type="text/javascript">
            (function($){
                "use strict";

                $('.images-slider-sc').each(function(){
                    var slider = $(this),
                        effect = slider.data('effect'),
                        speed = slider.data('speed'),
                        height = slider.data('height'),
                        direction = slider.data('direction');

                    slider.flexslider({
                        animation: effect,
                        directionNav: false,
                        controlNav: false,
                        prevText: '',
                        nextText: '',
                        keyboardNav: false,
                        slideshowSpeed: speed,
                        direction: direction
                    });

                    slider.find('.flex-direction-nav-custom').on( 'click', 'a.flex-prev, a.flex-next', function(){
                        var href = $(this).attr('href');
                        slider.flexslider(href);
                        return false;
                    });

                    slider.find('.flex-viewport, .flex-viewport ul.slides li').height( height );
                });

            })(jQuery);
        </script>

        <?php

        $shown = false;
    }

    /**
     * Print field template
     *
     * Returns a string containing the field markup, with variables inserted
     *
     * @param $field string Field unique tag
     * @param $var array() Variables array to be inserted in the markup
     *
     * @return string
     * @since 1.0.0
     * @author Antonio La Rocca <antonio.larocca@yithemes.it>
     */
    public function shortcode_print_field( $field, $var ){
        $return = "";

        extract( $var );
        ob_start();

        if( file_exists( $this->shortcodes_path . '/templates/admin/fields/' . $field . '.php' ) ){
            include( $this->shortcodes_path . '/templates/admin/fields/' . $field . '.php' );
        }

        $return = ob_get_clean();
        return $return;
    }
}

if( ! function_exists( 'YIT_Shortcodes' ) ) {
    function YIT_Shortcodes() {
        return YIT_Registry::get_instance()->shortcodes;
    }
}