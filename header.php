<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Header Template
 * header.php
 *
 * Template file used to display the theme header
 * @link http://codex.wordpress.org/Designing_Headers
 *
 * @package <[THEME NAME]>
 * @subpackage Templates
 * @author Machina Themes | @machinathemes
 * @copyright Copyright (c) 2013, Machina Themes
 * @license http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link http://www.machinathemes.com/themes/<[theme-name]>
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<title><?php exmachina_document_title(); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body class="<?php exmachina_body_class(); ?>" itemscope="itemscope" itemtype="http://schema.org/WebPage">

<?php do_atomic( 'before' ); // exmachina_before ?>

<div class="site-container">

	<?php get_template_part( 'partials/header' ); ?>

	<div class="site-inner row">

		<?php do_atomic( 'before_main' ); // exmachina_before_main ?>