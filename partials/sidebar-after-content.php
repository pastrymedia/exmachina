<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package ExMachina
 */

if ( is_active_sidebar( 'after-content' ) ) : ?>

	<aside class="sidebar-after-content widget-area <?php echo apply_atomic( 'exmachina_sidebar_class', 'sidebar' );?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">

		<?php do_action( 'before_sidebar_after_content' ); ?>

		<?php dynamic_sidebar( 'after-content' ); ?>

		<?php do_action( 'after_sidebar_after_content' ); ?>

  	</aside><!-- .sidebar -->

<?php endif;  ?>

