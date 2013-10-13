<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package ExMachina
 */

if ( is_active_sidebar( 'primary' ) ) : ?>

	<aside class="sidebar-primary widget-area <?php echo apply_atomic( 'exmachina_sidebar_class', 'sidebar' );?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">

		<?php do_action( 'before_primary' ); ?>

		<?php dynamic_sidebar( 'primary' ); ?>

		<?php do_action( 'after_primary' ); ?>

  	</aside><!-- .sidebar -->

<?php endif;  ?>

