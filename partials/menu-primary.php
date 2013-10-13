<?php
/**
 * Primary Menu Template
 */
?>
<nav class="nav-primary row" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">

	<?php do_atomic( 'before_primary_menu' ); // exmachina_before_primary_menu ?>

	<?php
	wp_nav_menu( array(
		'theme_location' => 'primary',
		'container'      => '',
		'menu_class'     => 'menu nav-menu menu-primary',
		'fallback_cb'	 => 'hybrid_default_menu'
		));
	?>

	<?php do_atomic( 'after_primary_menu' ); // exmachina_after_primary_menu ?>


</nav><!-- .nav-primary -->
