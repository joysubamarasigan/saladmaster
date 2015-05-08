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
 * Return an array with the options for Theme Options > Footer > Settings
 *
 * @package Yithemes
 * @author Andrea Grillo <andrea.grillo@yithemes.com>
 * @author Antonio La Rocca <antonio.larocca@yithemes.it>
 * @since 2.0.0
 * @return mixed array
 *
 */
return array(

    /* Footer > Settings */
    array(
        'type' => 'title',
        'name' => __( 'Footer Settings', 'yit' ),
        'desc' => ''
    ),

    array(
        'id' => 'footer-type',
        'type' => 'select',
        'options' => array(
            'normal' => __( 'Two Columns Copyright', 'yit' ),
            'centered' => __( 'Centered Copyright', 'yit' )
        ),
        'name' => __( 'Footer type', 'yit' ),
        'desc' => __( 'Select the footer layout for the theme.', 'yit' ),
        'std' => 'centered',
        'in_skin'        => true
    ),

    array(
        'id' => 'footer-left-text',
        'type' => 'textarea',
        'name' => __( 'Footer copyright text Left', 'yit' ),
        'desc' => __( 'Enter text used in the left side of the footer. It can be HTML. NB: not figured on "centered footer"', 'yit' ),
        'std' => 'copyright 2014 - Jakobi free theme by'.' <a href="#">Yithemes</a>',
        'deps' => array(
            'ids' => 'footer-type',
            'values' => 'normal'
        )
    ),

    array(
        'id' => 'footer-center-text',
        'type' => 'textarea',
        'name' => __( 'Footer centered text', 'yit' ),
        'desc' => __( 'Enter text used in centered footer. It can be HTML.', 'yit' ),
        'std' => 'copyright '. date('Y').' - Jakobi theme by  <a href="#">Yithemes<a>',
        'deps' => array(
            'ids' => 'footer-type',
            'values' => 'centered'
        )
    ),

    array(
        'id' => 'footer-right-text',
        'type' => 'textarea',
        'name' => __( 'Footer copyright text Right', 'yit' ),
        'desc' => __( 'Enter text used in the right side of the footer. It can be HTML. NB: not figured on "centered footer"', 'yit' ),
        'std' => '',
        'deps' => array(
            'ids' => 'footer-type',
            'values' => 'normal'
        )
    ),




);

