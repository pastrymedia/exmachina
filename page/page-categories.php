<?php
/**
 * Template Name: Categories
 *
 * The categories template is a page template that lists your categories along with a link 
 * to the each category's RSS feed and post count.
 *
 * @package ExMachina
 * @subpackage Template
 * @link http://themeexmachina.com/themes/exmachina/page-templates/categories
 * @deprecated 0.9.0 This template will eventually be moved to the ExMachina page templates pack.
 */

get_header(); // Loads the header.php template. ?>

	<div id="content" class="hfeed content">

		<?php do_atomic( 'before_content' ); // exmachina_before_content ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php exmachina_entry_class(); ?>">

				<?php do_atomic( 'before_entry' ); // exmachina_before_entry ?>

				<div class="entry-content">

					<?php the_content(); ?>

					<ul class="xoxo category-archives">
						<?php wp_list_categories( array( 'feed' => __( 'RSS', 'exmachina' ), 'show_count' => true, 'use_desc_for_title' => false, 'title_li' => false ) ); ?>
					</ul><!-- .xoxo .category-archives -->

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