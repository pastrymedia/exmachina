<?php
/**
 * @package ExMachina
 */
?>

<article id="post-<?php the_ID(); ?>" class="<?php exmachina_post_class(); ?>" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">

	<div class="entry-wrap">

		<?php do_atomic( 'before_entry' ); // exmachina_before_entry ?>

		<div class="entry-content">

			<?php do_atomic( 'entry' ); // exmachina_entry ?>

		</div><!-- .entry-content -->

		<?php do_atomic( 'after_entry' ); // exmachina_after_entry ?>

	</div><!-- .entry-wrap -->

</article><!-- #post-## -->