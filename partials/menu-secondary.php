<?php
/**
 * Secondary Menu Template
 */
?>
<nav class="nav-secondary row" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">

	<?php do_atomic( 'before_secondary_menu' ); // exmachina_before_secondary_menu ?>

	<?php
	wp_nav_menu( array(
		'theme_location' => 'secondary',
		'container'      => '',
		'menu_class'     => 'menu nav-menu menu-secondary',
		'fallback_cb'	 => ''
		));
	?>

	<?php do_atomic( 'after_secondary_menu' ); // exmachina_after_secondary_menu ?>


</nav><!-- .nav-secondary -->
