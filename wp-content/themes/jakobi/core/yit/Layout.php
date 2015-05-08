<?php
/**
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'YIT' ) ) exit; // Exit if accessed directly

require_once( YIT_CORE_PATH. '/lib/yit/layout/module/yit-layout-module.php' );
require_once( YIT_CORE_PATH. '/lib/yit/layout/module/yit-layout-module-post_type.php' );
require_once( YIT_CORE_PATH. '/lib/yit/layout/module/yit-layout-module-taxonomy.php' );
require_once( YIT_CORE_PATH. '/lib/yit/layout/module/yit-layout-module-author.php' );
require_once( YIT_CORE_PATH. '/lib/yit/layout/module/yit-layout-module-static.php' );
require_once( YIT_CORE_PATH. '/lib/yit/layout/module/yit-layout-module-site.php' );
require_once( YIT_CORE_PATH. '/lib/yit/layout/panel/yit-layout-panel.php' );
require_once( YIT_CORE_PATH. '/lib/yit/layout/yit-layout-options.php' );

/**
 * YIT Layout
 *
 * Manage Layout Panel in the YIT Framework
 *
 * @class      YIT_Layout
 * @package    Yitheme
 * @since      2.0
 * @author     Your Inspiration Themes
 */

class YIT_Layout {


    /**
     * @var object The single instance of the class
     * @since 1.0
     */
    protected static $_instance = null;

    /**
     * @var object The instance of the panel
     * @since 1.0
     */
    protected $_panel = null;


    private $prefix = 'yit_lp_';
    /**
     * Main plugin Instance
     *
     * @static
     * @return object Main instance
     *
     * @since  1.0
     * @author Antonino Scarfi' <antonino.scarfi@yithemes.com>
     */
    public static function instance() {
        if ( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Constructor
     *
     * @since  1.0
     * @author Emanuela Castorina <emanuela.castorina@yithemes.it>
     */
    public function __construct() {

        // load the core plugins library from an yit-theme

        add_action( 'after_setup_theme', array( $this, 'activate' ) );

    }


    /**
     * Magic method to get value from db, for the current page
     *
     * @use \YIT_Layout_Options\get_option
     *
     * @param $var string The name of variable to get from database
     *
     * @return mixed
     * @since  1.0
     * @author Antonino Scarfi' <antonino.scarfi@yithemes.com>
     */
    public function __get( $var ) {
        return YIT_Layout_Options()->get_option( $var );
    }

    /**
     * Magic method to get value from db, for the current page
     *
     * @use \YIT_Layout_Options\get_option
     *
     * @param string $key   the id of the otpion can be an interger or a string "all","404", "front-page"
     * @param bool   $id    is the id of the page/post/category/taxonomy/format/static page/author
     * @param string $type  is the type of the page/post/category/post_tag/author/
     * @param string $model can be taxonomy, post_type, static, author, site
     *
     * @return mixed
     * @since  1.0
     * @author Antonino Scarfi' <antonino.scarfi@yithemes.com>
     */
    public function get( $key, $id = false, $type = "post", $model = "post_type" ) {
        return YIT_Layout_Options()->get_option( $key, $id, $type, $model );
    }


    /**
     * Yit Layout Panel
     *
     * print HTML code to layout panel
     *
     * @return   void
     * @since    1.0
     * @author   Emanuela Castorina <emanuela.castorina@yithemes.it>
     */
    public function yit_layout_panel() {
        yit_get_template( '/admin/layout/panel.php', array( 'options' => YIT_Layout_Panel()->options ) );
    }

    /**
     * Activate
     *
     * Run when the plugin is activated, add a custom options in database
     *
     * @return void
     * @since    1.0
     * @author   Emanuela Castorina <emanuela.castorina@yithemes.it>
     */
    public function activate() {
        YIT_Layout_Options()->add_default_options();
    }
}


/**
 * Main instance of plugin
 *
 * @return object
 * @since  1.0
 * @author Emanuela Castorina <emanuela.castorina@yithemes.it>
 */
function YIT_Layout() {
    return YIT_Layout::instance();
}

/**
 * Instantiate Sidebar class
 *
 * @since  1.0
 * @author Emanuela Castorina <emanuela.castorina@yithemes.it>
 */
YIT_Layout();
