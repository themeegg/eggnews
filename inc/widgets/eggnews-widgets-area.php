<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 *
 * @package Theme Egg
 * @subpackage Eggnews
 * @since 1.0.0
 */
function eggnews_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'eggnews' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Left Sidebar', 'eggnews' ),
		'id'            => 'eggnews_left_sidebar',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Header Ads', 'eggnews' ),
		'id'            => 'eggnews_header_ads_area',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'HomePage Slider Area', 'eggnews' ),
		'id'            => 'eggnews_home_slider_area',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'HomePage Content Area', 'eggnews' ),
		'id'            => 'eggnews_home_content_area',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'HomePage Sidebar', 'eggnews' ),
		'id'            => 'eggnews_home_sidebar',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 1st Column', 'eggnews' ),
		'id'            => 'eggnews_footer_one',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 2nd Column', 'eggnews' ),
		'id'            => 'eggnews_footer_two',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 3rd Column', 'eggnews' ),
		'id'            => 'eggnews_footer_three',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Footer 4th Column', 'eggnews' ),
		'id'            => 'eggnews_footer_four',
		'description'   => '',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

}
add_action( 'widgets_init', 'eggnews_widgets_init' );


/**
 * Load widgets files
 */
require get_template_directory() . '/inc/widgets/eggnews-widget-fields.php';
require get_template_directory() . '/inc/widgets/eggnews-featured-slider.php';
require get_template_directory() . '/inc/widgets/eggnews-block-grid.php';
require get_template_directory() . '/inc/widgets/eggnews-block-column.php';
require get_template_directory() . '/inc/widgets/eggnews-ads-banner.php';
require get_template_directory() . '/inc/widgets/eggnews-block-layout.php';
require get_template_directory() . '/inc/widgets/eggnews-posts-list.php';
require get_template_directory() . '/inc/widgets/eggnews-block-list.php';