<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package ExMachina
 */

if ( is_active_sidebar( 'before-content' ) ) : ?>

	<aside class="sidebar-before-content widget-area <?php echo apply_atomic( 'exmachina_sidebar_class', 'sidebar' );?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">

		<?php do_action( 'before_sidebar_before_content' ); ?>

		<?php dynamic_sidebar( 'before-content' ); ?>

		<?php do_action( 'after_sidebar_before_content' ); ?>

  	</aside><!-- .sidebar -->

<?php endif;  ?>

