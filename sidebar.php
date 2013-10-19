<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Sidebar Template
 * sidebar.php
 *
 * The sidebar widget area template.
 * @link http://codex.wordpress.org/Customizing_Your_Sidebar
 *
 * @package <[THEME NAME]>
 * @subpackage Templates
 * @author Machina Themes | @machinathemes
 * @copyright Copyright (c) 2013, Machina Themes
 * @license http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link http://www.machinathemes.com/themes/<[theme-name]>
 */

if ( is_active_sidebar( 'primary' ) ) : ?>

	<aside class="sidebar-primary widget-area <?php echo apply_atomic( 'exmachina_sidebar_class', 'sidebar' );?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">

		<?php do_action( 'before_primary' ); ?>

		<?php dynamic_sidebar( 'primary' ); ?>

		<?php do_action( 'after_primary' ); ?>

  	</aside><!-- .sidebar -->

<?php endif;  ?>

