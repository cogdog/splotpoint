<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Intergalactic
 */

// $header = get_header_image();

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'intergalactic' ); ?></a>
	<header id="masthead" class="site-header" role="banner">
		<?php if ( ! empty( $header ) && is_page() ) { ?>
			<div class="header-background" style="background-image:url(<?php echo esc_url( $header ); ?>)"></div>
		<?php } ?>
		<div class="site-branding">
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		</div>

		<button class="menu-toggle x">
			<span class="lines"></span>
			<span class="screen-reader-text"><?php _e( 'Primary Menu', 'intergalactic' ); ?></span>
		</button>
		<div class="slide-menu">
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav><!-- #site-navigation -->

			<?php if ( has_nav_menu( 'social' ) ) : ?>
				<?php wp_nav_menu( array( 'theme_location' => 'social', 'depth' => 1, 'link_before' => '<span class="screen-reader-text">', 'link_after' => '</span>', 'container_class' => 'social-links' ) ); ?>
			<?php endif; ?>

			<?php if ( is_active_sidebar( 'sidebar-1' ) ) {
				get_sidebar();
			} ?>

		</div>
	</header><!-- #masthead -->
	<div id="content" class="site-content">
