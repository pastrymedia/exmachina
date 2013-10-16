<?php
/**
 * The Template for displaying all single posts.
 *
 * @package ExMachina
 */

get_header(); ?>

	<main class="<?php echo apply_atomic( 'exmachina_main_class', 'content' );?>" role="main" itemprop="mainContentOfPage" itemscope="itemscope" itemtype="http://schema.org/Blog">

		<?php do_atomic( 'before_content' ); // exmachina_before_content ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part( 'partials/content', 'single' ); ?>

			<?php exmachina_content_nav( 'nav-below' ); ?>

			<?php comments_template(); // Loads the comments.php template. ?>

		<?php endwhile; // end of the loop. ?>

		<?php do_atomic( 'after_content' ); // exmachina_after_content ?>

	</main><!-- .content -->

<?php get_footer(); ?>