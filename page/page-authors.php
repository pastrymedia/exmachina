<?php
/**
 * Template Name: Authors
 *
 * The Authors page template is for listing the authors of your site.  It shows each author's
 * biographical information and avatar while linking the author's archive page.
 *
 * @package ExMachina
 * @subpackage Template
 * @link http://themeexmachina.com/themes/exmachina/page-templates/authors
 * @deprecated 0.9.0 This template will eventually be moved to the ExMachina page templates pack.
 */

get_header(); // Loads the header.php template. ?>

	<div id="content" class="hfeed content">

		<?php do_atomic( 'before_content' ); // exmachina_before_content ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

			<div id="post-<?php the_ID(); ?>" class="<?php exmachina_post_class(); ?>">

				<?php do_atomic( 'before_entry' ); // exmachina_before_entry ?>

				<div class="entry-content">

					<?php the_content(); ?>

					<?php $users = get_users(); ?>

					<?php foreach ( $users as $author ) : ?>

						<?php $user = new WP_User( $author->ID ); ?>

						<?php if ( $user->has_cap( 'publish_posts' ) || $user->has_cap( 'edit_posts' ) || $user->has_cap( 'publish_pages' ) || $user->has_cap( 'edit_pages' ) ) : ?>

							<div id="hcard-<?php echo str_replace( ' ', '-', get_the_author_meta( 'user_nicename', $author->ID ) ); ?>" class="author-profile vcard clear">

								<a href="<?php echo get_author_posts_url( $author->ID ); ?>" title="<?php the_author_meta( 'display_name', $author->ID ); ?>">
									<?php echo get_avatar( get_the_author_meta( 'user_email', $author->ID ), '100', '', get_the_author_meta( 'display_name', $author->ID ) ); ?>
								</a>
								<h2 class="author-name fn n">
									<a href="<?php echo get_author_posts_url( $author->ID ); ?>" title="<?php the_author_meta( 'display_name', $author->ID ); ?>"><?php the_author_meta( 'display_name', $author->ID ); ?></a>
								</h2>
								<p class="author-bio">
									<?php the_author_meta( 'description', $author->ID ); ?>
								</p><!-- .author-bio -->

							</div><!-- .author-profile .vcard -->

						<?php endif; ?>

					<?php endforeach; ?>

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