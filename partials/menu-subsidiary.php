<?php
/**
 * Subsidiary Menu Template
 */
?>
<nav class="nav-subsidiary row" role="navigation" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">

	<?php do_atomic( 'before_subsidiary_menu' ); // exmachina_before_subsidiary_menu ?>

	<?php
	wp_nav_menu( array(
		'theme_location' => 'subsidiary',
		'container'      => '',
		'menu_class'     => 'menu nav-menu menu-subsidiary',
		'fallback_cb'	 => ''
		));
	?>

	<?php do_atomic( 'after_subsidiary_menu' ); // exmachina_after_subsidiary_menu ?>


</nav><!-- .nav-subsidiary -->
