<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js" data-path="<?php print(get_stylesheet_directory_uri()); ?>" />
	<head>
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" />
		<meta name="author" content="PxO Ink" /> <!-- Author: website void if removed. -->
		<meta name="HandheldFriendly" content="True" />
		<meta name="MobileOptimized" content="320" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="icon" href="<?php print(get_stylesheet_directory_uri()); ?>/images/favicon.png" />
		<link rel="shortcut icon" href="<?php print(get_stylesheet_directory_uri()); ?>/favicon.ico" />
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
		<?php wp_head(); ?>
	</head>