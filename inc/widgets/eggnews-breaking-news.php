<?php
/**
 * Call To Action Widget
 */
add_action( 'widgets_init', 'eggnews_register_breaking_news_widget' );

function eggnews_register_breaking_news_widget() {
	register_widget( 'Eggnews_Breaking_News' );
}
if ( ! class_exists( 'Eggnews_Breaking_News' ) ) {

	class Eggnews_Breaking_News extends WP_Widget {

		function __construct() {
			$widget_ops  = array(
				'classname'   => 'eggnews_breaking_news widget_featured_posts',
				'description' => __( 'Displays the breaking news in the news ticker way. Suitable for the left and right sidebar', 'eggnews' )
			);
			$control_ops = array( 'width' => 200, 'height' => 250 );
			parent::__construct( false, $name = __( 'Breaking News', 'eggnews' ), $widget_ops );
		}

		/**
		 * Helper function that holds widget fields
		 * Array is used in update and form functions
		 */
		private function widget_fields() {

			$eggnews_category_dropdown = eggnews_category_dropdown();

			$fields = array(
				'title'                           => array(
					'eggnews_widgets_name'       => 'title',
					'eggnews_widgets_title'      => esc_html__( 'Title', 'eggnews' ),
					'eggnews_widgets_field_type' => 'text'
				),
				'eggnews_noof_post_show'          => array(
					'eggnews_widgets_name'       => 'eggnews_noof_post_show',
					'eggnews_widgets_title'      => esc_html__( 'No of posts to show.', 'eggnews' ),
					'eggnews_widgets_default'    => 4,
					'eggnews_widgets_field_type' => 'number',
				),
				'eggnews_show_post_from'          => array(
					'eggnews_widgets_name'          => 'eggnews_show_post_from',
					'eggnews_widgets_title'         => esc_html__( 'No. of Posts', 'eggnews' ),
					'eggnews_widgets_default'       => 'latest',
					'eggnews_widgets_field_type'    => 'radio',
					'eggnews_widgets_field_options' => array(
						'latest'   => esc_html__( 'Show latest posts.', 'eggnews' ),
						'category' => esc_html__( 'Show from category', 'eggnews' ),
					),
				),
				'eggnews_select_category'         => array(
					'eggnews_widgets_name'          => 'eggnews_select_category',
					'eggnews_widgets_title'         => esc_html__( 'Select Category', 'eggnews' ),
					'eggnews_widgets_default'       => 0,
					'eggnews_widgets_field_type'    => 'select',
					'eggnews_widgets_field_options' => $eggnews_category_dropdown,
				),
				'eggnews_show_random_posts'       => array(
					'eggnews_widgets_name'       => 'eggnews_show_random_posts',
					'eggnews_widgets_title'      => esc_html__( 'Show random?', 'eggnews' ),
					'eggnews_widgets_default'    => 1,
					'eggnews_widgets_field_type' => 'checkbox'
				),
				'eggnews_breaking_slide_duration' => array(
					'eggnews_widgets_name'       => 'eggnews_breaking_slide_duration',
					'eggnews_widgets_title'      => esc_html__( 'Slider duration(in ms)', 'eggnews' ),
					'eggnews_widgets_default'    => '400',
					'eggnews_widgets_field_type' => 'number',
				),
			);

			return $fields;
		}

		function form( $instance ) {

			$widget_fields = $this->widget_fields();

			// Loop through fields
			foreach ( $widget_fields as $widget_field ) {

				// Make array elements available as variables
				extract( $widget_field );
				$eggnews_widgets_field_value = ! empty( $instance[ $eggnews_widgets_name ] ) ? wp_kses_post( $instance[ $eggnews_widgets_name ] ) : '';
				eggnews_widgets_show_widget_field( $this, $widget_field, $eggnews_widgets_field_value );

			}

		}

		function update( $new_instance, $old_instance ) {

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

		function widget( $args, $instance ) {

			extract( $args );
			if ( empty( $instance ) ) {
				return;
			}
			$title                            = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
			$eggnews_noof_post_show           = empty( $instance['eggnews_noof_post_show'] ) ? 3 : intval( $instance['eggnews_noof_post_show'] );
			$eggnews_show_post_from           = empty( $instance['eggnews_show_post_from'] ) ? 'latest' : esc_attr( $instance['eggnews_show_post_from'] );
			$eggnews_select_category          = empty( $instance['eggnews_select_category'] ) ? 0 : intval( $instance['eggnews_select_category'] );
			$eggnews_show_random_posts        = empty( $instance['eggnews_show_random_posts'] ) ? 0 : intval( $instance['eggnews_show_random_posts'] );
			$eggnews_breaking_slide_direction = empty( $instance['eggnews_breaking_slide_direction'] ) ? 'fade' : esc_attr( $instance['eggnews_breaking_slide_direction'] );
			$eggnews_breaking_slide_duration  = empty( $instance['eggnews_breaking_slide_duration'] ) ? 0 : intval( $instance['eggnews_breaking_slide_duration'] );

			echo $before_widget;
			if ( $eggnews_show_post_from == 'category' && $eggnews_select_category ) {
				eggnews_block_title( $title, $eggnews_select_category );
			} elseif ( $title ) {
				echo $before_title . $title . $after_title;
			}

			$breaking_news_args = array(
				'post_status'    => 'publish',
				'post_type'      => 'post',
				'posts_per_page' => $eggnews_noof_post_show,
			);

			if ( $eggnews_show_post_from == 'category' && $eggnews_select_category ) {
				$breaking_news_args['tax_query'] = array(
					array(
						'taxonomy' => 'category',
						'field'    => 'term_id',
						'terms'    => $eggnews_select_category,
					)
				);
			}

			if ( $eggnews_show_random_posts ) {
				$breaking_news_args['orderby'] = 'rand';
			}

			$eggnews_result = new WP_Query( $breaking_news_args );
			if ( $eggnews_result->have_posts() ):
				$eggnews_result->the_post();
				?>
				<div class="breaking_news_wrap <?php echo esc_attr( $eggnews_breaking_slide_direction ); ?>">
					<ul class="breaking-news-slider"
					    data-direction="<?php echo esc_attr( $eggnews_breaking_slide_direction ); ?>"
					    data-duration="<?php echo esc_attr( $eggnews_breaking_slide_duration ); ?>">
						<?php
						while ( $eggnews_result->have_posts() ):$eggnews_result->the_post();
							?>
							<li <?php post_class(); ?>>

								<?php
								$no_feature_slider = '';
								if ( has_post_thumbnail() ) {
									$no_feature_slider = 'feature_image';
									?>
									<figure class="tabbed-images">
										<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
											<?php the_post_thumbnail( 'eggnews-carousel-image' ); ?>
										</a>
									</figure>
								<?php } ?>
								<div class="article-content  <?php echo esc_attr( $no_feature_slider ); ?>">
									<h6 class="post-title">
										<a href="<?php the_permalink(); ?>"
										   title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
									</h6>
									<div class="post-meta-wrapper">
										<?php eggnews_posted_on(); ?>
										<?php eggnews_post_comment(); ?>
									</div>
								</div>
							</li>
							<?php
						endwhile;
						// Reset Post Data
						wp_reset_query();
						?>
					</ul>
				</div>
				<?php
			endif;

			echo $after_widget;
		}

	}

}
