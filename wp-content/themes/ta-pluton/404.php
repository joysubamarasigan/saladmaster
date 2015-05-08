<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package TA Pluton
 */

get_header(); ?>

	<div class="container">
		<div class="row">
			<div id="primary" class="col-md-12 well">
				<main id="main" class="site-main" role="main">

					<div class="error-404 not-found">
						<header class="page-header post-inner-content">
							<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'ta-pluton' ); ?></h1>
							<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'ta-pluton' ); ?></p>
							<?php get_search_form(); ?>
						</header><!-- .page-header -->

						<div class="post-inner-content">
							<div class="col-lg-12">
								<div class="col-md-4">
									<?php the_widget( 'WP_Widget_Recent_Posts', 'number=5', 'before_title=<h3 class="widgettitle">&after_title=</h3>' ); ?>
								</div>

								<div class="col-md-4">
									<?php the_widget( 'WP_Widget_Recent_Comments', 'number=5', 'before_title=<h3 class="widgettitle">&after_title=</h3>' ); ?>
								</div>

								<div class="col-md-4">
									<?php if ( ta_pluton_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
									<div class="widget widget_categories">
										<h3 class="widget-title"><?php _e( 'Popular Categories', 'ta-pluton' ); ?></h3>
										<ul>
										<?php
											wp_list_categories( array(
												'orderby'    => 'count',
												'order'      => 'DESC',
												'show_count' => 1,
												'title_li'   => '',
												'number'     => 10,
											) );
										?>
										</ul>
									</div><!-- .widget -->
									<?php endif; ?>
								</div>
							</div>

							<div class="col-lg-12">
								<div class="col-md-4">
									<?php
										/* translators: %1$s: smiley */
										$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'ta-pluton' ), convert_smilies( ':)' ) ) . '</p>';
										the_widget( 'WP_Widget_Archives', 'dropdown=1', "before_title=<h3 class=\"widgettitle\">&after_title=</h3>$archive_content" );
									?>
								</div>

								<div class="col-md-4">
									<?php
										/* translators: %1$s: smiley */
										$category_content = '<p>' . sprintf( __( 'Try looking in the category archives. %1$s', 'ta-pluton' ), convert_smilies( ':)' ) ) . '</p>';
										the_widget( 'WP_Widget_Categories', 'dropdown=1', "before_title=<h3 class=\"widgettitle\">&after_title=</h3>$category_content" );
									?>
								</div>

								<div class="col-md-4">
									<?php the_widget( 'WP_Widget_Tag_Cloud', '', 'before_title=<h3 class="widgettitle">&after_title=</h3>' ); ?>
								</div>
							</div>
						</div><!-- .post-inner-content -->
					</div><!-- .error-404 -->

				</main><!-- #main -->
			</div><!-- #primary -->
		</div> <!-- .row -->
	</div> <!-- .container -->

<?php get_footer(); ?>