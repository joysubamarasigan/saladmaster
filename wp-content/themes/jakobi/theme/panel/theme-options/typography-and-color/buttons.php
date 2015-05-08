<?php
/**
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

/**
 * Return an array with the options for Theme Options > Typography and Color > Buttons
 *
 * @package Yithemes
 * @author Andrea Grillo <andrea.grillo@yithemes.com>
 * @author Antonio La Rocca <antonio.larocca@yithemes.it>
 * @since 2.0.0
 * @return mixed array
 *
 */
return array(

    /* Typography and Color > Buttons */
    array(
        'type' => 'title',
        'name' => __( 'Buttons Flat', 'yit' ),
        'desc' => '',
    ),

    array(
        'id' => 'button-font',
        'type' => 'typography',
        'name' => __( 'Buttons Typography', 'yit' ),
        'desc' => __( 'Select the font, color and size for buttons text.', 'yit' ),
        'min' => 1,
        'max' => 80,
        'default_font_id' => 'typography-website-paragraph',
        'std'   => array(
            'size'      => 14,
            'unit'      => 'px',
            'family'    => 'default',
            'style'     => '600',
            'color'     => '#ffffff',
            'align'     => 'center',
            'transform' => 'uppercase',
        ),
        'style' => array(
            'selectors'   => '.btn-flat, a.btn-flat,
                              .nav ul > li div div.btn-fb-login a,
                              #welcome-menu-login.nav ul > li #customer_login .button,
                              a.button.view,
                              .banner-image .button,
                              .wishlist_table .button,
                              a.btn.animated.btn-flat:hover,
                              a.bp-title-button,
                              .yit-maintenance-mode form.newsletter input.submit-field',
            'properties'  => 'font-size,
                              font-family,
                              font-weight,
                              color,
                              text-transform,
                              text-align'
        ),
        'in_skin'        => true,
        'disabled' => true
    ),

    array(
        'id' => 'button-hover-color',
        'type' => 'colorpicker',
        'name' => __( 'Buttons color hover', 'yit' ),
        'desc' => __( 'Select a text color hover for the buttons of all pages.', 'yit' ),
        'std'  => array(
            'color' => '#ffffff'
        ),
        'style' => array(
            'selectors'   => '.btn-flat:hover,
                              .nav ul > li div div.btn-fb-login a:hover,
                              a.btn-flat:hover,
                              #welcome-menu-login.nav ul > li #customer_login .button:hover,
                               a.button.view:hover,
                               .yit-maintenance-mode form.newsletter input.submit-field:hover,
                               .call-to-action-two .call-to-action-two-container div.call-btn a.btn-alternative',
            'properties'  => 'color'
        ),
        'in_skin'        => true,
        'disabled' => true
    ),

    array(
        'id' => 'button-background-color',
        'type' => 'colorpicker',
        'variations' => array(
            'normal' => __( 'Background color', 'yit' ),
            'hover' => __( 'Background hover color', 'yit ')
        ),
        'name' => __( 'Buttons background color', 'yit' ),
        'desc' => __( 'Select a color for the buttons background of all pages.', 'yit' ),
        'std'  => array(
			'color' => array(
				'normal' => '#1b8aa5',
				'hover' => '#343535'
			)
		),
        'style' => array(
            'normal' => array(
                'selectors'   => '.btn-flat,
                                   a.btn-flat,
                                   button.button-login,
                                   .nav ul > li div div.btn-fb-login,
                                   .banner-image .button,
                                   #welcome-menu-login.nav ul > li #customer_login .button,
                                   a.btn.animated.btn-flat,
                                   a.btn.animated.btn-flat:hover,
                                  .yit-maintenance-mode form.newsletter input.submit-field,
                                  .call-to-action-two .call-to-action-two-container div.call-btn a.btn-alternative',
                'properties'  => 'background-color, background'
            ),
            'hover' => array(
                'selectors'   => '.btn-flat:hover, 
                                  a.btn-flat:hover, 
                                  .nav ul > li div div.btn-fb-login:hover, 
                                  #welcome-menu-login.nav ul > li #customer_login .button:hover,
                                  a.button.view:hover,
                                  .yit-maintenance-mode form.newsletter input.submit-field:hover,
                                  .call-to-action-two .call-to-action-two-container div.call-btn a.btn-alternative:hover',
                'properties'  => 'background-color, background'
            )
        ),
        'in_skin'        => true,
        'disabled' => true
    ),

    array(
        'id' => 'button-border-color',
        'type' => 'colorpicker',
        'variations' => array(
            'normal' => __( 'Border color', 'yit' ),
            'hover' => __( 'Border hover color', 'yit' )
        ),
        'name' => __( 'Buttons border color', 'yit' ),
        'desc' => __( 'Select a color for the buttons border of all pages.', 'yit' ),
        'std'  => array(
            'color' => array(
                'normal' => '#1b8aa5',
                'hover' => '#343535'
            )
        ),
        'style' => array(
            'normal' => array(
                'selectors'   => '.btn-flat, a.btn-flat, .banner-image .button, .nav ul > li div div.btn-fb-login, a.button.view, .wishlist_table .button, a.btn.animated.btn-flat, a.btn.animated.btn-flat:hover,
                                 a.bp-title-button,
                                 #welcome-menu-login.nav ul > li #customer_login .button,
                                 .yit-maintenance-mode form.newsletter input.submit-field',
                'properties'  => 'border-color'
            ),
            'hover' => array(
                'selectors'   => '.btn-flat:hover, a.btn-flat:hover, .banner-image .button:hover, .nav ul > li div div.btn-fb-login:hover, a.button.view:hover,
                                 .yit-maintenance-mode form.newsletter input.submit-field:hover,
                                 #welcome-menu-login.nav ul > li #customer_login .button:hover',
                'properties'  => 'border-color'
            )
        ),
        'in_skin'        => true,
        'disabled' => true
    ),

    /* ========= Button Alternative =========== */
    array(
        'type' => 'title',
        'name' => __( 'Buttons Alternative', 'yit' ),
        'desc' => '',
    ),

    array(
        'id' => 'button-font-alternative',
        'type' => 'typography',
        'name' => __( 'Buttons Typography', 'yit' ),
        'desc' => __( 'Select the font, color and size for buttons text.', 'yit' ),
        'min' => 1,
        'max' => 80,
        'default_font_id' => 'typography-website-paragraph',
        'std'   => array(
            'size'      => 14,
            'unit'      => 'px',
            'family'    => 'default',
            'style'     => '600',
            'color'     => '#343535',
            'align'     => 'center',
            'transform' => 'uppercase',
        ),
        'style' => array(
            'selectors'   => '.btn.btn-alternative,
                              a.btn.btn-alternative,
                              #welcome-menu-login.nav ul > li #customer_login .button.button-register,
                              #submit,
                              .button,
                              a.btn.animated.btn-alternative:hover,
                              #comments ol li .information .user-info .is_author',
            'properties'  => 'font-size,
                              font-family,
                              font-weight,
                              color,
                              text-transform,
                              text-align'
        ),
        'in_skin'        => true,
        'disabled' => true
    ),

    array(
        'id' => 'button-hover-color-alternative',
        'type' => 'colorpicker',
        'name' => __( 'Buttons color hover', 'yit' ),
        'desc' => __( 'Select a text color hover for the buttons of all pages.', 'yit' ),
        'std'  => array(
            'color' => '#ffffff'
        ),
        'style' => array(
            'selectors'   => '.btn-alternative:hover,
                              a.btn-alternative:hover,
                              #welcome-menu-login.nav ul > li #customer_login .button.button-register:hover,
                              #submit:hover, 
                              .button:hover',
            'properties'  => 'color'
        ),
        'in_skin'        => true,
        'disabled' => true
    ),

    array(
        'id' => 'button-background-color-alternative',
        'type' => 'colorpicker',
        'variations' => array(
            'normal' => __( 'Background color', 'yit' ),
            'hover' => __( 'Background hover color', 'yit ')
        ),
        'linked_to' => array(
            'normal' => 'theme-color-1'
        ),
        'name' => __( 'Buttons background color', 'yit' ),
        'desc' => __( 'Select a color for the buttons background of all pages.', 'yit' ),
        'in_skin'        => true,
        'std'  => array(
			'color' => array(
				'normal' => 'transparent',
				'hover' => '#343535'
			)
		),
        'style' => array(
            'normal' => array(
                'selectors'   => '.btn-alternative,
                                  a.btn-alternative,
                                  #welcome-menu-login.nav ul > li #customer_login .button.button-register,
                                  #submit, .button,
                                  .button.submit-field,
                                  a.btn.animated.btn-alternative:hover,
                                  #comments ol li .information .user-info .is_author',
                'properties'  => 'background-color, background'
            ),
            'hover' => array(
                'selectors'   => '.btn-alternative:hover,
                                  a.btn-alternative:hover,
                                  #welcome-menu-login.nav ul > li #customer_login .button.button-register:hover,
                                  #submit:hover,
                                  .button:hover,
                                  .button.submit-field:hover,
                                  #yith-searchsubmit:hover',
                'properties'  => 'background-color, background'
            )
        ),
        'disabled' => true
    ),

    array(
        'id' => 'button-border-color-alternative',
        'type' => 'colorpicker',
        'variations' => array(
            'normal' => __( 'Border color', 'yit' ),
            'hover' => __( 'Border hover color', 'yit' )
        ),
        'linked_to' => array(
            'normal' => 'theme-color-2'
        ),
        'in_skin'        => true,
        'name' => __( 'Buttons border color', 'yit' ),
        'desc' => __( 'Select a color for the buttons border of all pages.', 'yit' ),
        'std'  => array(
            'color' => array(
                'normal' => '#343535',
                'hover' => '#343535'
            )
        ),
        'style' => array(
            'normal' => array(
                'selectors'   => '.btn-alternative,
                                  a.btn-alternative,
                                  #welcome-menu-login.nav ul > li #customer_login .button.button-register,
                                  #submit,
                                  .button,
                                  a.btn.animated.btn-alternative:hover',
                'properties'  => 'border-color'
            ),
            'hover' => array(
                'selectors'   => '.btn-alternative:hover,
                                 a.btn-alternative:hover,
                                 #welcome-menu-login.nav ul > li #customer_login .button.button-register:hover,
                                 #submit:hover,
                                 .button:hover',
                'properties'  => 'border-color'
            )
        ),
        'disabled' => true
    )
);