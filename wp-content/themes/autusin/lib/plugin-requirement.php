<?php
/***** Active Plugin ********/
require_once( get_template_directory().'/lib/class-tgm-plugin-activation.php' );

add_action( 'tgmpa_register', 'autusin_register_required_plugins' );
function autusin_register_required_plugins() {
    $plugins = array(
		array(
            'name'               => esc_html__( 'WooCommerce', 'autusin' ), 
            'slug'               => 'woocommerce', 
            'required'           => true, 
			'version'			 => '3.4.6'
        ),

        array(
            'name'               => esc_html__( 'Revslider', 'autusin' ), 
            'slug'               => 'revslider', 
            'source'             => get_template_directory() . '/lib/plugins/revslider.zip',  
            'required'           => true, 
            'version'            => '5.4.8'
        ),

        array(
            'name'               => esc_html__( 'One Click Install', 'autusin' ), 
            'slug'               => 'one-click-demo-import', 
            'source'             => get_template_directory() . '/lib/plugins/one-click-demo-import.zip',   
            'required'           => true, 
        ),
        
        array(
            'name'               => esc_html__( 'Visual Composer', 'autusin' ), 
            'slug'               => 'js_composer', 
            'source'             => get_template_directory() . '/lib/plugins/js_composer.zip',  
            'required'           => true, 
            'version'            => '5.5.5'
        ),  
		
		array(
            'name'     			 => esc_html__( 'SW Core', 'autusin' ),
            'slug'      		 => 'sw_core',
            'source'             => get_template_directory() . '/lib/plugins/sw_core.zip',  
            'required'  		 => true,   
			'version'			 => '1.5.0'
		),
		
		array(
            'name'     			 => esc_html__( 'SW WooCommerce', 'autusin' ),
            'slug'      		 => 'sw_woocommerce',
            'source'             => get_template_directory() . '/lib/plugins/sw_woocommerce.zip',   
            'required'  		 => true,
			'version'			 => '1.6.1'
        ),
		
		array(
            'name'     			 => esc_html__( 'SW Ajax Woocommerce Search', 'autusin' ),
            'slug'      		 => 'sw_ajax_woocommerce_search',
            'source'             => get_template_directory() . '/lib/plugins/sw_ajax_woocommerce_search.zip',  
            'required'  		 => true,
			'version'			 => '1.1.5'
        ),
		
		array(
            'name'     			 => esc_html__( 'SW Wooswatches', 'autusin' ),
            'slug'      		 => 'sw_wooswatches',
            'source'             => get_template_directory() . '/lib/plugins/sw_wooswatches.zip',  
            'required'  		 => true,
			'version'			 => '1.0.5'
        ),
				
		array(
            'name'      		 => esc_html__( 'MailChimp for WordPress Lite', 'autusin' ),
            'slug'     			 => 'mailchimp-for-wp',
            'required' 			 => false,
        ),
		array(
            'name'      		 => esc_html__( 'Contact Form 7', 'autusin' ),
            'slug'     			 => 'contact-form-7',
            'required' 			 => false,
        ),
		array(
            'name'      		 => esc_html__( 'YITH Woocommerce Compare', 'autusin' ),
            'slug'      		 => 'yith-woocommerce-compare',
            'required'			 => false
        ),
		 array(
            'name'     			 => esc_html__( 'YITH Woocommerce Wishlist', 'autusin' ),
            'slug'      		 => 'yith-woocommerce-wishlist',
            'required' 			 => false
        ), 
		array(
            'name'     			 => esc_html__( 'WordPress Seo', 'autusin' ),
            'slug'      		 => 'wordpress-seo',
            'required'  		 => false,
        ),

    );		
    $config = array();

    tgmpa( $plugins, $config );

}
add_action( 'vc_before_init', 'autusin_vcSetAsTheme' );
function autusin_vcSetAsTheme() {
    vc_set_as_theme();
}