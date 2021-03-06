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
 * Return an array with the options for Theme Options > Typography and Color > Content
 *
 * @package Yithemes
 * @author  Andrea Grillo <andrea.grillo@yithemes.com>
 * @author  Antonio La Rocca <antonio.larocca@yithemes.it>
 * @since   2.0.0
 * @return mixed array
 *
 */
return array(

    /* Typography and Color > Content > 404 Page */
    array(
        'type' => 'title',
        'name' => __( '404 Page', 'yit' ),
        'desc' => '',
    ),

    array(
        'id'              => 'content-not-found-general-font',
        'type'            => 'typography',
        'name'            => __( 'Custom 404 page general font', 'yit' ),
        'desc'            => __( 'Choose the font type, size and color.', 'yit' ),
        'min'             => 1,
        'max'             => 80,
        'default_font_id' => 'typography-website-paragraph',
        'std'             => array(
            'size'      => 16,
            'unit'      => 'px',
            'family'    => 'default',
            'style'     => 'regular',
            'color'     => '#555555',
            'align'     => 'center',
            'transform' => 'none',
        ),
        'style'           => array(
            'selectors'  => '.error-404-text p',
            'properties' => 'font-size,
                              font-family,
                              font-weight,
                              color,
                              text-transform,
                              text-align'
        ),
        'in_skin'        => true,
        'disabled' => true
    ),

    /* Typography and Color > Content > Blog */
    array(
        'type' => 'title',
        'name' => __( 'Blog', 'yit' ),
        'desc' => '',
    ),

    array(
        'id'              => 'content-blog-small-title-font',
        'type'            => 'typography',
        'name'            => __( 'Blog page title font', 'yit' ),
        'desc'            => __( 'Choose the font type, size, text transform and align.', 'yit' ),
        'min'             => 1,
        'max'             => 80,
        'default_font_id' => 'typography-website-title',
        'std'             => array(
            'size'      => 18,
            'unit'      => 'px',
            'family'    => 'default',
            'style'     => '700',
            'align'     => 'left',
            'transform' => 'uppercase',
        ),
        'style'           => array(
            'selectors'  => '.blog.small h1.post-title a, .blog.small h2.post-title a',
            'properties' => 'font-size,
                             font-family,
                             font-weight,
                             text-transform,
                             text-align'
        ),
        'in_skin'        => true,
        'disabled' => true
    ),

    array(
        'id'         => 'content-blog-title-link-color',
        'type'       => 'colorpicker',
        'variations' => array(
            'normal' => __( 'Title Color', 'yit' ),
            'hover'  => __( 'Title Color Hover', 'yit' )
        ),
        'linked_to'  => array(
            'hover' => 'theme-color-2'
        ),
        'in_skin'        => true,
        'name'       => __( 'Title Color', 'yit' ),
        'desc'       => __( 'Select the colors to use for the links title in normal state and on hover.', 'yit' ),
        'std'        => array(
            'color' => array(
                'normal' => '#000000',
                'hover'  => '#1b8aa5'
            )
        ),
        'style'      => array(
            'normal' => array(
                'selectors'  => '
                                 .blog.small h1.post-title a, .blog.small h2.post-title a,
                                 .blog h1.quote-title a, .blog h2.quote-title a,
                                 .blog_section.post_meta .title a',
                'properties' => 'color'
            ),
            'hover'  => array(
                'selectors'  => '
                                 .blog.small h2.post-title a:hover,
                                 .blog h2.quote-title a:hover,
                                 .blog_section.post_meta .title a:hover',
                'properties' => 'color'
            )
        ),
        'disabled' => true
    ),


    array(
        'id'              => 'content-blog-small-meta-font',
        'type'            => 'typography',
        'name'            => __( 'Meta info box for small layout', 'yit' ),
        'desc'            => __( 'Choose the font type, size and color for meta info box on small layout.', 'yit' ),
        'min'             => 1,
        'max'             => 80,
        'default_font_id' => 'typography-website-title',
        'std'             => array(
            'size'      => 12,
            'unit'      => 'px',
            'family'    => 'default',
            'style'     => 'regular',
            'color'     => '#555555',
            'align'     => 'left',
            'transform' => 'none',
        ),
        'style'           => array(
            'selectors'  => '.blog.small .yit_post_meta',
            'properties' => 'font-size,
                              font-family,
                              font-family,
                              font-weight,
                              color,
                              text-align,
                              text-transform'
        ),
        'in_skin'        => true,
        'disabled' => true
    ),

    array(
        'id'         => 'content-blog-meta-link-hover-color',
        'type'       => 'colorpicker',
        'variations' => array(
            'normal' => __( 'Meta Link', 'yit' ),
            'hover'  => __( 'Meta Link Hover', 'yit' )
        ),
        'linked_to'  => array(
            'hover' => 'theme-color-2'
        ),
        'in_skin'        => true,
        'name'       => __( 'Meta Links', 'yit' ),
        'desc'       => __( 'Select the colors to use for the links in normal state and on hover.', 'yit' ),
        'std'        => array(
            'color' => array(
                'normal' => '#555555',
                'hover'  => '#1b8aa5'
            )
        ),
        'style'      => array(
            'normal' => array(
                'selectors'  => '.single-post .blog .share .socials-text a,
                                 .blog.small .yit_post_meta a, .blog.small .yit_post_meta a:visited,
                                 .blog_section.post_meta .info, .blog_section.post_meta .info a,div.socials a',
                'properties' => 'color'
            ),
            'hover'  => array(
                'selectors'  => '.single-post .blog .share .socials-text a:hover, .single-post .blog .share .share-text:hover,
                                 .blog.small .yit_post_meta a:hover, .blog.small .yit_post_meta a:active,
                                 .blog_section.post_meta .info a:active, .blog_section.post_meta .info a:hover,div.socials a:hover, span.share-text:hover',
                'properties' => 'color'
            )
        ),
        'disabled' => true
    ),

    /* Typography and Color > Content > Comments */
    array(
        'type' => 'title',
        'name' => __( 'Comments', 'yit' ),
        'desc' => '',
    ),

    array(
        'id'              => 'content-comments-font',
        'type'            => 'typography',
        'name'            => __( 'Comments Link font', 'yit' ),
        'desc'            => __( 'the font type, size, text transform and align.', 'yit' ),
        'min'             => 1,
        'max'             => 80,
        'default_font_id' => 'typography-website-title',
        'std'             => array(
            'size'      => 14,
            'unit'      => 'px',
            'family'    => 'default',
            'style'     => 'regular',
            'transform' => 'uppercase',
            'color'     => '#555555'
        ),
        'style'           => array(
            'selectors'  => '.reply_link, .comment-reply-link, #commentform .logged-in-as a, .comment-navigation .nav-previous a, .comment-navigation .nav-next a',
            'properties' => 'font-size,
                             font-family,
                             font-weight,
                             text-transform,
                             color'
        ),
        'in_skin'        => true,
        'disabled' => true
    ),

    /* Typography and Color > Content > Pagination */
    array(
        'type' => 'title',
        'name' => __( 'Pagination', 'yit' ),
        'desc' => '',
    ),

    array(
        'id'              => 'content-pagination-font',
        'type'            => 'typography',
        'name'            => __( 'Pagination font', 'yit' ),
        'desc'            => __( 'the font type, size, text transform and align.', 'yit' ),
        'min'             => 1,
        'max'             => 80,
        'default_font_id' => 'typography-website-title',
        'std'             => array(
            'size'   => 18,
            'unit'   => 'px',
            'family' => 'default',
            'style'  => 'regular',
            'align'  => 'center',
        ),
        'style'           => array(
            'selectors'  => '.general-pagination',
            'properties' => 'font-size,
                             font-family,
                             font-weight,
                             text-align'
        ),
        'in_skin'        => true,
        'disabled' => true
    ),

    array(
        'id'         => 'content-pagination-text-color',
        'type'       => 'colorpicker',
        'variations' => array(
            'normal'   => __( 'Normal Color', 'yit' ),
            'hover'    => __( 'Hover Color', 'yit' ),
            'selected' => __( 'Selected Color', 'yit' )
        ),
        'name'       => __( 'Pagination Number Color', 'yit' ),
        'desc'       => __( 'Select the colors to use for the pagination links.', 'yit' ),
        'std'        => array(
            'color' => array(
                'normal'   => '#555555',
                'hover'    => '#4caac1',
                'selected' => '#555555',
            )
        ),
        'linked_to'  => array(
            'hover' => 'theme-color-1',
        ),
        'in_skin'        => true,
        'style'      => array(
            'normal'   => array(
                'selectors'  => '.general-pagination a',
                'properties' => 'color'
            ),
            'hover'    => array(
                'selectors'  => '.general-pagination a:hover, #commentform .logged-in-as a:hover, .comment-navigation .nav-previous a:hover, .comment-navigation .nav-next a:hover',
                'properties' => 'color'
            ),
            'selected' => array(
                'selectors'  => '.general-pagination a.selected, .general-pagination a:hover.selected',
                'properties' => 'color'
            )
        ),
        'disabled' => true
    ),

    array(
        'id'         => 'content-pagination-background-color',
        'type'       => 'colorpicker',
        'variations' => array(
            'normal'   => __( 'Normal Color', 'yit' ),
            'hover'    => __( 'Hover Color', 'yit' ),
            'selected' => __( 'Selected Color', 'yit' )
        ),
        'name'       => __( 'Pagination Background Color', 'yit' ),
        'desc'       => __( 'Select the colors to use for the pagination links.', 'yit' ),
        'std'        => array(
            'color' => array(
                'normal'   => '#ffffff',
                'hover'    => '#ffffff',
                'selected' => '#ffffff',
            )
        ),
        'style'      => array(
            'normal'   => array(
                'selectors'  => '.general-pagination a',
                'properties' => 'background-color'
            ),
            'hover'    => array(
                'selectors'  => '.general-pagination a:hover',
                'properties' => 'background-color'
            ),
            'selected' => array(
                'selectors'  => '.general-pagination a.selected',
                'properties' => 'background-color'
            )
        ),
        'in_skin'        => true,
        'disabled' => true
    ),


);

