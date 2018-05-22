<?php

get_header('all'); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">


		<?php

		$args = array( 
			'posts_per_page' => -1, 
			'orderby' => 'menu_order', 
			'order'   => 'ASC'
		);

		$all_query = new WP_Query( $args );
		

		if ( $all_query->have_posts() ) : ?>

			<?php /* Start the Loop */ 
				global $more;
				$slide_count = 0;
			
			?>
			<?php while ( $all_query->have_posts() ) : $all_query->the_post(); ?>
			
				<?php $slide_count++;?>
				
				<!-- page break if we are printing -->
				<p style="page-break-before: always; text-align:center; font-size:90%; border-top: 1px black dotted; border-bottom: 1px black dotted;"><em> begin slide <?php echo $slide_count?> </em></p>
				
				
				<header>
				<?php if ( has_post_thumbnail( ) ) {
	$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id(  ), 'large' ); ?>
	
				<img src="<?php echo esc_url( $thumbnail[0] ); ?>" class="aligncenter"?>
			<?php } ?>
		
			<h1><?php echo get_the_title()?></h1>
			</header>
<article>
	<div class="entry-content-wrapper">
		<div class="entry-content">
			<?php 
				$more = 1; 
				the_content();
			?>
		</div><!-- .entry-content -->
	</div><!-- .entry-content-wrapper -->
</article><!-- #post-## -->
				
				<!-- page break if we are printing -->
				<p style="page-break-after: always; text-align:center; font-size:90%; border-top: 1px black dotted; border-bottom: 1px black dotted;"><em> end slide <?php echo $slide_count?> </em></p>
				

			<?php endwhile; ?>


		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
