<?php
/**
 * Attachment image stream widget.
 *
 * @package ExMachina
 * @subpackage Includes
 * @since 0.1.0
 * @author Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2012 - 2013, Justin Tadlock
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

class ExMachina_Widget_Image_Stream extends WP_Widget {

	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since 0.1.0
	 */
	function __construct() {

		/* Set up the widget options. */
		$widget_options = array(
			'classname' => 'image-stream',
			'description' => __( 'Displays image thumbnails in a gallery-like format.', 'exmachina-core' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width' => 200,
			'height' => 350,
			'id_base' => 'image-stream'
		);

		/* Create the widget. */
		$this->WP_Widget( 'image-stream', __( 'Image Stream', 'exmachina-core' ), $widget_options, $control_options );
	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since 0.1.0
	 */
	function widget( $sidebar, $instance ) {
		extract( $sidebar );

		/* Output the theme's $before_widget wrapper. */
		echo $before_widget;

		/* If a title was input by the user, display it. */
		if ( !empty( $instance['title'] ) )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;

		$loop = new WP_Query(
			array(
				'post_type' => 'attachment',
				'post_mime_type' => 'image',
				'post_status' => 'inherit',
				'posts_per_page' => intval( $instance['posts_per_page'] ),
				'orderby' => 'parent'
			)
		);

		if ( $loop->have_posts() ) {

			/* Set up some default variables to use in the gallery. */
			$gallery_columns = 3;
			$gallery_iterator = 0;

			echo '<div class="gallery">';

			while ( $loop->have_posts() ) {

				$loop->the_post();

				if ( $gallery_columns > 0 && $gallery_iterator % $gallery_columns == 0 ) echo '<div class="gallery-row gallery-clear">';  ?>

						<div class="gallery-item col-<?php echo esc_attr( $gallery_columns ); ?>">
							<div class="gallery-icon">
								<?php get_the_image( array( 'size' => 'thumbnail', 'meta_key' => false, 'default_image' => trailingslashit( get_template_directory_uri() ) . 'images/thumbnail-default.png' ) ); ?>
							</div>
						</div>

				<?php if ( $gallery_columns > 0 && ++$gallery_iterator % $gallery_columns == 0 ) echo '</div>';
			}

			if ( $gallery_columns > 0 && $gallery_iterator % $gallery_columns !== 0 ) echo '</div>';

			echo '</div>';
		}

		else {
			echo '<p>' . __( 'There are currently no images found.', 'exmachina-core' ) . '</p>';
		}

		wp_reset_query();

		/* Output the theme's $after_widget wrapper. */
		echo $after_widget;
	}

	/**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since 0.1.0
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance = $new_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['posts_per_page'] = intval( $new_instance['posts_per_page'] );

		return $instance;
	}

	/**
	 * Displays the widget control options in the Widgets admin screen.
	 *
	 * @since 0.1.0
	 */
	function form( $instance ) {

		/* Set up the default form values. */
		$defaults = array(
			'title' => esc_attr__( 'Image Stream', 'exmachina-core' ),
			'posts_per_page' => 6,
		);

		/* Merge the user-selected arguments with the defaults. */
		$instance = wp_parse_args( (array) $instance, $defaults );

		?>

		<div class="exmachina-widget-controls columns-1">
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'exmachina-core' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'posts_per_page' ); ?>"><?php _e( 'Limit:', 'exmachina-core' ); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'posts_per_page' ); ?>" name="<?php echo $this->get_field_name( 'posts_per_page' ); ?>" value="<?php echo esc_attr( $instance['posts_per_page'] ); ?>" />
		</p>
		</div>
		<div style="clear:both;">&nbsp;</div>
	<?php
	}
}

?>