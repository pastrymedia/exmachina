<?php

//* Exit if accessed directly
if ( !defined('ABSPATH')) exit;

/**
 * 404 (Not Found) display
 * 404.php
 *
 * Template file used to render a Server 404 error page.
 * @link http://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package <[THEME NAME]>
 * @subpackage Templates
 * @author Machina Themes | @machinathemes
 * @copyright Copyright (c) 2013, Machina Themes
 * @license http://opensource.org/licenses/gpl-2.0.php GPL-2.0+
 * @link http://www.machinathemes.com/themes/<[theme-name]>
 */

get_header(); ?>

	<main class="content"  role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'exmachina' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'exmachina' ); ?></p>

					<?php get_search_form(); ?>

					<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

					<?php if ( exmachina_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
					<div class="widget widget_categories">
						<h2 class="widgettitle"><?php _e( 'Most Used Categories', 'exmachina' ); ?></h2>
						<ul>
						<?php
							wp_list_categories( array(
								'orderby'    => 'count',
								'order'      => 'DESC',
								'show_count' => 1,
								'title_li'   => '',
								'number'     => 10,
							) );
						?>
						</ul>
					</div><!-- .widget -->
					<?php endif; ?>

					<p>
					<?php _e( "The following is a list of the latest posts from the blog. Maybe it will help you find what you're looking for.", 'exmachina-core' ); ?>
				</p>

					<ul>
					<?php wp_get_archives( array( 'limit' => 20, 'type' => 'postbypost' ) ); ?>
				</ul>

					<?php
					/* translators: %1$s: smiley */
					$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'exmachina' ), convert_smilies( ':)' ) ) . '</p>';
					the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
					?>

					<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

	</main><!-- .content -->

<?php get_footer(); ?>