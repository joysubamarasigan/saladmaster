<?php
/**
 * Template Name: HomePage
 *
 * @package TA Pluton
 */

get_header(); ?>

	<!-- Start home section -->
	<div id="<?php if ( ta_option( 'header_id' ) != '') :  echo ta_option( 'header_id' ); ?><?php endif; ?>">
		<!-- Start cSlider -->
		<div id="da-slider" class="da-slider">
			<div class="triangle"></div>
			<!-- mask elemet use for masking background image -->
			<div class="mask"></div>
			<!-- All slides centred in container element -->
			<div class="container">
				<?php if ( ta_option( 'slides' ) != '') : ?>
					<!-- Loop slide -->
					<?php foreach( $ta_option['slides'] as $slide ) : ?>
					<div class="da-slide">
						<h2 class="fittext2"><?php echo $slide['title']; ?></h2>
						<h4><?php echo $slide['subtitle']; ?></h4>
						<p><?php echo $slide['description']; ?></p>
						<a href="<?php echo $slide['url']; ?>" class="da-link button"><?php _e( 'Learn More', 'ta-pluton' ); ?></a>
						<div class="da-img">
							<img src="<?php echo $slide['image']; ?>" alt="slider image" width="320">
						</div>
					</div>
					<?php endforeach; ?>
					<!-- End loop slide -->
					<!-- Start cSlide navigation arrows -->
					<div class="da-arrows">
						<span class="da-arrows-prev"></span>
						<span class="da-arrows-next"></span>
					</div>
					<!-- End cSlide navigation arrows -->
				<?php endif; ?>
			</div>
		</div>
	</div>
	<!-- End home section -->

	<!-- Service section start -->
	<div class="section primary-section" id="<?php if ( ta_option( 'service_id' ) != '') :  echo ta_option( 'service_id' ); ?><?php endif; ?>">
		<div class="container">
			<!-- Start title section -->
			<div class="title">
				<h1><?php if ( ta_option( 'service_title' ) != '') : echo ta_option( 'service_title' ); ?><?php endif; ?></h1>
				<!-- Section's title goes here -->
				<p><?php if ( ta_option( 'service_tagline' ) != '') : echo ta_option( 'service_tagline' ); ?> <?php endif; ?></p>
				<!--Simple description for section goes here. -->
			</div>
			<div class="row">
				<?php if ( ta_option( 'service_slides' ) != '') : ?>
					<!-- Loop slide -->
					<?php foreach( $ta_option['service_slides'] as $service_slide ) : ?>
					<div class="col-md-4">
						<div class="centered service">
							<div class="circle-border zoom-in">
								<img class="img-circle" src="<?php echo $service_slide['image']; ?>" alt="service box">
							</div>
							<h3><?php echo $service_slide['title']; ?></h3>
							<p><?php echo $service_slide['subtitle']; ?></p>
						</div>
					</div>
					<?php endforeach; ?>
					<!-- End loop slide -->
				<?php endif; ?>
			</div>
		</div>
	</div>
	<!-- Service section end -->
	
	<!-- Portfolio section start -->
	<div class="section secondary-section " id="<?php if ( ta_option( 'portfolio_id' ) != '') :  echo ta_option( 'portfolio_id' ); ?><?php endif; ?>">
		<div class="triangle"></div>
		<div class="container">
			<div class="title">
				<h1><?php if ( ta_option( 'portfolio_title' ) != '') : echo ta_option( 'portfolio_title' ); ?><?php endif; ?></h1>
				<p><?php if ( ta_option( 'portfolio_tagline' ) != '') : echo ta_option( 'portfolio_tagline' ); ?><?php endif; ?></p>
			</div>

			<!-- Portfolio filter -->
			<?php if ( ta_option( 'filter_switch' ) == '1' ) {
			$terms = get_terms( "portfolio_tags" );
			$count = count( $terms );
			?>

			<ul class="nav nav-pills">
				<li class="filter" data-filter="all">
					<a href="#all"><?php _e( 'All', 'ta-pluton' ); ?></a>
				</li>
				<?php if ( $count > 0 ) {   
					foreach ( $terms as $term ) {
						$termname = strtolower( $term->name );
						$termname = str_replace( ' ', '-', $termname );
					echo '<li class="filter" data-filter="'.$termname.'"><a href="#'.$termname.'">'.$term->name.'</a></li>';
					}
				} ?>
			</ul>
			<?php } ?>

			<!-- Start details for portfolio project -->
			<div id="single-project">
				<?php 
				// the query
				$the_query = new WP_Query( array( 'post_type' => 'portfolio', 'posts_per_page' => -1 ) ); ?>

				<?php if ( $the_query->have_posts() ) : ?>

				<!-- the loop -->
				<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		
				<div id="slidingDiv<?php echo get_the_ID() ?>" class="toggleDiv single-project">
					<div class="container">
						<div class="row">
							<div class="col-md-6">
								<img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>" alt="project">
							</div>
							<div class="col-md-6">
								<div class="project-description">
									<div class="project-title clearfix">
										<h3><?php the_title(); ?></h3>
										<span class="show_hide close">
											<i class="icon-cancel"></i>
										</span>
									</div>
									<div class="project-info">
										<div><span><?php _e( 'Client', 'ta-pluton' ); ?></span><?php echo get_post_meta( $post->ID, '_cmb_clientname', true); ?></div>
										<div><span><?php _e( 'Date', 'ta-pluton' ); ?></span><?php echo get_the_date(); ?></div>
										<div><?php $tags = wp_get_post_terms( $post->ID, 'portfolio_tags', array( "fields" => "names" ) ); ?><span><?php _e( 'Categories', 'ta-pluton' ); ?></span><?php echo implode( ' / ',$tags ); ?></div>
										<div><span><?php _e( 'Link', 'ta-pluton' ); ?></span><a href="<?php echo get_post_meta( $post->ID, '_cmb_clienturl', true); ?>"><?php echo get_post_meta( $post->ID, '_cmb_clienturl', true); ?></a></div>
									</div>
									<?php the_content(); ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- End details for portfolio project -->

				<?php endwhile; ?>
				<!-- end of the loop -->

				<?php wp_reset_postdata(); ?>

				<?php else : ?>
					<p><?php _e( 'Sorry, no posts matched your criteria.', 'ta-pluton' ); ?></p>
				<?php endif; ?>

				<ul id="portfolio-grid" class="thumbnails row">
					<?php 
					// the query
					$the_query = new WP_Query( array( 'post_type' => 'portfolio', 'posts_per_page' => -1 ) ); ?>

					<?php if ( $the_query->have_posts() ) : ?>
					
					<!-- the loop -->
					<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

					<?php
						$terms = get_the_terms( $post->ID, 'portfolio_tags' );

						if ( $terms && ! is_wp_error( $terms ) ) :
							$links = array();

						foreach ( $terms as $term ) {
							$links[] = $term->name;
						}

						$links = str_replace(' ', '-', $links);
						$tax = join( " ", $links );

						else :
							$tax = '';
						endif;
					?>
					<li class="col-sm-6 col-md-4 mix <?php echo strtolower( $tax ); ?>">
						<div class="thumbnail">
							<img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) ); ?>" alt="project">
							<a href="#single-project" class="more show_hide" rel="#slidingDiv<?php echo get_the_ID() ?>">
								<i class="icon-plus"></i>
							</a>
							<h3><?php the_title(); ?></h3>
							<?php $tags = wp_get_post_terms( $post->ID, 'portfolio_tags', array( "fields" => "names" ) ); ?>
							<p><?php echo implode( ' / ',$tags ); ?></p>
							<div class="mask"></div>
						</div>
					</li>
					<?php endwhile; ?>
					<!-- end of the loop -->

					<?php wp_reset_postdata(); ?>

					<?php else : ?>
						<p><?php _e( 'Sorry, no posts matched your criteria.', 'ta-pluton' ); ?></p>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
	<!-- Portfolio section end -->

	<!-- About us section start -->
	<div class="section primary-section" id="<?php if ( ta_option( 'about_id' ) != '') :  echo ta_option( 'about_id' ); ?><?php endif; ?>">
		<div class="triangle"></div>
		<div class="container">
			<div class="title">
				<h1><?php if ( ta_option( 'about_us_title' ) != '') : echo ta_option( 'about_us_title' ); ?><?php endif; ?></h1>
				<p><?php if ( ta_option( 'about_us_tagline' ) != '') : echo ta_option( 'about_us_tagline' ); ?><?php endif; ?></p>
			</div>
			<div class="row team">
				<?php if ( ta_option( 'about_us_slides' ) != '') : ?>
					<!-- Loop slide -->
					<?php foreach( $ta_option['about_us_slides'] as $about_us_slide ) : ?>
					<div class="col-sm-4 col-md-4">
						<div class="thumbnail">
							<img src="<?php echo $about_us_slide['image']; ?>" alt="team member">
							<h3><?php echo $about_us_slide['title']; ?></h3>
							<ul class="social">
								<li>
									<a href="<?php echo $about_us_slide['furl']; ?>">
										<span class="icon-facebook-squared"></span>
									</a>
								</li>
								<li>
									<a href="<?php echo $about_us_slide['turl']; ?>">
										<span class="icon-twitter-squared"></span>
									</a>
								</li>
								<li>
									<a href="<?php echo $about_us_slide['lurl']; ?>">
										<span class="icon-linkedin-squared"></span>
									</a>
								</li>
							</ul>
							<div class="mask">
								<h2><?php echo $about_us_slide['subtitle']; ?></h2>
								<p><?php echo $about_us_slide['description']; ?></p>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
					<!-- End loop slide -->
				<?php endif; ?>
			</div>
			<h3 class="skill-title"><?php if ( ta_option( 'skill_title' ) != '') : echo ta_option( 'skill_title' ); ?><?php endif; ?></h3>
			<div class="row">
				<div class="col-md-6">
					<ul class="skills">
					<?php if ( ta_option( 'skill_slides' ) != '') : ?>
					<!-- Loop slide -->
					<?php foreach( $ta_option['skill_slides'] as $skill_slide ) : ?>
						<li>
							<span class="bar" data-width="<?php echo $skill_slide['subtitle']; ?>"></span>
							<h3><?php echo $skill_slide['title']; ?></h3>
						</li>
					<?php endforeach; ?>
					<!-- End loop slide -->
					<?php endif; ?>
					 </ul>
				</div>
				<div class="col-md-6">
					<div class="highlighted-box center">
						<h1><?php if ( ta_option( 'textarea_title' ) != '') : echo ta_option( 'textarea_title' ); ?><?php endif; ?></h1>
						<p><?php if ( ta_option( 'atextarea_tagline' ) != '') : echo ta_option( 'atextarea_tagline' ); ?><?php endif; ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- About us section end -->

	<!-- Call to action section start -->
	<div id="<?php if ( ta_option( 'call_id' ) != '') :  echo ta_option( 'call_id' ); ?><?php endif; ?>">
		<div class="section secondary-section">
			<div class="triangle"></div>
			<div class="container centered">
				<p class="large-text"><?php if ( ta_option( 'call_title' ) != '') : echo ta_option( 'call_title' ); ?><?php endif; ?></p>
				<a href="<?php if ( ta_option( 'call_btn_url' ) != '') : echo ta_option( 'call_btn_url' ); ?><?php endif; ?>" class="button"><?php if ( ta_option( 'call_btn_title' ) != '') : echo ta_option( 'call_btn_title' ); ?><?php endif; ?></a>
			</div>
		</div>
	</div>
	<!-- Call to action section end -->

	<!-- Client section start -->
	<div id="<?php if ( ta_option( 'client_id' ) != '') :  echo ta_option( 'client_id' ); ?><?php endif; ?>">
		<div class="section primary-section">
			<div class="triangle"></div>
			<div class="container">
				<div class="title">
					<h1><?php if ( ta_option( 'client_title' ) != '') : echo ta_option( 'client_title' ); ?><?php endif; ?></h1>
					<p><?php if ( ta_option( 'client_tagline' ) != '') : echo ta_option( 'client_tagline' ); ?><?php endif; ?></p>
				</div>
				<div class="row">
					<?php if ( ta_option( 'client_slides' ) != '') : ?>
						<!-- Loop slide -->
						<?php foreach( $ta_option['client_slides'] as $client_slide ) : ?>
						<div class="col-sm-4 col-md-4">
							<div class="testimonial">
								<p><?php echo $client_slide['description']; ?></p>
								<div class="whopic">
									<div class="arrow"></div>
									<img src="<?php echo $client_slide['image']; ?>" class="centered" alt="client">
									<strong><?php echo $client_slide['title']; ?>
										<small><?php echo $client_slide['subtitle']; ?></small>
									</strong>
								</div>
							</div>
						</div>
						<?php endforeach; ?>
						<!-- End loop slide -->
					<?php endif; ?>
				</div>
			</div>
		</div>

		<div class="section third-section client-bg">
			<div class="container centered">
				<div class="sub-section">
					<div class="title clearfix">
						<div class="pull-left">
							<h3><?php if ( ta_option( 'clients_title' ) != '') : echo ta_option( 'clients_title' ); ?><?php endif; ?></h3>
						</div>
						<ul class="client-nav pull-right">
							<li id="client-prev"></li>
							<li id="client-next"></li>
						</ul>
					</div>
					<ul class="row client-slider" id="client-slider">
					<?php if ( ta_option( 'clients_slides' ) != '') : ?>
						<!-- Loop slide -->
						<?php foreach( $ta_option['clients_slides'] as $clients_slide ) : ?>
						<li>
							<a href="<?php echo $clients_slide['url']; ?>">
								<img src="<?php echo $clients_slide['image']; ?>" alt="<?php echo $clients_slide['title']; ?>">
							</a>
						</li>
						<?php endforeach; ?>
						<!-- End loop slide -->
					<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- Client section end -->

	<!-- Blog section start -->
	<div id="<?php if ( ta_option( 'blog_id' ) != '') :  echo ta_option( 'blog_id' ); ?><?php endif; ?>" class="section secondary-section">
		<div class="container">
			<div class="title">
				<h1><?php if ( ta_option( 'blog_title' ) != '') : echo ta_option( 'blog_title' ); ?><?php endif; ?></h1>
				<p><?php if ( ta_option( 'blog_tagline' ) != '') : echo ta_option( 'blog_tagline' ); ?><?php endif; ?></p>
			</div>

			<div class="blog-list row">
				<div class="col-md-12">
					<ul class="timeline">
					<?php
					// get recent 4 posts for timeline.
					$timeline_posts = new WP_Query( array( 'showposts' => 4, 'post_status' => 'publish', 'ignore_sticky_posts' => 1, 'has_password' => false, ) );
					$i = 1;
					while( $timeline_posts->have_posts() ): $timeline_posts->the_post();
					?>
						<li <?php if ( $i % 2 == 0 ) { echo 'class="timeline-inverted"'; } ?> >
							<div class="timeline-image">
								<?php if ( has_post_thumbnail() ) : ?>
									<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
										<?php the_post_thumbnail( 'timeline-image', array( 'class' => 'img-circle' ) ); ?>
									</a>
								<?php endif; ?>
							</div>
							<div class="timeline-panel">
								<div class="timeline-heading">
									<span><?php echo get_the_date(); ?></span>
									<h3 class="subheading"><a href="<?php echo get_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>
								</div>
								<div class="timeline-body">
									<?php if( has_excerpt() ) {
										echo get_the_excerpt();
									} else {
										$content = strip_shortcodes( get_the_content() );
										echo wp_trim_words( $content, 30 );
									} ?>
								</div>
							</div>
						</li>
					<?php
					$i++;
					endwhile;
					?>
					</ul>
				</div>
			</div>

			<p class="centered"><a href="<?php if( get_option( 'show_on_front' ) == 'page' ) echo get_permalink( get_option('page_for_posts' ) ); else  echo esc_url( home_url() ); ?>" class="button"><?php _e( 'More Posts', 'ta-pluton' ); ?></a></p>
		</div>
	</div>
	<!-- Blog section end -->

	<!-- Newsletter section start -->
	<div class="section third-section newsletter-bg">
		<div class="container newsletter">
			<div class="sub-section">
				<div class="title clearfix">
					<div class="pull-left">
						<h3><?php if ( ta_option( 'newsletter_title' ) != '') : echo ta_option( 'newsletter_title' ); ?><?php endif; ?></h3>
					</div>
				</div>
			</div>
			<div id="success-subscribe" class="alert alert-success invisible">
				<strong><?php _e( 'Well done!', 'ta-pluton' ); ?></strong><?php _e( ' You successfully subscribe to our newsletter.', 'ta-pluton' ); ?></div>
			<div class="row">
				<div class="col-sm-6 col-md-6">
					<p><?php if ( ta_option( 'newsletter_tagline' ) != '') : echo ta_option( 'newsletter_tagline' ); ?><?php endif; ?></p>
				</div>
				<div class="col-sm-6 col-md-6">
					<form class="form-inline" method="post" id="subscribe">
						<input type="email" name="subscribe-email" id="subscribe-email" class="col-xs-12 col-sm-6 col-md-7 col-lg-8" placeholder="<?php _e( 'Enter your email', 'ta-pluton' ); ?>" value="">
						<button class="button button-sp"><?php _e( 'Subscribe', 'ta-pluton' ); ?></button>
					</form>
					<div id="err-subscribe" class="error centered"><?php _e( 'Please provide valid email address.', 'ta-pluton' ); ?></div>
				</div>
			</div>
		</div>
	</div>
	<!-- Newsletter section end -->

	<!-- Contact section start -->
	<div id="<?php if ( ta_option( 'contact_id' ) != '') :  echo ta_option( 'contact_id' ); ?><?php endif; ?>" class="contact">
		<div class="section secondary-section">
			<div class="container">
				<div class="title">
					<h1><?php if ( ta_option( 'contact_title' ) != '') : echo ta_option( 'contact_title' ); ?><?php endif; ?></h1>
					<p><?php if ( ta_option( 'contact_tagline' ) != '') : echo ta_option( 'contact_tagline' ); ?><?php endif; ?></p>
				</div>
			</div>
			<div class="map-wrapper">
				<div class="map-canvas" id="map-canvas"><?php _e( 'Loading map...', 'ta-pluton' ); ?></div>
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 contact-form">
							<h3><?php _e( 'Say Hello', 'ta-pluton' ); ?></h3>
							<div id="successSend" class="alert alert-success invisible">
								<strong><?php _e( 'Well done!', 'ta-pluton' ); ?></strong><?php _e( ' Your message has been sent.', 'ta-pluton' ); ?>
							</div>
							<div id="errorSend" class="alert alert-error invisible"><?php _e( 'There was an error.', 'ta-pluton' ); ?></div>
							<form id="contact-form" action="<?php echo get_template_directory_uri(). '/inc/contact-us.php'; ?>">
								<div class="form-group">
									<input class="form-control" type="text" id="name" name="name" placeholder="<?php _e( '* Your name...', 'ta-pluton' ); ?>" />
									<div class="error left-align" id="err-name"><?php _e( 'Please enter name.', 'ta-pluton' ); ?></div>
								</div>
								<div class="form-group">
									<input class="form-control" type="email" name="email" id="email" placeholder="<?php _e( '* Your email...', 'ta-pluton' ); ?>" />
									<div class="error left-align" id="err-email"><?php _e( 'Please enter valid email address.', 'ta-pluton' ); ?></div>
								</div>
								<div class="form-group">
									<textarea class="form-control" name="comment" id="comment" placeholder="<?php _e( '* Comments...', 'ta-pluton' ); ?>"></textarea>
									<div class="error left-align" id="err-comment"><?php _e( 'Please enter your comment.', 'ta-pluton' ); ?></div>
								</div>
								<div class="form-group">
									<button id="send-mail" class="message-btn"><?php _e( 'Send message', 'ta-pluton' ); ?></button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="container">
				<div class="col-md-9 center contact-info">
					<p><i class="icon-phone"></i><?php if ( ta_option( 'phone' ) != '') : echo ta_option( 'phone' ); ?><?php endif; ?></p>
					<p class="info-address"><i class="icon-location"></i><?php if ( ta_option( 'address' ) != '') : echo ta_option( 'address' ); ?><?php endif; ?></p>
					<div class="title">
						<h3><?php if ( ta_option( 'social_title' ) != '') : echo ta_option( 'social_title' ); ?><?php endif; ?></h3>
					</div>
				</div>
				<div class="row centered">
					<ul class="social">
					<?php $social_options = ta_option( 'social_icons' ); ?>
						<?php foreach ( $social_options as $key => $value ) {
							if ( $value && $key == 'Google Plus' ) { ?>
								<li>
									<a href="<?php echo $value; ?>">
										<span class="icon-gplus-squared"></span>
									</a>
								</li>
							<?php } elseif ( $value && $key == 'Dribbble' ) { ?>
								<li>
									<a href="<?php echo $value; ?>">
										<span class="icon-<?php echo strtolower( $key ); ?>"></span>
									</a>
								</li>
							<?php } elseif ( $value ) { ?>
								<li>
									<a href="<?php echo $value; ?>">
										<span class="icon-<?php echo strtolower( $key ); ?>-squared"></span>
									</a>
								</li>
							<?php }
						} ?>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!-- Contact section end -->
	
	<!-- ScrollUp button start -->
	<div class="scrollup">
		<a href="#">
			<i class="icon-up-open"></i>
		</a>
	</div>
	<!-- ScrollUp button end -->

<?php get_footer(); ?>