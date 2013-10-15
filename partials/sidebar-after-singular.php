<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package ExMachina
 */

if ( is_active_sidebar( 'after-singular' ) ) : ?>

	<aside class="sidebar-after-singular widget-area <?php echo apply_atomic( 'exmachina_sidebar_class', 'sidebar' );?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">

		<?php do_action( 'before_sidebar_after_singular' ); ?>

		<?php dynamic_sidebar( 'after-singular' ); ?>

		<?php do_action( 'after_sidebar_after_singular' ); ?>

  	</aside><!-- .sidebar -->

<?php endif;  ?>

