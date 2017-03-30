<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Intergalactic
 */
?>

	</div><!-- #content -->
	<footer id="colophon" class="splotpoint-footer" role="contentinfo">
	
	<div class="site-info">
		<?php echo splotpoint_footer_text() ?>
	</div>
	
		<div class="splot-info">
			Another <a href="http://splot.ca/">SPLOT on the web</a> <span class="sep"> &bull; </span> <a href="https://github.com/cogdog/splotpoint" rel="designer">SPLOTpoint Theme </a> &bull;  Blame <a href="http://cog.dog/">@cogdog</a>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

<?php splotpoint_backstretch();?>

</body>
</html>
