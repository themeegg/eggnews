<?php
/**
 * Customizer option for Header sections
 *
 * @package Theme Egg
 * @subpackage Eggnews
 * @since 1.0.0
 */

add_action( 'customize_register', 'eggnews_header_settings_register' );

function eggnews_header_settings_register( $wp_customize ) {
    $wp_customize->remove_section( 'header_image' );
	/**
	 * Add header panels
	 */
	$wp_customize->add_panel(
	    'eggnews_header_settings_panel',
	    array(
	        'priority'       => 4,
	        'capability'     => 'edit_theme_options',
	        'theme_supports' => '',
	        'title'          => __( 'Header Settings', 'eggnews' ),
	    ) 
    );
/*----------------------------------------------------------------------------------------------------*/
    /**
     * Top Header Section
     */
    $wp_customize->add_section(
        'eggnews_top_header_section',
        array(
            'title'         => __( 'Top Header Section', 'eggnews' ),
            'priority'      => 5,
            'panel'         => 'eggnews_header_settings_panel'
        )
    );

    // Display Current Date
    $wp_customize->add_setting(
        'eggnews_header_date',
        array(
			'default' => 'enable',
			'capability' => 'edit_theme_options',
            'transport' => 'postMessage',
			'sanitize_callback' => 'eggnews_enable_switch_sanitize'
        )
    );
    $wp_customize->add_control( new Eggnews_Customize_Switch_Control(
        $wp_customize,
            'eggnews_header_date',
            array(
    			'type' => 'switch',
    			'label' => __( 'Current Date Option', 'eggnews' ),
    			'description' => __( 'Enable/disable current date from top header.', 'eggnews' ),
                'priority'      => 4,
    			'section' => 'eggnews_top_header_section',
                'choices' => array(
                    'enable' => __( 'Enable', 'eggnews' ),
                    'disable' => __( 'Disable', 'eggnews' )
                )
    		)
        )
    );

    // Option about top header social icons
    $wp_customize->add_setting(
        'eggnews_header_social_option',
        array(
            'default' => 'enable',
            'capability' => 'edit_theme_options',
            'transport' => 'postMessage',
            'sanitize_callback' => 'eggnews_enable_switch_sanitize'
        )
    );
    $wp_customize->add_control( new Eggnews_Customize_Switch_Control(
        $wp_customize,
            'eggnews_header_social_option',
            array(
                'type' => 'switch',
                'label' => __( 'Social Icon Option', 'eggnews' ),
                'description' => __( 'Enable/disable social icons from top header (right).', 'eggnews' ),
                'priority'      => 5,
                'section' => 'eggnews_top_header_section',
                'choices' => array(
                    'enable' => __( 'Enable', 'eggnews' ),
                    'disable' => __( 'Disable', 'eggnews' )
                )
            )
        )
    );
/*----------------------------------------------------------------------------------------------------*/
    /**
     * Sticky Header
     */
    $wp_customize->add_section(
        'eggnews_sticky_header_section',
        array(
            'title'         => __( 'Sticky Menu', 'eggnews' ),
            'priority'      => 10,
            'panel'         => 'eggnews_header_settings_panel'
        )
    );

    //Sticky header option
    $wp_customize->add_setting(
        'eggnews_sticky_option',
        array(
            'default' => 'enable',
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'eggnews_enable_switch_sanitize'
        )
    );
    $wp_customize->add_control( new Eggnews_Customize_Switch_Control(
        $wp_customize,
            'eggnews_sticky_option',
            array(
                'type' => 'switch',
                'label' => __( 'Menu Sticky', 'eggnews' ),
                'description' => __( 'Enable/disable option for Menu Sticky', 'eggnews' ),
                'priority'      => 4,
                'section' => 'eggnews_sticky_header_section',
                'choices' => array(
                    'enable' => __( 'Enable', 'eggnews' ),
                    'disable' => __( 'Disable', 'eggnews' )
                )
            )
        )
    );

/*----------------------------------------------------------------------------------------------------*/
    /**
     * News Ticker section
     */
    $wp_customize->add_section(
        'eggnews_news_ticker_section',
        array(
            'title'         => __( 'News Ticker Section', 'eggnews' ),
            'priority'      => 15,
            'panel'         => 'eggnews_header_settings_panel'
        )
    );

    //Ticker display option
    $wp_customize->add_setting(
        'eggnews_ticker_option',
        array(
            'default' => 'enable',
            'capability' => 'edit_theme_options',
            'transport' => 'postMessage',
            'sanitize_callback' => 'eggnews_enable_switch_sanitize'
        )
    );
    $wp_customize->add_control( new Eggnews_Customize_Switch_Control(
        $wp_customize,
            'eggnews_ticker_option',
            array(
                'type' => 'switch',
                'label' => __( 'News Ticker Option', 'eggnews' ),
                'description' => __( 'Enable/disable news ticker at header.', 'eggnews' ),
                'priority'      => 4,
                'section' => 'eggnews_news_ticker_section',
                'choices' => array(
                    'enable' => __( 'Enable', 'eggnews' ),
                    'disable' => __( 'Disable', 'eggnews' )
                )
            )
        )
    );

    //Ticker Caption
    $wp_customize->add_setting(
        'eggnews_ticker_caption',
        array(
              'default' => __( 'Latest', 'eggnews' ),
              'capability' => 'edit_theme_options',
              'transport'=> 'postMessage',
              'sanitize_callback' => 'eggnews_sanitize_text',
            )
    );
    $wp_customize->add_control(
        'eggnews_ticker_caption',
        array(
              'type' => 'text',
              'label' => __( 'News Ticker Caption', 'eggnews' ),
              'section' => 'eggnews_news_ticker_section',
              'priority' => 5
            )
    );
}