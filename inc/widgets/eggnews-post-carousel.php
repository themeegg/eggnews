<?php
/**
 * Eggnews: Homepage Featured Slider
 *
 * Homepage slider section with featured section
 *
 * @package Theme Egg
 * @subpackage Eggnews
 * @since 1.0.0
 */

add_action( 'widgets_init', 'eggnews_register_post_carousel_widget' );

function eggnews_register_post_carousel_widget() {
	register_widget( 'Eggnews_Post_Carousel' );
}

class Eggnews_Post_Carousel extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'eggnews_post_carousel clearfix',
			'description' => __( 'Display carousel with posts.', 'eggnews' )
		);
		parent::__construct( 'eggnews_post_carousel', __( 'Carousel Posts', 'eggnews' ), $widget_ops );
	}

	/**
	 * Helper function that holds widget fields
	 * Array is used in update and form functions
	 */
	private function widget_fields() {

		$eggnews_category_dropdown = eggnews_category_dropdown();

		$fields = array(

			'carousel_header_section' => array(
				'eggnews_widgets_name'       => 'carousel_header_section',
				'eggnews_widgets_title'      => __( 'Carousel Section', 'eggnews' ),
				'eggnews_widgets_field_type' => 'widget_section_header'
			),

			'eggnews_carousel_category' => array(
				'eggnews_widgets_name'          => 'eggnews_carousel_category',
				'eggnews_widgets_title'         => __( 'Category for Slider', 'eggnews' ),
				'eggnews_widgets_default'       => 0,
				'eggnews_widgets_field_type'    => 'select',
				'eggnews_widgets_field_options' => $eggnews_category_dropdown
			),

			'eggnews_carousel_count' => array(
				'eggnews_widgets_name'       => 'eggnews_carousel_count',
				'eggnews_widgets_title'      => __( 'No. of slides', 'eggnews' ),
				'eggnews_widgets_default'    => 5,
				'eggnews_widgets_field_type' => 'number'
			),

			'eggnews_carousel_category_random' => array(
				'eggnews_widgets_name'       => 'eggnews_carousel_category_random',
				'eggnews_widgets_title'      => __( 'Show Random', 'eggnews' ),
				'eggnews_widgets_default'    => 1,
				'eggnews_widgets_field_type' => 'checkbox',
			),


		);

		return $fields;
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		extract( $args );
		if ( empty( $instance ) ) {
			return;
		}

		$eggnews_carousel_category_id     = intval( empty( $instance['eggnews_carousel_category'] ) ? null : $instance['eggnews_carousel_category'] );
		$eggnews_carousel_count           = intval( empty( $instance['eggnews_carousel_count'] ) ? 5 : $instance['eggnews_carousel_count'] );
		$eggnews_featured_category_id     = intval( empty( $instance['eggnews_featured_category'] ) ? null : $instance['eggnews_featured_category'] );
		$eggnews_carousel_category_random = intval( empty( $instance['eggnews_carousel_category_random'] ) ? null : $instance['eggnews_carousel_category_random'] );
		echo $before_widget;
		?>
		<div class="teg-carousel-wrapper full-width">
			<div class="teg-carousel-section">
				<?php
				$slider_args = eggnews_query_args( $eggnews_carousel_category_id, $eggnews_carousel_count );

				if ( 1 === $eggnews_carousel_category_random ) {
					$slider_args['orderby'] = 'rand';
				}
				$carousel_query = new WP_Query( $slider_args );

				if ( $carousel_query->have_posts() ) {
					echo '<ul class="eggnewsCarousel">';
					while ( $carousel_query->have_posts() ) {
						$carousel_query->the_post();
						?>
						<li>
							<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
								<figure><?php the_post_thumbnail( 'eggnews-slider-large' ); ?></figure>
							</a>
							<div class="carousel-content-wrapper">

								<h3 class="carousel-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
								</h3>
							</div><!-- .post-meta-wrapper -->
						</li>
						<?php
					}
					echo '</ul>';
				}
				wp_reset_postdata();
				?>
				<div style="clear:both"></div>
			</div><!-- .teg-slider-section -->
		</div><!-- .teg-featured-slider-wrapper -->


		<?php
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see     WP_Widget::update()
	 *
	 * @param    array $new_instance Values just sent to be saved.
	 * @param    array $old_instance Previously saved values from database.
	 *
	 * @uses    eggnews_widgets_updated_field_value()        defined in eggnews-widget-fields.php
	 *
	 * @return    array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$widget_fields = $this->widget_fields();

		// Loop through fields
		foreach ( $widget_fields as $widget_field ) {

			extract( $widget_field );

			// Use helper function to get updated field values
			$instance[ $eggnews_widgets_name ] = eggnews_widgets_updated_field_value( $widget_field, $new_instance[ $eggnews_widgets_name ] );
		}

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see     WP_Widget::form()
	 *
	 * @param    array $instance Previously saved values from database.
	 *
	 * @uses    eggnews_widgets_show_widget_field()        defined in eggnews-widget-fields.php
	 */
	public function form( $instance ) {
		$widget_fields = $this->widget_fields();

		// Loop through fields
		foreach ( $widget_fields as $widget_field ) {

			// Make array elements available as variables
			extract( $widget_field );
			$eggnews_widgets_field_value = ! empty( $instance[ $eggnews_widgets_name ] ) ? wp_kses_post( $instance[ $eggnews_widgets_name ] ) : '';
			eggnews_widgets_show_widget_field( $this, $widget_field, $eggnews_widgets_field_value );
		}
	}

}
