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
 * Template file for show a list with bullet
 *
 * @package Yithemes
 * @author  Francesco Licandro <francesco.licandro@yithemes.com>
 * @since   1.0.0
 */

$content = str_replace( '<ul>', '', $content );
$content = str_replace( '</ul>', '', $content );

$code = YIT_Plugin_Common::get_awesome_icons_code_by_value( $icon );

$id_link = "list_bullet" . $index;
$animate = ( $animate != '' ) ? ' yit_animate ' . $animate : '';
$delay = ( $animation_delay != '' ) ? 'data-delay="' . $animation_delay . '"' : '';
?>

<?php if ( isset( $code ) && $code ): ?>
    <style>
        ul#<?php echo $id_link?> li:before {
            content: '\<?php echo $code;?>';
            color: <?php echo $icon_color ?>;
        }
    </style>
<?php endif; ?>

<ul class="short <?php echo $icon . $animate; ?>" <?php echo $delay ?> id="<?php echo $id_link; ?>"><?php echo do_shortcode( $content ); ?></ul>