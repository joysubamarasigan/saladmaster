<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux_Framework_ta_config' ) ) {

        class Redux_Framework_ta_config {

            public $args = array();
            public $sections = array();
            public $theme;
            public $ReduxFramework;

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {
                    return;
                }

                // This is needed. Bah WordPress bugs.  ;)
                if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                    $this->initSettings();
                } else {
                    add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
                }

            }

            public function initSettings() {

                // Set the default arguments
                $this->setArguments();

                // Create the sections and fields
                $this->setSections();

                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }

                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }

            /**
             * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
             * Simply include this function in the child themes functions.php file.
             * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
             * so you must use get_template_directory_uri() if you want to use any of the built in icons
             * */
            function dynamic_section( $sections ) {
                //$sections = array();
                $sections[] = array(
                    'title'  => __( 'Section via hook', 'ta-pluton' ),
                    'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'ta-pluton' ),
                    'icon'   => 'el el-paper-clip',
                    // Leave this as a blank section, no options just some intro text set above.
                    'fields' => array()
                );

                return $sections;
            }

            /**
             * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
             * */
            function change_arguments( $args ) {
                //$args['dev_mode'] = true;

                return $args;
            }

            /**
             * Filter hook for filtering the default value of any given field. Very useful in development mode.
             * */
            function change_defaults( $defaults ) {
                $defaults['str_replace'] = 'Testing filter hook!';

                return $defaults;
            }

            public function setSections() {
				// Array of social options
                $social_options = array(
                    'Facebook'    => 'Facebook',
                    'Twitter'     => 'Twitter',
                    'LinkedIn'    => 'LinkedIn',
                    'Pinterest'   => 'Pinterest',
                    'Dribbble'    => 'Dribbble',
					'YouTube'     => 'YouTube',
                    'Google Plus' => 'Google Plus',
                );

                // Background Patterns Reader
                $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
                $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
                $sample_patterns      = array();

                if ( is_dir( $sample_patterns_path ) ) :

                    if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
                        $sample_patterns = array();

                        while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                            if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                                $name              = explode( '.', $sample_patterns_file );
                                $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                                $sample_patterns[] = array(
                                    'alt' => $name,
                                    'img' => $sample_patterns_url . $sample_patterns_file
                                );
                            }
                        }
                    endif;
                endif;

                ob_start();

                $ct          = wp_get_theme();
                $this->theme = $ct;
                $item_name   = $this->theme->get( 'Name' );
                $tags        = $this->theme->Tags;
                $screenshot  = $this->theme->get_screenshot();
                $class       = $screenshot ? 'has-screenshot' : '';

                $customize_title = sprintf( __( 'Customize &#8220;%s&#8221;', 'ta-pluton' ), $this->theme->display( 'Name' ) );

                ?>
                <div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
                    <?php if ( $screenshot ) : ?>
                        <?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
                            <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize"
                               title="<?php echo esc_attr( $customize_title ); ?>">
                                <img src="<?php echo esc_url( $screenshot ); ?>"
                                     alt="<?php esc_attr_e( 'Current theme preview', 'ta-pluton' ); ?>"/>
                            </a>
                        <?php endif; ?>
                        <img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>"
                             alt="<?php esc_attr_e( 'Current theme preview', 'ta-pluton' ); ?>"/>
                    <?php endif; ?>

                    <h4><?php echo $this->theme->display( 'Name' ); ?></h4>

                    <div>
                        <ul class="theme-info">
                            <li><?php printf( __( 'By %s', 'ta-pluton' ), $this->theme->display( 'Author' ) ); ?></li>
                            <li><?php printf( __( 'Version %s', 'ta-pluton' ), $this->theme->display( 'Version' ) ); ?></li>
                            <li><?php echo '<strong>' . __( 'Tags', 'ta-pluton' ) . ':</strong> '; ?><?php printf( $this->theme->display( 'Tags' ) ); ?></li>
                        </ul>
                        <p class="theme-description"><?php echo $this->theme->display( 'Description' ); ?></p>
                        <?php
                            if ( $this->theme->parent() ) {
                                printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.', 'ta-pluton' ) . '</p>', __( 'http://codex.wordpress.org/Child_Themes', 'ta-pluton' ), $this->theme->parent()->display( 'Name' ) );
                            }
                        ?>

                    </div>
                </div>

                <?php
                $item_info = ob_get_contents();

                ob_end_clean();

				// Header Settings
                $this->sections[] = array(
                    'icon'      => 'el el-website',
                    'title'     => __('Header Settings', 'ta-pluton'),
                    'fields'    => array(
						array( 
                            'title'     => __( 'Header Section ID', 'ta-pluton' ),
                            'subtitle'  => __( 'Set id for header section for one page scrolling.', 'ta-pluton' ),
                            'id'        => 'header_id',
                            'default'   => 'home',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Logo', 'ta-pluton' ),
                            'subtitle'  => __( 'Use this field to upload your custom logo for use in the theme header. (Recommended size: 120x40 pixels)', 'ta-pluton' ),
                            'id'        => 'custom_logo',
                            'default'   => '',
                            'type'      => 'media',
                            'url'       => true,
                        ),

						array( 
                            'title'     => __( 'Favicon', 'ta-pluton' ),
                            'subtitle'  => __( 'Use this field to upload your custom favicon.', 'ta-pluton' ),
                            'id'        => 'custom_favicon',
                            'default'   => '',
                            'type'      => 'media',
                            'url'       => true,
                        ),

						array( 
                            'title'     => __( 'Slider Background', 'ta-pluton' ),
                            'subtitle'  => __( 'Use this field to upload your image for slider background. (Min height: 520px)', 'ta-pluton' ),
                            'id'        => 'slider_backgound',
                            'default'   => '',
                            'type'      => 'media',
                            'url'       => true,
                        ),

						array(
							'id'          => 'slides',
							'type'        => 'slides',
							'title'       => __( 'Slides Options', 'ta-pluton' ),
							'subtitle'    => __( 'Unlimited slides with drag and drop sortings.', 'ta-pluton' ),
							'desc'        => __( 'Create a responsive header image slider for use in the theme header.', 'ta-pluton' ),
							'show'        => array( 
								'title'        => true,
								'subtitle'     => true,
								'description'  => true,
								'image_upload' => true,
								'url'          => true,
							),
							'placeholder' => array(
								'title'           => __( 'This is a title', 'ta-pluton' ),
								'subtitle'        => __( 'This is a subtitle', 'ta-pluton' ),
								'description'     => __( 'Description Here', 'ta-pluton' ),
								'url'             => __( 'Give us a link!', 'ta-pluton' ),
							),
						),
                    ),
                );

				//Service Settings
                $this->sections[] = array(
                    'icon'      => 'el el-lines',
                    'title'     => __('Service Settings', 'ta-pluton'),
                    'fields'    => array(
						array( 
                            'title'     => __( 'Service Section ID', 'ta-pluton' ),
                            'subtitle'  => __( 'Set id for service section for one page scrolling.', 'ta-pluton' ),
                            'id'        => 'service_id',
                            'default'   => 'service',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Service Section Title', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own title for service section.', 'ta-pluton' ),
                            'id'        => 'service_title',
                            'default'   => 'Service Section Title',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Service Section Tagline', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own tagline for service section.', 'ta-pluton' ),
                            'id'        => 'service_tagline',
                            'default'   => 'Add your own tagline for service section.',
                            'type'      => 'text',
                        ),

						array(
							'id'          => 'service_slides',
							'type'        => 'slides',
							'title'       => __( 'Service Options', 'ta-pluton' ),
							'subtitle'    => __( 'Unlimited Service Box with drag and drop sortings.', 'ta-pluton' ),
							'desc'        => __( 'Create service boxes for service section.', 'ta-pluton' ),
							'show'        => array( 
								'title'        => true,
								'subtitle'     => true,
								'description'  => false,
								'image_upload' => true,
								'url'          => false,
							),
							'placeholder' => array(
								'title'           => __( 'This is a title', 'ta-pluton' ),
								'subtitle'        => __( 'This is a subtitle', 'ta-pluton' ),
							),
						),
                    ),
                );

				//Portfolio Settings
                $this->sections[] = array(
                    'icon'      => 'el el-folder',
                    'title'     => __('Portfolio Settings', 'ta-pluton'),
                    'fields'    => array(
						array( 
                            'title'     => __( 'Portfolio Section ID', 'ta-pluton' ),
                            'subtitle'  => __( 'Set id for portfolio section for one page scrolling.', 'ta-pluton' ),
                            'id'        => 'portfolio_id',
                            'default'   => 'portfolio',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Display Filter', 'ta-pluton' ),
                            'subtitle'  => __( 'Select to enable/disable the portfolio filter.', 'ta-pluton' ),
                            'id'        => 'filter_switch',
                            'default'   => true,
                            'on'        => __( 'Enable', 'ta-pluton' ),
                            'off'       => __( 'Disable', 'ta-pluton' ),
                            'type'      => 'switch',
                        ),

						array(
                            'title'     => __( 'Portfolio Section Title', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own title for portfolio section.', 'ta-pluton' ),
                            'id'        => 'portfolio_title',
                            'default'   => 'Portfolio Section Title',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Portfolio Section Tagline', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own tagline for portfolio section.', 'ta-pluton' ),
                            'id'        => 'portfolio_tagline',
                            'default'   => 'Add your own tagline for portfolio section.',
                            'type'      => 'text',
                        ),
                    ),
                );

				// About Us Settings
                $this->sections[] = array(
                    'icon'      => 'el el-myspace',
                    'title'     => __('About Us Settings', 'ta-pluton'),
                    'fields'    => array(
						array( 
                            'title'     => __( 'About Us Section ID', 'ta-pluton' ),
                            'subtitle'  => __( 'Set id for about us section for one page scrolling.', 'ta-pluton' ),
                            'id'        => 'about_id',
                            'default'   => 'about',
                            'type'      => 'text',
                        ),

						array(
                            'title'     => __( 'About Us Section Title', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own title for about us section.', 'ta-pluton' ),
                            'id'        => 'about_us_title',
                            'default'   => 'About Us Section Title',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'About Us Section Tagline', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own tagline for about us section.', 'ta-pluton' ),
                            'id'        => 'about_us_tagline',
                            'default'   => 'Add your own tagline for about us section.',
                            'type'      => 'text',
                        ),

						array(
							'id'          => 'about_us_slides',
							'type'        => 'slides',
							'title'       => __( 'Team Options', 'ta-pluton' ),
							'subtitle'    => __( 'Unlimited Team Box with drag and drop sortings.', 'ta-pluton' ),
							'desc'        => __( 'Create team boxes for about us section.', 'ta-pluton' ),
							'show'        => array( 
								'title'        => true,
								'subtitle'     => true,
								'description'  => true,
								'image_upload' => true,
								'url'          => false,
								'furl'         => true,
								'turl'         => true,
								'lurl'         => true,
							),
							'placeholder' => array(
								'title'           => __( 'This is a name', 'ta-pluton' ),
								'subtitle'        => __( 'This is a role', 'ta-pluton' ),
								'description'     => __( 'Description Here', 'ta-pluton' ),
								'furl'            => __( 'Give us a Facebook link!', 'ta-pluton' ),
								'turl'            => __( 'Give us a Twitter link!', 'ta-pluton' ),
								'lurl'            => __( 'Give us a LinkedIn link!', 'ta-pluton' ),
							),
						),

						array(
                            'title'     => __( 'Skill Section Title', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own title for skill section.', 'ta-pluton' ),
                            'id'        => 'skill_title',
                            'default'   => 'Skill Section Title',
                            'type'      => 'text',
                        ),

						array(
							'id'          => 'skill_slides',
							'type'        => 'slides',
							'title'       => __( 'Skill Options', 'ta-pluton' ),
							'subtitle'    => __( 'Unlimited Skill Box with drag and drop sortings.', 'ta-pluton' ),
							'desc'        => __( 'Create skill boxes for skill section.', 'ta-pluton' ),
							'show'        => array( 
								'title'        => true,
								'subtitle'     => true,
								'description'  => false,
								'url'          => false,
								'image_upload' => false,
							),
							'placeholder' => array(
								'title'           => __( 'Skill tilte here', 'ta-pluton' ),
								'subtitle'        => __( 'Skill number here. Max: 100%.', 'ta-pluton' ),

							),
						),

						array(
                            'title'     => __( 'TextArea Section Title', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own title for textarea section.', 'ta-pluton' ),
                            'id'        => 'textarea_title',
                            'default'   => 'TextArea Section Title',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'TextArea Section Tagline', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own tagline for textarea section.', 'ta-pluton' ),
                            'id'        => 'atextarea_tagline',
                            'default'   => 'Add your own tagline for textarea section.',
                            'type'      => 'text',
                        ),
                    ),
                );

				// Call to Action Settings
                $this->sections[] = array(
                    'icon'      => 'el el-bullhorn',
                    'title'     => __('Call to Action Settings', 'ta-pluton'),
                    'fields'    => array(
						array( 
                            'title'     => __( 'Call to Action Section ID', 'ta-pluton' ),
                            'subtitle'  => __( 'Set id for call to action section for one page scrolling.', 'ta-pluton' ),
                            'id'        => 'call_id',
                            'default'   => 'call-to-action',
                            'type'      => 'text',
                        ),

						array(
                            'title'     => __( 'Call to Action Section Title', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own title for call to action section.', 'ta-pluton' ),
                            'id'        => 'call_title',
                            'default'   => 'Call to Action Title',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Call to Action Section Button Title', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own title for call to action button.', 'ta-pluton' ),
                            'id'        => 'call_btn_title',
                            'default'   => 'Call to Action',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Call to Action Section Button URL', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own url for call to action button.', 'ta-pluton' ),
                            'id'        => 'call_btn_url',
                            'default'   => '',
                            'type'      => 'text',
                        ),
                    ),
                );

				//Client Settings
                $this->sections[] = array(
                    'icon'      => 'el el-user',
                    'title'     => __('Client Settings', 'ta-pluton'),
                    'fields'    => array(
						array( 
                            'title'     => __( 'Client Section ID', 'ta-pluton' ),
                            'subtitle'  => __( 'Set id for client section for one page scrolling.', 'ta-pluton' ),
                            'id'        => 'client_id',
                            'default'   => 'client',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Client Section Title', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own title for client section.', 'ta-pluton' ),
                            'id'        => 'client_title',
                            'default'   => 'Client Section Title',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Client Section Tagline', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own tagline for client section.', 'ta-pluton' ),
                            'id'        => 'client_tagline',
                            'default'   => 'Add your own tagline for client section.',
                            'type'      => 'text',
                        ),

						array(
							'id'          => 'client_slides',
							'type'        => 'slides',
							'title'       => __( 'Client Testimonials', 'ta-pluton' ),
							'subtitle'    => __( 'Unlimited Testimonial Box with drag and drop sortings.', 'ta-pluton' ),
							'desc'        => __( 'Create testimonial boxes for client section.', 'ta-pluton' ),
							'show'        => array( 
								'title'        => true,
								'subtitle'     => true,
								'description'  => true,
								'image_upload' => true,
								'url'          => false,
							),
							'placeholder' => array(
								'title'           => __( 'This is a name', 'ta-pluton' ),
								'subtitle'        => __( 'This is a role', 'ta-pluton' ),
								'description'     => __( 'Testimonial Here', 'ta-pluton' ),
							),
						),

						array( 
                            'title'     => __( 'Our Clients Section Title', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own title for our clients section.', 'ta-pluton' ),
                            'id'        => 'clients_title',
                            'default'   => 'Our Clients',
                            'type'      => 'text',
                        ),

						array(
							'id'          => 'clients_slides',
							'type'        => 'slides',
							'title'       => __( 'Our Clients Box', 'ta-pluton' ),
							'subtitle'    => __( 'Unlimited Our Clients Box with drag and drop sortings.', 'ta-pluton' ),
							'desc'        => __( 'Create our clients box for client section.', 'ta-pluton' ),
							'show'        => array( 
								'title'        => true,
								'subtitle'     => false,
								'description'  => false,
								'image_upload' => true,
								'url'          => true,
							),
							'placeholder' => array(
								'title'           => __( 'This is a title', 'ta-pluton' ),
								'url'             => __( 'Give us a link!', 'ta-pluton' ),
							),
						),

						array( 
                            'title'     => __( 'Client Box Background', 'ta-pluton' ),
                            'subtitle'  => __( 'Use this field to upload your image for client box background.', 'ta-pluton' ),
                            'id'        => 'client_backgound',
                            'default'   => '',
                            'type'      => 'media',
                            'url'       => true,
                        ),
                    ),
                );

				//Blog Setting
                $this->sections[] = array(
                    'icon'      => 'el el-wordpress',
                    'title'     => __('Blog Settings', 'ta-pluton'),
                    'fields'    => array(
						array( 
                            'title'     => __( 'Blog Section ID', 'ta-pluton' ),
                            'subtitle'  => __( 'Set id for blog section for one page scrolling.', 'ta-pluton' ),
                            'id'        => 'blog_id',
                            'default'   => 'blog',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Blog Section Title', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own title for blog section.', 'ta-pluton' ),
                            'id'        => 'blog_title',
                            'default'   => 'Blog Section Title',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Blog Section Tagline', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own tagline for blog section.', 'ta-pluton' ),
                            'id'        => 'blog_tagline',
                            'default'   => 'Add your own tagline for blog section.',
                            'type'      => 'text',
                        ),
                    )
                );

				//Newsletter Setting
                $this->sections[] = array(
                    'icon'      => 'el el-envelope-alt',
                    'title'     => __('Newsletter Settings', 'ta-pluton'),
                    'fields'    => array(
						array( 
                            'title'     => __( 'Newsletter Section Background', 'ta-pluton' ),
                            'subtitle'  => __( 'Use this field to upload your image for newsletter section background.', 'ta-pluton' ),
                            'id'        => 'newsletter_backgound',
                            'default'   => '',
                            'type'      => 'media',
                            'url'       => true,
                        ),

						array( 
                            'title'     => __( 'Newsletter Section Title', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own title for newsletter section.', 'ta-pluton' ),
                            'id'        => 'newsletter_title',
                            'default'   => 'Newsletter Section Title',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Newsletter Section Tagline', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own tagline for newsletter section.', 'ta-pluton' ),
                            'id'        => 'newsletter_tagline',
                            'default'   => 'Add your own tagline for newsletter section.',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'MailChimp API Key', 'ta-pluton' ),
                            'subtitle'  => __( 'Go to your <a href="http://eepurl.com/bb75oT" target="_blank">MailChimp</a> Account Settings -> Extras -> API Keys. Click on Create a Key button and you will have you API  key ready.', 'ta-pluton' ),
                            'id'        => 'mailchimp_api_key',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'MailChimp List ID', 'ta-pluton' ),
                            'subtitle'  => __( 'Go to Lists section, Create List, Visit your created lists under Settings -> List name & defaults you will find List ID.', 'ta-pluton' ),
                            'id'        => 'mailchimp_list_id',
                            'type'      => 'text',
                        ),
                    )
                );

				//Contact Settings
                $this->sections[] = array(
                    'icon'      => 'el el-envelope',
                    'title'     => __('Contact Settings', 'ta-pluton'),
                    'fields'    => array(
						array( 
                            'title'     => __( 'Contact Section ID', 'ta-pluton' ),
                            'subtitle'  => __( 'Set id for contact section for one page scrolling.', 'ta-pluton' ),
                            'id'        => 'contact_id',
                            'default'   => 'contact',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Contact Section Title', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own title for contact section.', 'ta-pluton' ),
                            'id'        => 'contact_title',
                            'default'   => 'Contact Section Title',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Contact Section Tagline', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own tagline for contact section.', 'ta-pluton' ),
                            'id'        => 'contact_tagline',
                            'default'   => 'Add your own tagline for contact section.',
                            'type'      => 'text',
                        ),

                        array( 
                            'title'     => __( 'Contact Email', 'ta-pluton' ),
                            'subtitle'  => __( 'Set your email address. This is where the contact form will send a message to.', 'ta-pluton' ),
                            'id'        => 'contact_email',
                            'default'   => 'yourname@yourdomain.com',
							'validate'  => 'email',
							'msg'       => 'Not a valid email address.',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Set Your Latitude on Google Map', 'ta-pluton' ),
                            'subtitle'  => __( 'To set location you will need to find Latitude and Longitude numbers, you can find in <a href="http://www.latlong.net/" target="_blank">this site</a>.', 'ta-pluton' ),
                            'id'        => 'lat',
                            'default'   => '37.42225',
							'msg'       => 'Not a valid numeric.',
							'validate'  => 'numeric',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Set Your Longitude on Google Map', 'ta-pluton' ),
                            'subtitle'  => __( 'To set location you will need to find Latitude and Longitude numbers, you can find in <a href="http://www.latlong.net/" target="_blank">this site</a>.', 'ta-pluton' ),
                            'id'        => 'lon',
                            'default'   => '-122.08322',
							'msg'       => 'Not a valid numeric.',
							'validate'  => 'numeric',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Set Your Address', 'ta-pluton' ),
                            'subtitle'  => __( 'Set your address here.', 'ta-pluton' ),
                            'id'        => 'address',
                            'default'   => '1600 Amphitheatre Parkway Mountain View, CA 94043',
                            'type'      => 'text',
                        ),

						array( 
                            'title'     => __( 'Set Your Phone Number', 'ta-pluton' ),
                            'subtitle'  => __( 'Set your phone number here.', 'ta-pluton' ),
                            'id'        => 'phone',
                            'default'   => '+01 234 567 890',
                            'type'      => 'text',
                        ),
                    )
                );

				//Social Settings
                $this->sections[] = array(
                    'icon'      => 'el el-group',
                    'title'     => __('Social Settings', 'ta-pluton'),
                    'fields'    => array(
						array( 
                            'title'     => __( 'Social Section Title', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own title for social section.', 'ta-pluton' ),
                            'id'        => 'social_title',
                            'default'   => 'Social Section Title',
                            'type'      => 'text',
                        ),

                         array( 
                            'title'     => __( 'Social Icons', 'ta-pluton' ),
                            'subtitle'  => __( 'Arrange your social icons. Add complete URLs to your social profiles.', 'ta-pluton' ),
                            'id'        => 'social_icons',
                            'type'      => 'sortable',
                            'options'   => $social_options,
                        ),
                    )
                );

				//Footer Settings
                $this->sections[] = array(
                    'icon'      => 'el el-photo',
                    'title'     => __('Footer Settings', 'ta-pluton'),
                    'fields'    => array(
                        array( 
                            'title'     => __( 'Custom Copyright', 'ta-pluton' ),
                            'subtitle'  => __( 'Add your own custom text/html for copyright region. You are <strong style="color:red;">not allowed</strong> to Remove Back Link/Credit unless you <a href="http://themeart.co/support-themeart/" target="_blank">donated us</a>.', 'ta-pluton' ),
                            'id'        => 'custom_copyright',
                            'default'   => 'Copyright &copy; 2015 - <a href="http://themeart.co/free-theme/ta-pluton/" title="TA Pluton Free WordPress Theme" target="_blank">TA Pluton</a>. Design by <a href="http://www.graphberry.com/" target="_blank">GraphBerry</a> and Developed by <a href="http://themeart.co/" title="Download Free Premium WordPress Themes" target="_blank">ThemeArt</a>.',
                            'type'      => 'editor',
                        ),
                    )
                );

				//Custom CSS
                $this->sections[] = array(
                    'icon'      => 'el el-css',
                    'title'     => __('Custom CSS', 'ta-pluton'),
                    'fields'    => array(
                         array(
                            'title'     => __( 'Custom CSS', 'ta-pluton' ),
                            'subtitle'  => __( 'Insert any custom CSS.', 'ta-pluton' ),
                            'id'        => 'custom_css',
                            'type'      => 'ace_editor',
                            'mode'      => 'css',
                            'theme'     => 'monokai',
                        ),
                    )
                );

				$this->sections[] = array(
                    'title'  => __( 'Import / Export', 'ta-pluton' ),
                    'desc'   => __( 'Import and Export your theme settings from file, text or URL.', 'ta-pluton' ),
                    'icon'   => 'el el-refresh',
                    'fields' => array(
                        array(
                            'id'         => 'opt-import-export',
                            'type'       => 'import_export',
                            'full_width' => false,
						),
					),
				);

				$this->sections[] = array(
                    'type' => 'divide',
				);

                $this->sections[] = array(
                    'icon'   => 'el el-info-circle',
                    'title'  => __( 'Theme Information', 'ta-pluton' ),
                    'desc'   => __( '<p class="description">About TA Pluton</p>', 'ta-pluton' ),
                    'fields' => array(
                        array(
                            'id'      => 'opt-raw-info',
                            'type'    => 'raw',
                            'content' => $item_info,
                        )
                    ),
                );
            }

            /**
             * All the possible arguments for Redux.
             * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
             * */
            public function setArguments() {

                $theme = wp_get_theme(); // For use with some settings. Not necessary.

                $this->args = array(
					// Disable tracking
					'disable_tracking'     => true,
                    // TYPICAL -> Change these values as you need/desire
                    'opt_name'             => 'ta-option',
                    // This is where your data is stored in the database and also becomes your global variable name.
                    'display_name'         => $theme->get( 'Name' ),
                    // Name that appears at the top of your panel
                    'display_version'      => $theme->get( 'Version' ),
                    // Version that appears at the top of your panel
                    'menu_type'            => 'menu',
                    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                    'allow_sub_menu'       => true,
                    // Show the sections below the admin menu item or not
                    'menu_title'           => __( 'Theme Panel', 'ta-pluton' ),
                    'page_title'           => __( 'Theme Options', 'ta-pluton' ),
                    // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'       => '',
                    // Set it you want google fonts to update weekly. A google_api_key value is required.
                    'google_update_weekly' => false,
                    // Must be defined to add google fonts to the typography module
                    'async_typography'     => true,
                    // Use a asynchronous font on the front end or font string
                    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                    'admin_bar'            => true,
                    // Show the panel pages on the admin bar
                    'admin_bar_icon'     => 'dashicons-admin-settings',
                    // Choose an icon for the admin bar menu
                    'admin_bar_priority' => 50,
                    // Choose an priority for the admin bar menu
                    'global_variable'      => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'             => false,
                    // Show the time the page took to load, etc
                    'update_notice'        => true,
                    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                    'customizer'           => true,
                    // Enable basic customizer support
                    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                    // OPTIONAL -> Give you extra features
                    'page_priority'        => null,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    'page_parent'          => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'     => 'manage_options',
                    // Permissions needed to access the options panel.
                    'menu_icon'            => '',
                    // Specify a custom URL to an icon
                    'last_tab'             => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'            => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'            => '_options',
                    // Page slug used to denote the panel
                    'save_defaults'        => true,
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'         => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'         => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export'   => true,
                    // Shows the Import/Export panel when not used as a field.

                    // CAREFUL -> These options are for advanced use only
                    'transient_time'       => 60 * MINUTE_IN_SECONDS,
                    'output'               => true,
                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                    'output_tag'           => true,
                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                    'database'             => '',
                    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                    'system_info'          => false,
                    // REMOVE

                    // HINTS
                    'hints'             => array(
                        'icon'          => 'icon-question-sign',
                        'icon_position' => 'right',
                        'icon_color'    => 'lightgray',
                        'icon_size'     => 'normal',
                        'tip_style'     => array(
                            'color'   => 'light',
                            'shadow'  => true,
                            'rounded' => false,
                            'style'   => '',
                        ),
                        'tip_position'  => array(
                            'my' => 'top left',
                            'at' => 'bottom right',
                        ),
                        'tip_effect'    => array(
                            'show' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'mouseover',
                            ),
                            'hide' => array(
                                'effect'   => 'slide',
                                'duration' => '500',
                                'event'    => 'click mouseleave',
                            ),
                        ),
                    )
                );

                // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
                $this->args['admin_bar_links'][] = array(
                    'id'    => 'redux-docs',
                    'href'   => 'http://themeart.co/document/ta-pluton-theme-documentation/',
                    'title' => __( 'Documentation', 'ta-pluton' ),
                );

                $this->args['admin_bar_links'][] = array(
                    //'id'    => 'redux-support',
                    'href'   => 'http://themeart.co/support/',
                    'title' => __( 'Support', 'ta-pluton' ),
                );

                // Panel Intro text -> before the form
                if ( ! isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
                    if ( ! empty( $this->args['global_variable'] ) ) {
                        $v = $this->args['global_variable'];
                    } else {
                        $v = str_replace( '-', '_', $this->args['opt_name'] );
                    }
                    $this->args['intro_text'] = sprintf( __( '<p>You can start customizing your theme with the powerful option panel.</p>', 'ta-pluton' ), $v );
                } else {
                    $this->args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'ta-pluton' );
                }

                // Add content after the form.
                $this->args['footer_text'] = __( '<p>Thanks for using <a href="http://themeart.co/free-theme/ta-pluton/" target="_blank">TA Pluton</a>. This free WordPress theme is designed by <a href=
				"http://themeart.co/" target="_blank">ThemeArt</a>. Please feel free to leave us some feedback about your experience, so we can improve our themes for you.</p>', 'ta-pluton' );
            }

            public function validate_callback_function( $field, $value, $existing_value ) {
                $error = true;
                $value = 'just testing';

                $return['value'] = $value;
                $field['msg']    = 'your custom error message';
                if ( $error == true ) {
                    $return['error'] = $field;
                }

                return $return;
            }

            public function class_field_callback( $field, $value ) {
                print_r( $field );
                echo '<br/>CLASS CALLBACK';
                print_r( $value );
            }

        }

        global $reduxConfig;
        $reduxConfig = new Redux_Framework_ta_config();
    } else {
        echo "The class named Redux_Framework_ta_config has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ):
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    endif;

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ):
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error = true;
            $value = 'just testing';

            $return['value'] = $value;
            $field['msg']    = 'your custom error message';
            if ( $error == true ) {
                $return['error'] = $field;
            }

            return $return;
        }
    endif;