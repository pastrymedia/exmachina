<div class="entry-meta">
	<?php
	if (is_multi_author()) {
		echo apply_atomic_shortcode( 'entry_author', __( 'Posted by [entry-author] ', 'exmachina' ) );
	} else {
		echo apply_atomic_shortcode( 'entry_author', __( 'Posted ', 'exmachina' ) );
	}?>
	<?php
	if (  hybrid_get_setting( 'trackbacks_posts' ) || hybrid_get_setting( 'comments_posts' ) ) {
		echo apply_atomic_shortcode( 'entry_byline', __( 'on [entry-published] [entry-comments-link before=" | "] [entry-edit-link before=" | "]', 'exmachina' ) );
	} else {
		echo apply_atomic_shortcode( 'entry_byline', __( 'on [entry-published] [entry-edit-link before=" | "]', 'exmachina' ) );
	}

	?>
</div><!-- .entry-meta -->