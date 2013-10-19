<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * Page display
 * page.php
 *
 * @todo bring in actual markup
 *
 * Template file used to render a static page (page post-type)
 * @link http://codex.wordpress.org/Page_Templates
 *
 * @package <[THEME NAME]>
 * @subpackage Templates
 * @author Machina Themes | @machinathemes
 * @copyright Copyright (c) 2013, Machina Themes
 * @license http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link http://www.machinathemes.com/themes/<[theme-name]>
 */

get_header(); ?>

	<main  class="<?php echo apply_atomic( 'exmachina_main_class', 'content' );?>" role="main" itemprop="mainContentOfPage">

			<?php do_atomic( 'before_content' ); // exmachina_before_content ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'partials/content', 'page' ); ?>

				<?php comments_template(); // Loads the comments.php template. ?>

			<?php endwhile; // end of the loop. ?>

			<?php do_atomic( 'after_content' ); // exmachina_after_content ?>

	</main><!-- .content -->

<?php get_footer(); ?>
