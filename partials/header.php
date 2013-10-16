<?php do_atomic( 'before_header' ); // exmachina_before_header ?>

<header class="site-header row" role="banner" itemscope="itemscope" itemtype="http://schema.org/WPHeader">

	<?php do_atomic( 'header' ); // exmachina_header ?>

</header><!-- .site-header -->

<!-- TODO: Get this to work with theme -->
<?php if ( get_header_image() ) echo '<img class="header-image" src="' . esc_url( get_header_image() ) . '" alt="" />'; ?>

<?php do_atomic( 'after_header' ); // exmachina_after_header ?>