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
 * Wordpress Admin Dashboard Management
 *
 * @class YIT_Dashboard
 * @package	Yithemes
 * @since 2.0.0
 * @author Your Inspiration Themes
 *
 */

class YIT_Free extends YIT_Dashboard {

    public $submenu_pages_free;

    protected $_premium_template;

    protected $_url = 'http://yithemes.com';

    protected $_dashboard_link ;

    public function __construct() {

        $this->submenu_pages_free = array(
            'premium' => array(
                'parent_slug' => 'yit_panel',
                'page_title'  => __( 'Premium version', 'yit' ),
                'menu_title'  => __( 'Premium version', 'yit' ),
                'capability'  => 'manage_options',
                'menu_slug'   => 'yit_panel_premium',
                'function'    => array( $this, 'display_premium_page' )
            ),
            'buy' => array(
                'parent_slug' => 'yit_panel',
                'page_title'  => __( 'Buy Themes', 'yit' ),
                'menu_title'  => __( 'Buy Themes', 'yit' ),
                'capability'  => 'manage_options',
                'menu_slug'   => 'yit_panel_buy',
                'function'    => array( $this, 'display_buy_page' )
            )
        );

        $this->_premium_template = YIT_THEME_PATH . '/panel/premium.php';

        $this->_dashboard_link = 'http://cdn.yithemes.com/themes/free/'. YIT_THEME_NAME .'.php' ;

        add_action( 'admin_notices', array( $this, 'print_banner' ) );
        add_action( 'admin_menu', array( $this, 'add_submenu_pages' ), 20 );
    }

    /**
     * Print banner in dashboard pagina
     */
    public function print_banner() {

        global $pagenow;

        if( get_transient('yit_dashboard_message_dismiss') == 'yes' ) return;

        echo "<div style='position:relative; background: transparent; border: none; padding: 0;' class='yit-dashboard-message updated'>
               <div style='display: inline-block; position: relative;'>
                <a href='" . $this->_dashboard_link . "?url' target='_blank'><img style='max-width:100%' src='" . $this->_dashboard_link . "' alt='' /></a>
                <a href='". admin_url('?yit_dashboard_message_dismiss') ."' class='dismiss' style='position: absolute; right: 14px; top: 40px; background: url(\"". YIT_CORE_ASSETS_URL ."/images/dismiss.png\") no-repeat; width: 82px; height: 23px;'></a>
               </div>
              </div>";
    }

    public function add_submenu_pages(){

        foreach( $this->submenu_pages_free as $key => $page ){
            extract( $page );
            add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
        }
    }

    public function display_premium_page(){
        if( file_exists( $this->_premium_template ) ){
            include( $this->_premium_template );
        }
    }

    public function display_buy_page() {
        if( isset( $_GET['page'] ) && $_GET['page'] == 'yit_panel_buy' ) {
            echo "<iframe id='yit_iframe' src='{$this->_url}' width='100%' height='100%'></iframe>".
                "<script>" .
                "var height = document.body.clientHeight;" .
                "document.getElementById('yit_iframe').style.height = height + 'px';" .
                "document.body.style.overflow = 'hidden';" .
                "</script>";
        }
    }
}