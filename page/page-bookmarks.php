<?php
/**
 * Template Name: Bookmarks
 *
 * The bookmarks template is a page template that displays a list of all your bookmarks/links
 * by link category below the main content of the page.
 *
 * @package ExMachina
 * @subpackage Template
 * @link http://themeexmachina.com/themes/exmachina/page-templates/bookmarks
 * @deprecated 0.9.0 Template will be renamed page-template-bookmarks.php to comply with theme repo guidelines.
 */

get_header(); // Loads the header.php template. ?>

	<div id="content" class="hfeed content">

		<?php do_atomic( 'before_content' ); // exmachina_before_content ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php exmachina_post_class(); ?>">

				<?php do_atomic( 'before_entry' ); // exmachina_before_entry ?>

				<div class="entry-content">

					<?php the_content(); ?>

					<?php $args = array(
						'title_li' => false,
						'title_before' => '<h2>',
						'title_after' => '</h2>',
						'category_before' => false,
						'category_after' => false,
						'categorize' => true,
						'show_description' => true,
						'between' => '<br />',
						'show_images' => false,
						'show_rating' => false,
					); ?>
					<?php wp_list_bookmarks( $args ); ?>

					<?php wp_link_pages( array( 'before' => '<p class="page-links pages">' . __( 'Pages:', 'exmachina' ), 'after' => '</p>' ) ); ?>

				</div><!-- .entry-content -->

				<?php do_atomic( 'after_entry' ); // exmachina_after_entry ?>

			</div><!-- .hentry -->

			<?php do_atomic( 'after_singular' ); // exmachina_after_singular ?>

			<?php comments_template( '/comments.php', true ); // Loads the comments.php template ?>

			<?php endwhile; ?>

		<?php else: ?>

			<?php get_template_part( 'loop-error' ); // Loads the loop-error.php template. ?>

		<?php endif; ?>

		<?php do_atomic( 'after_content' ); // exmachina_after_content ?>

	</div><!-- .content .hfeed -->

<?php get_footer(); // Loads the footer.php template. ?>