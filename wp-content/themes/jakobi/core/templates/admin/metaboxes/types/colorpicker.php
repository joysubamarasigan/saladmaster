<?php
/**
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'YIT' ) ) {
    exit( 'Direct access forbidden.' );
}


extract( $args );
?>
<label for="<?php echo $id ?>"><?php echo $label ?></label>

<input type="text" name="<?php echo $name ?>" id="<?php echo $id ?>" value="<?php echo $value ?>" <?php if( isset( $std ) ) : ?>data-default-color="<?php echo $std ?>"<?php endif ?> class="panel-colorpicker"/>
<span class="desc inline"><?php echo $desc ?></span>
