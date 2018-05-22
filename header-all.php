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

<style>
h1, h2, h3, h4, h5, h6 { font-weight: bold; clear: both; margin: .75em 0; text-transform: none; }
h1 { font-size: 1.8em; }
h2 { font-size: 1.667em; }
h3 { font-size: 1.333em; }
h4 { font-size: 1.11em; }
h5 { font-size: 1em; }
h6 { font-size: .778em; }
</style>
</head>

<body <?php body_class(''); ?>>
<div id="page" class="hfeed site">
	<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'intergalactic' ); ?></a>
	<header>
			<h3>All Slides for the SPLOTpoint presentation<br />"<?php bloginfo( 'name' ); ?>"<br/><?php echo site_url(); ?></h3>
			<h4>Formatted to print with pagebreaks</h4>

	</header><!-- #masthead -->
	<div id="content" class="site-content">
