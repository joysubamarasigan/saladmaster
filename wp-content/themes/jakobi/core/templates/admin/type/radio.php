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
 * Radio Button Admin View
 *
 * @package	Yithemes
 * @author Antonino Scarfi' <antonino.scarfi@yithemes.com>
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<div id="<?php echo $id ?>-container" <?php if( isset($deps) ): ?>data-field="<?php echo $deps['field'] ?>" data-dep="<?php echo $deps['dep'] ?>" data-value="<?php echo $deps['value'] ?>" <?php endif ?>class="<?php echo isset( $disabled ) && 'yes' == $disabled ? 'disabled ' : '' ?>yit_options rm_option rm_input rm_radio">
    <div class="option">
        <label for="<?php echo $id ?>"><?php echo $name ?></label>

        <div class="rm_radio">
            <?php foreach ( $options as $val => $option ) { ?>
                <label class="radio-inline">
                    <input type="radio" class="radio" name="<?php yit_field_name( $id ); ?>" id="<?php echo $id . '-' . $val ?>" value="<?php echo $val ?>" <?php checked( yit_get_option( $id ), $val ) ?> /> <?php echo $option ?>
                </label>
            <?php } ?>
        </div>
    </div>
    <div class="description"><?php echo $desc ?></div>
    <div class="clear"></div>
</div>
