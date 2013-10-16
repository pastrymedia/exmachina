<?php
/**
 * Template Name: Widgets
 *
 * The Widgets template is a page template that is completely widgetized. It houses the 
 * 'Widgets Template' widget area. Customizations to this page should be done through widgets.
 *
 * @package ExMachina
 * @subpackage Template
 * @link http://themeexmachina.com/themes/exmachina/page-templates/widgets
 * @deprecated 0.9.0 Template will be renamed page-template-widgets.php to comply with theme repo guidelines.
 */

get_header(); // Loads the header.php template. ?>

	<div id="content" class="hfeed content">

		<?php do_atomic( 'before_content' ); // exmachina_before_content ?>

		<?php dynamic_sidebar( 'widgets-template' ); ?>

		<?php wp_reset_query(); ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<?php edit_post_link( __( 'Edit', 'exmachina' ), '<p class="entry-meta"><span class="edit">', '</span></p>' ); ?>

			<?php do_atomic( 'after_singular' ); // exmachina_after_singular ?>

			<?php comments_template( '/comments.php', true ); // Loads the comments.php template ?>

			<?php endwhile; ?>

		<?php else: ?>

			<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

		<?php endif; ?>

		<?php do_atomic( 'after_content' ); // exmachina_after_content ?>

	</div><!-- .content .hfeed -->

<?php get_footer(); // Loads the footer.php template. ?>