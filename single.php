<?php
/**
 * The template for displaying all single posts.
 *
 * @package Intergalactic
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'content', 'single' ); ?>

			<div class="entry-footer-wrapper">
				<?php splotpoint_post_nav(); ?>
			</div><!-- .entry-footer-wrapper -->

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>