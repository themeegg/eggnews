<?php
/**
 * Customizer settings for Important Link Panel
 *
 * @package Theme Egg
 * @subpackage Eggnews
 * @since 1.0.0
 */

add_action( 'customize_register', 'eggnews_important_link_panel_register' );

function eggnews_important_link_panel_register( $wp_customize ) {

	// Theme important links started
	class Eggnews_Important_Links extends WP_Customize_Control {

		public $type = "eggnews-important-links";

		public function render_content() {
			//Add Theme instruction, Support Forum, Demo Link, Rating Link
			$important_links = array(
				'view-pro'      => array(
					'link' => esc_url( 'https://goo.gl/bNY8LR' ),
					'text' => esc_html__( 'View Pro', 'eggnews' ),
				),
				'theme-info'    => array(
					'link' => esc_url( 'https://themeegg.com/downloads/eggnews/' ),
					'text' => esc_html__( 'Theme Info', 'eggnews' ),
				),
				'support'       => array(
					'link' => esc_url( 'https://themeegg.com/support-forum/' ),
					'text' => esc_html__( 'Support', 'eggnews' ),
				),
				'documentation' => array(
					'link' => esc_url( 'https://docs.themeegg.com/eggnews/' ),
					'text' => esc_html__( 'Documentation', 'eggnews' ),
				),
				'demo'          => array(
					'link' => esc_url( 'https://demo.themeegg.com/themes/eggnews/' ),
					'text' => esc_html__( 'View Demo', 'eggnews' ),
				),
				'rating'        => array(
					'link' => esc_url( 'https://wordpress.org/support/view/theme-reviews/eggnews?filter=5' ),
					'text' => esc_html__( 'Rate this theme', 'eggnews' ),
				),
			);
			foreach ( $important_links as $important_link ) {
				echo '<p><a target="_blank" href="' . $important_link['link'] . '" >' . esc_attr( $important_link['text'] ) . ' </a></p>';
			}
		}

	}

	$wp_customize->add_section( 'eggnews_important_links', array(
		'priority' => 1,
		'title'    => __( 'Eggnews Important Links', 'eggnews' ),
	) );

	/**
	 * This setting has the dummy Sanitizaition function as it contains no value to be sanitized
	 */
	$wp_customize->add_setting( 'eggnews_important_links', array(
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'eggnews_links_sanitize',
	) );

	$wp_customize->add_control( new Eggnews_Important_Links( $wp_customize, 'important_links', array(
		'label'    => __( 'Important Links', 'eggnews' ),
		'section'  => 'eggnews_important_links',
		'settings' => 'eggnews_important_links',
	) ) );
	// Theme Important Links Ended

}
