<?php


if (! defined('ABSPATH')) {
    exit();
}


class Hatc_Login_Settings {

    /**
     * Bootstraps the class and hooks required actions & filters.
     *
     */
    public static function init() {
        add_filter( 'woocommerce_settings_tabs_array', __CLASS__ . '::add_settings_tab', 50 );
        add_action( 'woocommerce_settings_tabs_hatc_login_settings', __CLASS__ . '::settings_tab' );
        add_action( 'woocommerce_update_options_hatc_login_settings', __CLASS__ . '::update_settings' );
    }
    
    
    /**
     * Add a new settings tab to the WooCommerce settings tabs array.
     *
     * @param array $settings_tabs Array of WooCommerce setting tabs & their labels, excluding the Subscription tab.
     * @return array $settings_tabs Array of WooCommerce setting tabs & their labels, including the Subscription tab.
     */
    public static function add_settings_tab( $settings_tabs ) {
        $settings_tabs['hatc_login_settings'] = __( 'LTSACP Plugin', 'hatc_login_plugin' );
        return $settings_tabs;
    }


    /**
     * Uses the WooCommerce admin fields API to output settings via the @see woocommerce_admin_fields() function.
     *
     * @uses woocommerce_admin_fields()
     * @uses self::get_settings()
     */
    public static function settings_tab() {
        woocommerce_admin_fields( self::get_settings() );
    }


    /**
     * Uses the WooCommerce options API to save settings via the @see woocommerce_update_options() function.
     *
     * @uses woocommerce_update_options()
     * @uses self::get_settings()
     */
    public static function update_settings() {
        woocommerce_update_options( self::get_settings() );
    }


    /**
     * Get all the settings for this plugin for @see woocommerce_admin_fields() function.
     *
     * @return array Array of settings for @see woocommerce_admin_fields() function.
     */
    public static function get_settings() {
		
			$pages = get_pages();
    
        foreach ($pages as $page) {   
                $pages_array[get_page_link($page->ID)] = $page->post_title;
        }

        $settings = array(
            'section_title' => array(
                'name'     => __( 'Login to See Add to Cart and Prices in WooCommerce', 'hatc_login_plugin' ),
                'type'     => 'title',
                'desc'     => __('Check the following options to disable add to cart buttons and hide prices for guest customers','hatc_login_plugin'),
                'id'       => 'wc_settings_section_title'
            ),
			
            'hide_add_to_cart' => array(
                'name' => __( 'Disable add to cart buttons for guest costumers', 'hatc_login_plugin' ),
                'type' => 'checkbox',
                'desc' => __( 'Check to disable add to cart buttons for all products', 'hatc_login_plugin' ),
                'id'   => 'checkbox_hide_add_cart'
            ),
			
			 'custom_add_to_cart_text' => array(
                'name' => __( 'Personalized text for add to cart buttons for guests', 'hatc_login_plugin' ),
                'type' => 'text',
			    'placeholder'  => __('Login to buy','hatc_login_plugin'),
                'id'   => 'wc_settings_add_to_cart_text'
            ),
			
            'redirect_page' => array(
            	'name'     => __( 'Redirect guests to a page', 'hatc_login_plugin' ),
				'id'       => 'option_pages_select',
				'type'     => 'select',
				'class'    => 'wc-enhanced-select',
				'desc'     => __( '', 'hatc_login_plugin' ),
				'options'  => $pages_array
            ),
			
			 'hide_prices' => array(
                'name' => __( 'Hide prices for guest costumers', 'hatc_login_plugin' ),
                'type' => 'checkbox',
                'desc' => __( 'Check to hide prices for all products', 'hatc_login_plugin' ),
                'id'   => 'checkbox_hide_prices'
            ),
			
		      'custom_prices_text' => array(
                'name' => __( 'Personalized text for prices for guests', 'hatc_login_plugin' ),
                'type' => 'text',
			    'placeholder'  => __('Login to see prices','hatc_login_plugin'),
                'id'   => 'wc_settings_prices_text'
            ),
			
            'section_end' => array(
                 'type' => 'sectionend',
                 'id' => 'wc_settings_section_end'
            )
        );

        return apply_filters( 'hatc_login_settings', $settings );
    }

}

Hatc_Login_Settings::init();

