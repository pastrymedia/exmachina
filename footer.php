<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the class=site-inner div and all content after
 *
 * @package ExMachina
 */
?>
		<?php do_atomic( 'after_main' ); // exmachina_after_main ?>

	</div><!-- .site-inner -->

	<?php get_template_part( 'partials/footer' ); ?>

</div><!-- .site-container -->

<?php do_atomic( 'after' ); // exmachina_after ?>

<?php wp_footer(); ?>

</body>
</html>