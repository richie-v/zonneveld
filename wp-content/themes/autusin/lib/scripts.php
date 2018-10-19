<?php
/**
 * Enqueue scripts and stylesheets
 *
 */

function autusin_scripts() {	
	$scheme_meta = get_post_meta( get_the_ID(), 'scheme', true );
	$scheme = ( $scheme_meta != '' && $scheme_meta != 'none' ) ? $scheme_meta : sw_options('scheme');
	$autusin_direction = sw_options('direction');
	
	$app_css 	= get_stylesheet_directory_uri() . '/css/app-default.css';
	$mobile_css = get_stylesheet_directory_uri() . '/css/mobile/mobile-default.css';
	if ( $scheme ){
		$app_css 	= get_stylesheet_directory_uri() . '/css/app-'.$scheme.'.css';
		$mobile_css = get_stylesheet_directory_uri() . '/css/mobile-'.$scheme.'.css';
		
	} 

	/* enqueue script & style */
	if ( !is_admin() ){			
		wp_enqueue_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), null);	
		wp_enqueue_style('autusin', $app_css, array(), null);
		wp_enqueue_script('plugins', get_template_directory_uri() . '/js/jquery.plugin.min.js', array('jquery'), null, true);
		wp_enqueue_script('loadimage', get_template_directory_uri() . '/js/load-image.min.js', array('jquery'), null, true);
		wp_enqueue_script('bootstrap-script', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), null, true);
		wp_enqueue_script('slick-slider',get_template_directory_uri().'/js/slick.min.js',array(),null,true);
		wp_enqueue_script('isotope-script', get_template_directory_uri() . '/js/isotope.js', array(), null, true);
		wp_enqueue_script('wc-quantity', get_template_directory_uri() . '/js/wc-quantity-increment.min.js', array('jquery'), null, true);
		
		if( is_rtl() || $autusin_direction == 'rtl' ){
			wp_enqueue_style('rtl-css', get_template_directory_uri() . '/css/rtl.css', array(), null);
		}
		wp_enqueue_style('autusin-responsive', get_template_directory_uri() . '/css/app-responsive.css', array(), null);
		
		/* Load style.css from child theme */
		if (is_child_theme()) {
			wp_enqueue_style('autusin-child', get_stylesheet_uri(), false, null);
		}
		
		if( !wp_script_is( 'jquery-cookie' ) ){
			wp_enqueue_script('plugins');
		}
	}
	if (is_single() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}		
	
	if( is_admin() ){
		wp_enqueue_style('admin-style', get_template_directory_uri() . '/lib/admin/css/admin.css', array(), null);
	}
	
	if ( !is_admin() ){
		wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/modernizr-2.6.2.min.js', false, null, false);
		
		$translation_text = array(
			'cart_text' 		 => esc_html__( 'Add To Cart', 'autusin' ),
			'compare_text' 	 => esc_html__( 'Add To Compare', 'autusin' ),
			'wishlist_text'  => esc_html__( 'Add To WishList', 'autusin' ),
			'quickview_text' => esc_html__( 'QuickView', 'autusin' ),
			'ajax_url' => admin_url( 'admin-ajax.php', 'relative' ), 
			'redirect' => get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ),
			'message' => esc_html__( 'Please enter your usename and password', 'autusin' ),
		);
		
		wp_localize_script( 'autusin-custom-script', 'custom_text', $translation_text );
		wp_enqueue_script( 'autusin-custom-script', get_template_directory_uri() . '/js/main.js', array(), null, true );
	}
	
	$overflow_text = array(
		'more_text' => esc_html__( 'More...', 'autusin' ),
		'more_menu'	=> sw_options( 'more_menu' )
	);
	wp_register_script('menu-overflow', get_template_directory_uri() . '/js/menu-overflow.js', array(), null, true);
	wp_localize_script( 'menu-overflow', 'menu_text', $overflow_text );
	wp_enqueue_script( 'menu-overflow' );
	
	/*
	** QuickView
	*/
	if( class_exists( 'WooCommerce' ) ) {
		global $woocommerce;
		$assets_path          = str_replace( array( 'http:', 'https:' ), '', WC()->plugin_url() ) . '/assets/';
		$frontend_script_path = $assets_path . 'js/frontend/';
		$wc_ajax_url 					= WC_AJAX::get_endpoint( "%%endpoint%%" );
		$admin_url 						= admin_url('admin-ajax.php');	
		$autusin_dest_folder = ( function_exists( 'sw_wooswatches_construct' ) ) ? 'woocommerce' : 'woocommerce_select';
		$woocommerce_params = array(
			'ajax'  => array(
				'url'	=> $admin_url
			)
		);
		$_wpUtilSettings = array(
			'ajax_url'     => $woocommerce->ajax_url(),
			'wc_ajax_url'  => 	$wc_ajax_url
		);
		$wc_add_to_cart_variation_params = array(
			'i18n_no_matching_variations_text' => esc_attr__( 'Sorry, no products matched your selection. Please choose a different combination.', 'autusin' ),
			'i18n_make_a_selection_text'       => esc_attr__( 'Please select some product options before adding this product to your cart.', 'autusin' ),
			'i18n_unavailable_text'            => esc_attr__( 'Sorry, this product is unavailable. Please choose a different combination.', 'autusin' ),
		);
		
		$quickview_text = array(			
			'ajax_url' => WC_AJAX::get_endpoint( "%%endpoint%%" ), 			
			'wp_embed' => esc_url ( home_url('/') . 'wp-includes/js/wp-embed.min.js' ),
			'underscore' =>  esc_url ( home_url('/') . 'wp-includes/js/underscore.min.js' ),
			'wp_util' =>  esc_url ( home_url('/') . 'wp-includes/js/wp-util.min.js' ),
			'add_to_cart' => esc_url( $frontend_script_path . 'add-to-cart.min.js' ),
			'woocommerce' => esc_url( $frontend_script_path . 'woocommerce.min.js' ),
			'add_to_cart_variable' => esc_url( get_template_directory_uri() . '/js/'. $autusin_dest_folder .'/add-to-cart-variation.min.js' ),
			'wpUtilSettings' => json_encode( $_wpUtilSettings ),
			'woocommerce_params' => json_encode( $woocommerce_params ),
			'wc_add_to_cart_variation_params' => json_encode( $wc_add_to_cart_variation_params )
		);
		wp_register_script('sw-quickview', get_template_directory_uri() . '/js/quickview.js', array(), null, true);
		wp_localize_script( 'sw-quickview', 'quickview_param', $quickview_text );
		wp_enqueue_script( 'sw-quickview' );
		
	}
	
	/*
	** Dequeue and enqueue css, js mobile
	*/
	if( autusin_mobile_check() ) :
		if( is_front_page() || is_home() ) :
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
			wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
		endif;
		if( !sw_options( 'mobile_jquery' ) ){
			wp_dequeue_script( 'tp-tools' );
			wp_dequeue_script( 'revmin' );
		}
		wp_dequeue_style( 'jquery-colorbox' );
		wp_dequeue_style( 'colorbox' );
		wp_dequeue_script( 'jquery-colorbox' );
		wp_dequeue_script( 'isotope-script' );		
		wp_dequeue_script( 'autusin-megamenu' );
		wp_dequeue_script( 'moneyjs' );
		wp_dequeue_script( 'accountingjs' );
		wp_dequeue_script( 'wc-currency-converter' );
		wp_dequeue_script( 'yith-woocompare-main' );
		wp_enqueue_style('autusin-mobile', $mobile_css, array(), null);
	endif;
	
	/*
	** Dequeue some css and jquery mobile responsive
	*/
	
	global $sw_detect;
	if( !empty( $sw_detect ) && $sw_detect->isMobile() && !$sw_detect->isTablet() ){
		wp_dequeue_style( 'jquery-colorbox' );
		wp_dequeue_style( 'colorbox' );
		wp_dequeue_script( 'jquery-colorbox' );
		wp_dequeue_script( 'isotope-script' );
		wp_dequeue_script( 'autusin-megamenu' );
		wp_dequeue_script( 'yith-woocompare-main' );
	}
}
add_action('wp_enqueue_scripts', 'autusin_scripts', 100);

function autusin_admin_script(){	
	wp_enqueue_style('autusin-admin-style', get_template_directory_uri() . '/lib/admin/css/admin.css', array(), null);
}
add_action('admin_enqueue_scripts', 'autusin_admin_script', 100);
