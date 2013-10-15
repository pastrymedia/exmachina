<?php
/**
 * The Sidebar containing the secondary widget areas.
 *
 * @package ExMachina
 */

if ( is_active_sidebar( 'secondary' ) ) : ?>

	<aside class="sidebar-secondary widget-area <?php echo apply_atomic( 'exmachina_sidebar_class', 'sidebar' );?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">

		<?php do_action( 'before_secondary' ); ?>

		<?php dynamic_sidebar( 'secondary' ); ?>

		<?php do_action( 'after_secondary' ); ?>

  	</aside><!-- .sidebar -->

<?php endif;  ?>

