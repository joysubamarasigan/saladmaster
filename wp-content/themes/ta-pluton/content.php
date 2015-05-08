<?php
/**
 * @package TA Pluton
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="post-thumbnail">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<?php the_post_thumbnail( '', array( 'class' => 'featured' )); ?>
		</a>
	</div>
	<?php endif; ?>

	<div class="post-inner-content well">
		<header class="entry-header">
			<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

			<?php if ( 'post' == get_post_type() ) : ?>
				<div class="entry-meta">
					<?php ta_pluton_posted_on(); ?>
					<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages ?>
					<?php
						/* translators: used between list items, there is a space after the comma */
						$categories_list = get_the_category_list( ', ' );
						if ( $categories_list && ta_pluton_categorized_blog() ) :
					?>
						<span class="cat-links">
							<?php printf( __( 'Posted in %1$s', 'ta-pluton' ), $categories_list ); ?>
						</span>
					<?php endif; // End if categories ?>
					<?php endif; // End if 'post' == get_post_type() ?>

					<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
						<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'ta-pluton' ), __( '1 Comment', 'ta-pluton' ), __( '% Comments', 'ta-pluton' ) ); ?></span>
					<?php endif; ?>
				</div><!-- .entry-meta -->
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php
				/* translators: %s: Name of current post */
				the_content( sprintf(
					__( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'ta-pluton' ),
					the_title( '<span class="screen-reader-text">"', '"</span>', false )
				) );
			?>

			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'ta-pluton' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->

		<footer class="entry-footer">
			<p><?php edit_post_link( __( 'Edit', 'ta-pluton' ), '<span class="edit-link">', '</span>' ); ?></p>
		</footer><!-- .entry-footer -->
	</div><!-- .post-inner-content -->
</article><!-- #post-## -->