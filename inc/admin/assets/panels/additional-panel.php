<?php
/**
 * Customizer settings for Additional Settings
 *
 * @package Theme Egg
 * @subpackage Eggnews
 * @since 1.0.0
 */

add_action( 'customize_register', 'eggnews_additional_settings_register' );

function eggnews_additional_settings_register( $wp_customize ) {

	/**
     * Add Additional Settings Panel 
     */
    $wp_customize->add_panel( 
        'eggnews_additional_settings_panel',
        array(
            'priority'       => 7,
            'capability'     => 'edit_theme_options',
            'theme_supports' => '',
            'title'          => __( 'Additional Settings', 'eggnews' ),
        ) 
    );
/*--------------------------------------------------------------------------------------------*/
	// Category Color Section
    $wp_customize->add_section(
        'eggnews_categories_color_section',
        array(
            'title'         => __( 'Categories Color', 'eggnews' ),
            'priority'      => 5,
            'panel'         => 'eggnews_additional_settings_panel',
        )
    );

	$priority = 3;
	$categories = get_terms( 'category' ); // Get all Categories
	$wp_category_list = array();

	foreach ( $categories as $category_list ) {

		$wp_customize->add_setting( 
			'eggnews_category_color_'.esc_html( strtolower( $category_list->name ) ),
			array(
				'default'              => '#408c40',
				'capability'           => 'edit_theme_options',
				'sanitize_callback'    => 'sanitize_hex_color'
			)
		);

		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize, 
				'eggnews_category_color_'.esc_html( strtolower($category_list->name) ),
				array(
					'label'    => sprintf( esc_html__( ' %s', 'eggnews' ), esc_html( $category_list->name ) ),
					'section'  => 'eggnews_categories_color_section',
					'priority' => $priority
				)
			)
		);
		$priority++;
	}
/*--------------------------------------------------------------------------------------------*/
	//Social icons
	$wp_customize->add_section(
        'eggnews_social_media_section',
        array(
            'title'         => __( 'Social Media', 'eggnews' ),
            'priority'      => 10,
            'panel'         => 'eggnews_additional_settings_panel',
        )
    );

	//Add Facebook Link
    $wp_customize->add_setting(
        'social_fb_link',
        array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
        )
    );
    $wp_customize->add_control(
        'social_fb_link',
        array(
            'type' => 'text',
            'priority' => 5,
            'label' => __( 'Facebook', 'eggnews' ),
            'description' => __( 'Your Facebook Account URL', 'eggnews' ),
            'section' => 'eggnews_social_media_section'
        )
    );
    
    //Add twitter Link
    $wp_customize->add_setting(
        'social_tw_link',
        array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
        )
    );
    $wp_customize->add_control(
        'social_tw_link',
        array(
            'type' => 'text',
            'priority' => 6,
            'label' => __( 'Twitter', 'eggnews' ),
            'description' => __( 'Your Twitter Account URL', 'eggnews' ),
            'section' => 'eggnews_social_media_section'
       )
    );
    
    //Add Google plus Link
    $wp_customize->add_setting(
        'social_gp_link',
        array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
        )
    );
    $wp_customize->add_control(
        'social_gp_link',
        array(
            'type' => 'text',
            'priority' => 7,
            'label' => __( 'Google Plus', 'eggnews' ),
            'description' => __( 'Your Google Plus Account URL', 'eggnews' ),
            'section' => 'eggnews_social_media_section'
        )
    );
    
    //Add LinkedIn Link
    $wp_customize->add_setting(
        'social_lnk_link',
        array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
        )
    );
    $wp_customize->add_control(
        'social_lnk_link',
        array(
            'type' => 'text',
            'priority' => 8,
            'label' => __( 'LinkedIn', 'eggnews' ),
            'description' => __( 'Your LinkedIn Account URL', 'eggnews' ),
            'section' => 'eggnews_social_media_section'
        )
    );
    
    //Add youtube Link
    $wp_customize->add_setting(
        'social_yt_link',
        array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
        )
    );
    $wp_customize->add_control(
        'social_yt_link',
        array(
            'type' => 'text',
            'priority' => 9,
            'label' => __( 'YouTube', 'eggnews' ),
            'description' => __( 'Your YouTube Account URL', 'eggnews' ),
            'section' => 'eggnews_social_media_section'
        )
    );
    
    //Add vimeo Link
    $wp_customize->add_setting(
        'social_vm_link',
        array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
        )
    );
    $wp_customize->add_control(
        'social_vm_link',
        array(
            'type' => 'text',
            'priority' => 10,
            'label' => __( 'Vimeo', 'eggnews' ),
            'description' => __( 'Your Vimeo Account URL', 'eggnews' ),
            'section' => 'eggnews_social_media_section'
        )
    );

    //Add Pinterest link
    $wp_customize->add_setting(
        'social_pin_link',
        array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
        )
    );
    $wp_customize->add_control(
        'social_pin_link',
        array(
            'type' => 'text',
            'priority' => 11,
            'label' => __( 'Pinterest', 'eggnews' ),
            'description' => __( 'Your Pinterest Account URL', 'eggnews' ),
            'section' => 'eggnews_social_media_section'
        )
    );

    //Add Instagram link
    $wp_customize->add_setting(
        'social_insta_link',
        array(
            'default' => '',
            'capability' => 'edit_theme_options',
            'transport'=> 'postMessage',
            'sanitize_callback' => 'esc_url_raw'
        )
    );
    $wp_customize->add_control(
        'social_insta_link',
        array(
            'type' => 'text',
            'priority' => 12,
            'label' => __( 'Instagram', 'eggnews' ),
            'description' => __( 'Your Instagram Account URL', 'eggnews' ),
            'section' => 'eggnews_social_media_section'
        )
    );

}