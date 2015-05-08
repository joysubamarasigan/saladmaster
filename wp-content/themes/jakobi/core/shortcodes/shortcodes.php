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
 * Return the list of shortcode and their settings
 *
 * @package Yithemes
 * @author Francesco Licandro  <francesco.licandro@yithemes.com>
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

include( $this->shortcodes_path.'/functions.php');

$button_style = get_button_style();
$awesome_icons = YIT_Plugin_Common::get_awesome_icons();
$awesome_icons_socials = YIT_Plugin_Common::get_awesome_icons_socials();
$null = array( '' =>__('None', 'yit') );
$awesome_icons_with_null = array_merge($null, $awesome_icons);
$categories = yit_get_categories( true );
$set_icons = get_set_icons();
$animate = yit_get_animate_effects();

$icon_list = array (
    'theme-icon' => __('Theme Icon', 'yit'),
    'custom' => __('Custom Icon', 'yit')
);

return array(

    /* === ICON === */
    'icon' => array(
        'title' => __('Icon', 'yit' ),
        'description' =>  __('Shows an icon', 'yit' ),
        'tab' => 'shortcodes',
        'has_content' => false,
        'in_visual_composer' => true,
        'attributes' => array(

            'icon_type' => array(
                'title' => __('Icon type', 'yit'),
                'type'  => 'select',
                'options' => array(
                    'theme-icon' => __('Theme Icon', 'yit'),
                    'custom' => __('Custom Icon', 'yit')
                ),
                'std' => 'theme-icon'
            ),

            'icon_theme' => array(
                'title' => __('Icon', 'yit'),
                'type' => 'icon-list',
                'deps' => array(
                    'ids' => 'icon_type',
                    'values' => 'theme-icon'
                ),
                'std' => ''
            ),

            'icon_url' =>  array(
                'title' => __('Icon URL', 'yit'),
                'type' => 'text',
                'std'  => '',
                'deps' => array(
                    'ids' => 'icon_type',
                    'values' => 'custom'
                )
            ),
            'icon_size' => array(
                'title' => __('Icon size', 'yit'),
                'type' => 'number',
                'min' => '9',
                'max' => '90',
                'std'  => '14',
                'deps' => array(
                    'ids' => 'icon_type',
                    'values' => 'theme-icon'
                )
            ),
            'color' => array(
                'title' => __('Color', 'yit'),
                'type' => 'colorpicker',
                'std'  => '#797979',
                'deps' => array(
                    'ids' => 'icon_type',
                    'values' => 'theme-icon'
                )
            ),
            'circle' => array(
                'title' => __('Circle', 'yit'),
                'type'  => 'select',
                'options' => array(
                    'yes' => __('Yes', 'yit'),
                    'no' => __('No', 'yit')
                ),
                'std' => 'no',
                'deps' => array(
                    'ids' => 'icon_type',
                    'values' => 'theme-icon'
                )
            ),

            'circle_size' => array(
                'title' => __('Circle Size', 'yit'),
                'type'  => 'number',
                'std' => '35',
                'deps' => array(
                    'ids' => 'circle',
                    'values' => 'yes'
                )

            ),


        )
    ),

    /* === PRINT BORDER === */
    'border' => array(
        'title' => __('Print border line', 'yit' ),
        'description' =>  __('Print a border', 'yit' ),
        'tab' => 'shortcodes',
        'has_content' => false,
        'in_visual_composer' => true,
        'attributes' => array(
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

    /* === TWITTER === */
    'twitter' => array(
        'title' => __('Twitter', 'yit' ),
        'description' =>  __('Print a list of last tweets', 'yit' ),
        'tab' => 'shortcodes',
        'has_content' => false,
        'in_visual_composer' => true,
        'attributes' => array(
            'username' => array(
                'title' => __('Username', 'yit'),
                'type' => 'text',
                'std'  => ''
            ),
            'consumer_key' => array(
                'title' => __('Consumer Key', 'yit'),
                'type' => 'text',
                'std'  => ''
            ),
            'consumer_secret' => array(
                'title' => __('Consumer Secret', 'yit'),
                'type' => 'text',
                'std'  => ''
            ),
            'access_token' => array(
                'title' => __('Access Token', 'yit'),
                'type' => 'text',
                'std'  => ''
            ),
            'access_token_secret' => array(
                'title' => __('Access Token Secret', 'yit'),
                'type' => 'text',
                'std'  => ''
            ),
            'items' => array(
                'title' => __('N. of items', 'yit'),
                'type' => 'number',
                'std'  => '5'
            ),
            'class' => array(
                'title' => __('CSS class', 'yit'),
                'type' => 'text',
                'std'  => 'last-tweets-widget'
            ),
            'time' => array(
                'title' => __('Time', 'yit'),
                'type' => 'checkbox',
                'std'  => 'yes'
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

    /* === Accordion === */
    'accordion' => array(
        'title' => __('Accordion', 'yit' ),
        'description' =>  __('Create a accordion content', 'yit' ),
        'tab' => 'shortcodes',
        'has_content' => true,
        'in_visual_composer' => true,
        'attributes' => array(
            'title' => array(
                'title' => __('Title', 'yit'),
                'type' => 'text',
                'std'  => 'your_title'
            ),
            'opened' => array(
                'title' => __('Opened', 'yit'),
                'type' => 'checkbox',
                'std'  => 'no'
            ),
            'class_icon_closed' => array(
                'title' => __('Class Icon Closed', 'yit'),
                'type' => 'select-icon',
                'options' => $awesome_icons,
                'std'  => 'plus'
            ),
            'class_icon_opened' => array(
                'title' => __('Class Icon Opened', 'yit'),
                'type' => 'select-icon',
                'options' => $awesome_icons,
                'std'  => 'minus'
            ),
            'border' => array(
                'title' => __( 'Border', 'yit' ),
                'type' => 'select', // true|false
                'options' => array(
                    'true' => __('Yes', 'yit'),
                    'false' => __('No', 'yit')
                ),
                'std'  => 'true'
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

    /* === SIZE OF TEXT* === */
    'size' => array(
        'title' => __('Size of text', 'yit' ),
        'description' =>  __('Select a size of text', 'yit' ),
        'tab' => 'shortcodes',
        'has_content' => true,
        'attributes' => array(
            'px' => array (
                'title' => __('Pixel', 'yit'),
                'type' => 'number',
                'std'  => ''
            ),
            'perc' => array (
                'title' => __('Percent', 'yit'),
                'type' => 'number',
                'std'  => ''
            ),
            'em' => array (
                'title' => __('Em', 'yit'),
                'type' => 'number',
                'std'  => ''
            )
        )
    ),

    /* == PRINT CLEAR === */
    'clear' => array(
        'title' => __('Print clear', 'yit' ),
        'description' =>  __('Print a clear, to undo the floating', 'yit' ),
        'tab' => 'shortcodes',
        'in_visual_composer' => true,
        'has_content' => false,
        'attributes' => array(
        )
    ),

    /* === LOGGED USER === */
    'logged_user' => array(
        'title' => __( 'Logged user', 'yit' ),
        'description' => __( 'Show the username of the logged user with some option text before or after.', 'yit' ),
        'tab' => 'shortcodes',
        'has_content' => false,
        'in_visual_composer' => true,
        'attributes' => array(
            'before' => array(
                'title' => __( 'Text before username', 'yit' ),
                'description' => __( 'HTML allowed.', 'yit' ),
                'type' => 'text',
                'std' => 'Hello '
            ),
            'after' => array(
                'title' => __( 'Text after username', 'yit' ),
                'description' => __( 'HTML allowed.', 'yit' ),
                'type' => 'text',
                'std' => ''
            ),
            'display' => array(
                'title' => __( 'Display', 'yit' ),
                'type' => 'select',
                'options' => array(
                    'user_login' => __( 'Login', 'yit' ),
                    'user_email' => __( 'Email', 'yit' ),
                    'user_firstname' => __( 'First name', 'yit' ),
                    'user_lastname' => __( 'Last name', 'yit' ),
                    'first_last' => __( 'First and Last name', 'yit' ),
                    'last_first' => __( 'Last and First name', 'yit' ),
                    'display_name' => __( 'Display name', 'yit' ),
                    'ID' => __( 'ID', 'yit' )
                ),
                'std' => 'display_name'
            )
        )
    ),

    /* === LIST BULLET === */
    'list_bullet' => array(
        'title' => __('List bullet', 'yit' ),
        'description' =>  __('Show a list with bullet', 'yit' ),
        'tab' => 'shortcodes',
        'has_content' => true,
        'in_visual_composer' => true,
        'attributes' => array(
            'icon' => array(
                'title' => __('Type of bullet', 'yit'),
                'type' => 'select-icon', // star|arrow|check|add|info
                'options' => $awesome_icons_with_null,
                'std'  => 'star'
            ),
            'icon_color' => array(
                'title' => __('Icon color', 'yit'),
                'type' => 'colorpicker',
                'std' => '#B4B4B4'
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

    /* === HIGHLIGHT === */
    'highlight' => array(
        'title' => __('Highlight', 'yit' ),
        'description' =>  __('Text highlight', 'yit' ),
        'tab' => 'shortcodes',
        'has_content' => true,
        'in_visual_composer' => false,
        'attributes' => array(
            'text_color' => array(
                'title' => __('Text color', 'yit'),
                'type' => 'colorpicker',
                'std' => '#000'
            ),
            'background_color' => array(
                'title' => __('Text color', 'yit'),
                'type' => 'colorpicker',
                'std' => '#f7c104'
            )
        )
    ),

    /* === DROPCAP === */
    'dropcap' => array(
        'title' => __('Dropcap', 'yit' ),
        'description' =>  __('Format content, with big first letter', 'yit' ),
        'tab' => 'shortcodes',
        'has_content' => true,
        'in_visual_composer' => false,
        'attributes' => array(
        )
    ),

    /* === BOX TITLE === */
    'box_title' => array(
        'title' => __('Box title', 'yit' ),
        'description' =>  __('Show a title centered with line', 'yit' ),
        'tab' => 'shortcodes',
        'in_visual_composer' => true,
        'has_content' => true,
        'attributes' => array(
            'class' => array(
                'title' => __('Class', 'yit'),
                'type' => 'text',
                'std'  => ''
            ),
            'subtitle' => array(
                'title' => __( 'Subtitle', 'yit' ),
                'type' => 'text',
                'std' => ''
            ),

            'subtitle_font_size' => array(
                'title' => __( 'Subtitle Font size (px)', 'yit' ),
                'type' => 'text',
                'min' => 1,
                'max' => 99,
                'std' => 15
            ),
            'font_size' => array(
                'title' => __( 'Title Font size (px)', 'yit' ),
                'type' => 'number',
                'min' => 1,
                'max' => 99,
                'std' => 15
            ),
            'font_alignment' => array(
                'title' => __( 'Font alignment', 'yit' ),
                'type' => 'select',
                'options' => array(
                    'left' => __( 'Left', 'yit' ),
                    'right' => __( 'Right', 'yit' ),
                    'center' => __( 'Center', 'yit' )
                ),
                'std' => 'center'
            ),
            'border' => array(
                'title' => __('Border', 'yit'),
                'type' => 'select',
                'options' => array(
                    'bottom' => __('Bottom', 'yit'),
                    'middle' => __('Middle', 'yit'),
                    'around' => __('Around', 'yit'),
                    'none' => __('none', 'yit')
                ),
                'std'  => 'middle'
            ),
            'border_color' => array(
                'title' => __('Border Color', 'yit'),
                'type' => 'colorpicker',
                'std'  => '#CDCDCD'
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
            )        )
    ),

    /* === BUTTON === */
    'button' => array(
        'title' => __('Button', 'yit' ),
        'description' =>  __('Show a simple custom button', 'yit' ),
        'tab' => 'shortcodes',
        'has_content' => true,
        'in_visual_composer' => true,
        'attributes' => array(

            'href' => array(
                'title' => __('URL', 'yit'),
                'type' => 'text',
                'std'  => '#'
            ),
            'target' => array(
                'title' => __('Target', 'yit'),
                'type' => 'select',
                'options' => array(
                    '' => __('Default', 'yit'),
                    '_blank' => __('Blank', 'yit'),
                    '_parent' => __('Parent', 'yit'),
                    '_top' => __('Top', 'yit')
                ),
                'std'  => ''
            ),
            'color' => array(
                'title' => __('Color', 'yit'),
                'description' => __( 'You can find the buttons list', 'yit' ),
                'type' => 'select', // btn-view-over-the-town-1|btn-the-bizzniss-1|btn-french-1|ecc
                'options' => apply_filters( 'yit_button_style' , '' ),//apply_filters( 'yit_button_style' , $button_style ),
                'std'  => 'flat'
            ),
            'dimension' => array(
                'title' => __('Width', 'yit'),
                'type' => 'select',  // large|normal|small|mini
                'options' => array(
                    'large' => __('Large', 'yit'),
                    'normal' => __('Normal', 'yit'),
                    'small' => __('Small', 'yit'),
                    'mini' => __('Mini', 'yit')
                ),
                'std'  => 'normal',
            ),

            'icon' => array(

                'title' => __('Icon', 'yit'),
                'type' => 'select-icon',  // home|file|time|ecc
                'options' => $awesome_icons_with_null,
                'std'  => ''
            ),
            'icon_size' => array(
                'title' => __('Icon size', 'yit'),
                'type' => 'number',
                'std'  => '12'
            ),
            'animation' => array(
                'title' => __('Icon Animation', 'yit'),
                'type' => 'select',
                'options' => array(
                    '' => __('None', 'yit'),
                    'RtL' => __('Right to Left', 'yit'),
                    'LtR' => __('Left to Right', 'yit'),
                    'CtL' => __('Center to Left', 'yit'),
                    'CtR' => __('Center to Right', 'yit'),
                    'UtC' => __('Up to Center', 'yit'),
                    'LtC' => __('Left to Center', 'yit'),
                    'RtC' => __('Right to Center', 'yit'),
                ),
                'std'  => ''
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
            ),
            'class' => array(
                'title' => __('CSS class', 'yit'),
                'type' => 'text',
                'std'  => ''
            )
        ),
    ),

    /* === ADD SPACE* === */
    'space' => array(
        'title' => __('Add space', 'yit' ),
        'description' =>  __('Print a space', 'yit' ),
        'tab' => 'shortcodes',
        'has_content' => false,
        'in_visual_composer' => true,
        'attributes' => array(
            'height' => array(
                'title' => 'Height of space box in px',
                'type' => 'number',
                'min' => 0,
                'max' => 999,
                'std' => 30
            )
        )
    ),

);