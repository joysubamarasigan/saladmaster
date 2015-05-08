<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package TA Pluton
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php $fav = ta_option( 'custom_favicon', false, 'url' ); ?>
<?php if ( $fav !== '' ) { ?>
<link rel="icon" type="image/png" href="<?php echo ta_option( 'custom_favicon', false, 'url' ); ?>" />
<?php } ?>

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">

	<header id="masthead" class="site-header" role="banner">
		<nav role="navigation">
			<div class="navbar">
				<div class="container">
					<div class="navbar-header">
						<!-- This is website logo -->
						<?php $logo = ta_option( 'custom_logo', false, 'url' ); ?>
						<?php if( $logo !== '' ) { ?>
							<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr( bloginfo( 'name' ) ) ?>" rel="homepage"><img class="logo" src="<?php echo $logo ?>" width="120" height="40" alt="logo"></a>
						<?php } else { ?>
							<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php esc_attr( bloginfo( 'name' ) ) ?>" rel="homepage"><img class="logo" src="<?php echo esc_url( get_template_directory_uri() ) ; ?>/images/logo.png" width="120" height="40" alt="logo"></a>
						<?php } ?>

						<?php if ( has_nav_menu( 'primary' ) || has_nav_menu( 'secondary' ) ) { ?>
						<!-- Navigation button, visible on small resolution -->
						<button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
							<span class="sr-only"><?php _e( 'Toggle navigation', 'ta-pluton' ); ?></span>
							<i class="icon-menu"></i>
						</button>
						<?php } ?>
					</div>

					<!-- Main navigation -->
					<?php if ( has_nav_menu( 'primary' ) || has_nav_menu( 'secondary' ) ) { ?>
					<div class="navbar-collapse collapse navbar-responsive-collapse">
						<?php if ( is_front_page() ) {
							$args = array(
								'menu'           => 'primary',
								'depth'          => 2,
								'container'      => false,
								'menu_class'     => 'nav navbar-nav navbar-right',
								'menu_id'        => 'top-navigation',
								'walker'         => new wp_bootstrap_navwalker()
							);

							if ( has_nav_menu( 'primary' ) ) {
								wp_nav_menu( $args );
							}
						} else {
							$args = array(
								'menu'           => 'secondary',
								'depth'          => 2,
								'container'      => false,
								'menu_class'     => 'nav navbar-nav navbar-right',
								'walker'         => new wp_bootstrap_navwalker()
							);

							if ( has_nav_menu( 'secondary' ) ) {
								wp_nav_menu( $args );
							}
						} ?>
					</div>
					<?php } ?>
					<!-- End main navigation -->
				</div>
			</div>
		</nav>
	</header><!-- #masthead -->

	<div id="content" class="site-content">