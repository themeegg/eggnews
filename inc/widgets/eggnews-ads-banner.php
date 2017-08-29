<?php
/**
 * Eggnews: Banner Ads
 *
 * Widget show the banner ads size of 728x90 (leaderboard) or large size of (300x250)
 *
 * @package Theme Egg
 * @subpackage Eggnews
 * @since 1.0.0
 */

add_action( 'widgets_init', 'eggnews_register_ads_banner_widget' );

function eggnews_register_ads_banner_widget() {
	register_widget( 'Eggnews_Ads_Banner' );
}

class Eggnews_Ads_Banner extends WP_widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'   => 'eggnews_ads_banner',
			'description' => __( 'You can place banner as advertisement with links.', 'eggnews' )
		);
		parent::__construct( 'eggnews_ads_banner', __( 'Eggnews: Ads Banner', 'eggnews' ), $widget_ops );
	}

	/**
	 * Helper function that holds widget fields
	 * Array is used in update and form functions
	 */
	private function widget_fields() {

		$ads_size = array(
			'leaderboard' => __( 'Leaderboard (728x90)', 'eggnews' ),
			'large'       => __( 'Large (300x250)', 'eggnews' )
		);
		$fields   = array(

			'banner_title' => array(
				'eggnews_widgets_name'       => 'banner_title',
				'eggnews_widgets_title'      => __( 'Title', 'eggnews' ),
				'eggnews_widgets_field_type' => 'text'
			),

			'banner_size' => array(
				'eggnews_widgets_name'          => 'banner_size',
				'eggnews_widgets_title'         => __( 'Ads Size', 'eggnews' ),
				'eggnews_widgets_default'       => 'leaderboard',
				'eggnews_widgets_field_type'    => 'radio',
				'eggnews_widgets_field_options' => $ads_size
			),

			'banner_image' => array(
				'eggnews_widgets_name'       => 'banner_image',
				'eggnews_widgets_title'      => __( 'Add Image', 'eggnews' ),
				'eggnews_widgets_field_type' => 'upload',
			),

			'banner_url' => array(
				'eggnews_widgets_name'       => 'banner_url',
				'eggnews_widgets_title'      => __( 'Add Url', 'eggnews' ),
				'eggnews_widgets_field_type' => 'url'
			),

			'banner_target' => array(
				'eggnews_widgets_name'       => 'banner_target',
				'eggnews_widgets_title'      => __( 'Open in new tab', 'eggnews' ),
				'eggnews_widgets_field_type' => 'checkbox'
			),

			'banner_rel' => array(
				'eggnews_widgets_name'       => 'banner_rel',
				'eggnews_widgets_title'      => __( 'Rel Attribute for URL Link', 'eggnews' ),
				'eggnews_widgets_field_type' => 'checkbox'
			)

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

		$eggnews_banner_title  = empty( $instance['banner_title'] ) ? '' : $instance['banner_title'];
		$eggnews_banner_size   = empty( $instance['banner_size'] ) ? 'leaderboard' : $instance['banner_size'];
		$eggnews_banner_image  = empty( $instance['banner_image'] ) ? '' : $instance['banner_image'];
		$eggnews_banner_url    = empty( $instance['banner_url'] ) ? '' : $instance['banner_url'];
		$eggnews_banner_target = empty( $instance['banner_target'] ) ? '_self' : '_blank';
		$eggnews_banner_rel    = empty( $instance['banner_rel'] ) ? '' : 'nofollow';

		echo $before_widget;

		if ( ! empty( $eggnews_banner_image ) ) {
			?>
			<div class="ads-wrapper <?php echo esc_attr( $eggnews_banner_size ); ?>">
				<?php if ( ! empty( $eggnews_banner_title ) ) { ?>
					<div class="widget-title-wrapper">
						<h4 class="widget-title"><?php echo esc_html( $eggnews_banner_title ); ?></h4>
					</div>
				<?php } ?>
				<?php
				if ( ! empty( $eggnews_banner_url ) ) {
					?>
					<a href="<?php echo esc_url( $eggnews_banner_url ); ?>"
					   target="<?php echo esc_attr( $eggnews_banner_target ); ?>"
					   rel="<?php echo esc_attr( $eggnews_banner_rel ); ?>"><img
							src="<?php echo esc_url( $eggnews_banner_image ); ?>"/></a>
					<?php
				} else {
					?>
					<img src="<?php echo esc_url( $eggnews_banner_image ); ?>"/>
					<?php
				}
				?>
			</div>
			<?php
		}
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see     WP_Widget::update()
	 *
	 * @param   array $new_instance Values just sent to be saved.
	 * @param   array $old_instance Previously saved values from database.
	 *
	 * @uses    eggnews_widgets_updated_field_value()     defined in eggnews-widget-fields.php
	 *
	 * @return  array Updated safe values to be saved.
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
	 * @param   array $instance Previously saved values from database.
	 *
	 * @uses    eggnews_widgets_show_widget_field()       defined in eggnews-widget-fields.php
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
