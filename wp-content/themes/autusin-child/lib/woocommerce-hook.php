<?php 
/*
	* Name: WooCommerce Hook
	* Develop: SmartAddons
*/

/*
** Add WooCommerce support
*/
add_theme_support( 'woocommerce' );

/*
** WooCommerce Compare Version
*/
if( !function_exists( 'sw_woocommerce_version_check' ) ) :
	function sw_woocommerce_version_check( $version = '3.0' ) {
		global $woocommerce;
		if( version_compare( $woocommerce->version, $version, ">=" ) ) {
			return true;
		}else{
			return false;
		}
	}
endif;

/*
** Sales label
*/
if( !function_exists( 'sw_label_sales' ) ){
	function sw_label_sales(){
		global $product, $post;
		$product_type = ( sw_woocommerce_version_check( '3.0' ) ) ? $product->get_type() : $product->product_type;
		echo sw_label_new();
		if( $product_type != 'variable' ) {
			$forginal_price 	= get_post_meta( $post->ID, '_regular_price', true );	
			$fsale_price 		= get_post_meta( $post->ID, '_sale_price', true );
			if( $fsale_price > 0 && $product->is_on_sale() ){ 
				$sale_off = 100 - ( ( $fsale_price/$forginal_price ) * 100 ); 
				$html = '<div class="sale-off ' . esc_attr( ( sw_label_new() != '' ) ? 'has-newicon' : '' ) .'">';
				$html .= '-' . round( $sale_off ).'%';
				$html .= '</div>';
				echo apply_filters( 'sw_label_sales', $html );
			} 
		}else{
			echo '<div class="' . esc_attr( ( sw_label_new() != '' ) ? 'has-newicon' : '' ) .'">';
			wc_get_template( 'single-product/sale-flash.php' );
			echo '</div>';
		}
	}	
}

if( !function_exists( 'sw_label_stock' ) ){
	function sw_label_stock(){
		global $product;
		if( autusin_mobile_check() ) :
	?>
			<div class="product-info">
				<?php $stock = ( $product->is_in_stock() )? 'in-stock' : 'out-stock' ; ?>
				<div class="product-stock <?php echo esc_attr( $stock ); ?>">
					<span><?php echo sprintf( ( $product->is_in_stock() )? '%s' : esc_html__( 'Out stock', 'autusin' ), esc_html__( 'in stock', 'autusin' ) ); ?></span>
				</div>
			</div>

			<?php endif; } 
}

function autusin_quickview(){
	global $product;
	$html='';
	if( function_exists( 'sw_options' ) ){
		$quickview = sw_options( 'product_quickview' );
	}
	if( $quickview ):
		$html = '<a href="javascript:void(0)" data-product_id="'. esc_attr( $product->get_id() ) .'" class="sw-quickview" data-type="quickview" data-ajax_url="' . WC_AJAX::get_endpoint( "%%endpoint%%" ) . '">'. esc_html__( 'Quick View ', 'autusin' ) .'</a>';	
	endif;
	return $html;
}

/*
** Minicart via Ajax
*/
add_action( 'wp', 'autusin_cart_filter' );
function autusin_cart_filter(){
	$autusin_page_header = ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : sw_options('header_style');
	$filter = sw_woocommerce_version_check( $version = '3.0.3' ) ? 'woocommerce_add_to_cart_fragments' : 'add_to_cart_fragments';
	if( $autusin_page_header == 'style6' ):
		add_filter($filter, 'autusin_add_to_cart_fragment_style2', 100);
	elseif( $autusin_page_header == 'style7' ):
		add_filter($filter, 'autusin_add_to_cart_fragment_style3', 100);
	elseif( $autusin_page_header == 'style8' ):
		add_filter($filter, 'autusin_add_to_cart_fragment_style4', 100);
	else :
		add_filter($filter, 'autusin_add_to_cart_fragment', 100);
	endif;
	
	if( autusin_mobile_check() ) :
		add_filter($filter, 'autusin_add_to_cart_fragment_mobile', 100);
	endif;
}
	
function autusin_add_to_cart_fragment_style3( $fragments ) {
	ob_start();
	get_template_part( 'woocommerce/minicart-ajax-style3' );
	$fragments['.autusin-minicart3'] = ob_get_clean();
	return $fragments;		
}

function autusin_add_to_cart_fragment_style2( $fragments ) {
	ob_start();
	get_template_part( 'woocommerce/minicart-ajax-style2' );
	$fragments['.autusin-minicart2'] = ob_get_clean();
	return $fragments;		
}
function autusin_add_to_cart_fragment_style4( $fragments ) {
	ob_start();
	get_template_part( 'woocommerce/minicart-ajax-style4' );
	$fragments['.autusin-minicart4'] = ob_get_clean();
	return $fragments;		
}

function autusin_add_to_cart_fragment( $fragments ) {
	ob_start();
	get_template_part( 'woocommerce/minicart-ajax' );
	$fragments['.autusin-minicart'] = ob_get_clean();
	return $fragments;		
}

function autusin_add_to_cart_fragment_mobile( $fragments ) {
	ob_start();
	get_template_part( 'woocommerce/minicart-ajax-mobile' );
	$fragments['.autusin-minicart-mobile'] = ob_get_clean();
	return $fragments;		
}
	
/*
** Remove WooCommerce breadcrumb
*/
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

/*
** Add second thumbnail loop product
*/
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'autusin_woocommerce_template_loop_product_thumbnail', 10 );

function autusin_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
	global $post;
	$html = '';
	$gallery = get_post_meta($post->ID, '_product_image_gallery', true);
	$attachment_image = '';
	if( !empty( $gallery ) ) {
		$gallery 					= explode( ',', $gallery );
		$first_image_id 	= $gallery[0];
		$attachment_image = wp_get_attachment_image( $first_image_id , $size, false, array('class' => 'hover-image back') );
	}
	
	$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), '' );
	if ( has_post_thumbnail( $post->ID ) ){
		$html .= '<a href="'.get_permalink( $post->ID ).'">' ;
		$html .= (get_the_post_thumbnail( $post->ID, $size )) ? get_the_post_thumbnail( $post->ID, $size ): '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.$size.'.png" alt >';
		$html .= '</a>';
	}else{
		$html .= '<a href="'.get_permalink( $post->ID ).'">' ;
		$html .= '<img src="'.get_template_directory_uri().'/assets/img/placeholder/'.$size.'.png" alt="'. esc_attr__( "No thumb", "autusin") .'">';		
		$html .= '</a>';
	}
	return $html;
}

function autusin_woocommerce_template_loop_product_thumbnail(){
	echo autusin_product_thumbnail();
}

/*
** Product Category Listing
*/
add_filter( 'subcategory_archive_thumbnail_size', 'autusin_category_thumb_size' );
function autusin_category_thumb_size(){
	return 'shop_thumbnail';
}

/*
** Filter order
*/
function autusin_addURLParameter($url, $paramName, $paramValue) {
     $url_data = parse_url($url);
     if(!isset($url_data["query"]))
         $url_data["query"]="";

     $params = array();
     parse_str($url_data['query'], $params);
     $params[$paramName] = $paramValue;
     $url_data['query'] = http_build_query($params);
     return autusin_build_url( $url_data );
}

/*
** Build url 
*/
function autusin_build_url($url_data) {
 $url="";
 if(isset($url_data['host']))
 {
	 $url .= $url_data['scheme'] . '://';
	 if (isset($url_data['user'])) {
		 $url .= $url_data['user'];
			 if (isset($url_data['pass'])) {
				 $url .= ':' . $url_data['pass'];
			 }
		 $url .= '@';
	 }
	 $url .= $url_data['host'];
	 if (isset($url_data['port'])) {
		 $url .= ':' . $url_data['port'];
	 }
 }
 if (isset($url_data['path'])) {
	$url .= $url_data['path'];
 }
 if (isset($url_data['query'])) {
	 $url .= '?' . $url_data['query'];
 }
 if (isset($url_data['fragment'])) {
	 $url .= '#' . $url_data['fragment'];
 }
 return $url;
}

add_action( 'woocommerce_before_main_content', 'autusin_banner_listing', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

add_filter( 'autusin_custom_category', 'woocommerce_maybe_show_product_subcategories' );
add_action( 'woocommerce_before_shop_loop_item_title', 'sw_label_sales', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'autusin_template_loop_price', 10 );
add_action( 'woocommerce_before_shop_loop', 'autusin_viewmode_wrapper_start', 5 );
add_action( 'woocommerce_before_shop_loop', 'autusin_viewmode_wrapper_end', 50 );
add_action( 'woocommerce_before_shop_loop', 'autusin_woocommerce_catalog_ordering', 30 );
add_action( 'woocommerce_before_shop_loop', 'woocommerce_pagination', 35 );
add_action( 'woocommerce_before_shop_loop','autusin_woommerce_view_mode_wrap',15 );
add_action( 'woocommerce_after_shop_loop', 'autusin_viewmode_wrapper_start', 5 );
add_action( 'woocommerce_after_shop_loop', 'autusin_viewmode_wrapper_end', 50 );
add_action( 'woocommerce_after_shop_loop', 'autusin_woommerce_view_mode_wrap', 6 );
add_action( 'woocommerce_after_shop_loop', 'autusin_woocommerce_catalog_ordering', 7 );
remove_action( 'woocommerce_before_shop_loop', 'wc_print_notices', 10 );
add_action('woocommerce_message','wc_print_notices', 10);
add_filter( 'woocommerce_pagination_args', 'autusin_custom_pagination_args' );

/*
** Pagination Size to Show
*/
function autusin_custom_pagination_args( $args = array() ){
	$args['end_size'] = 2;
	$args['mid_size'] = 1;
	return $args;	
}

function autusin_banner_listing(){	
	$banner_enable  = sw_options( 'product_banner' );
	$banner_listing = sw_options( 'product_listing_banner' );
	
	// Check Vendor page of WC MarketPlace
	global $WCMp;
	if ( class_exists( 'WCMp' ) && is_tax($WCMp->taxonomy->taxonomy_name) ) {
		return;
	}
	
	$html = '<div class="widget_sp_image">';
	if( '' === $banner_enable ){
		$html .= ( $banner_listing != '' ) ? '<img src="'. esc_url( $banner_listing ) .'" alt />' : '';
	}else{
		global $wp_query;
		$cat = $wp_query->get_queried_object();
		if( !is_shop() ) {
			$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
			$image = wp_get_attachment_url( $thumbnail_id );
			if( $image ) {
				$html .= '<img src="'. esc_url( $image ) .'" alt />';
			}else{
				$html .= '<img src="'. esc_url( $banner_listing ) .'" alt />';
			}
		}else{
			$html .= ( $banner_listing != '' ) ? '<img src="'. esc_url( $banner_listing ) .'" alt />' : '';
		}
	}
	$html .= '</div>';
	if( !is_singular( 'product' ) ){
		echo sprintf( '%s', $html );
	}
}

function autusin_viewmode_wrapper_start(){
	echo '<div class="products-nav clearfix">';
}
function autusin_viewmode_wrapper_end(){
	echo '</div>';
}
function autusin_woommerce_view_mode_wrap () {
	global $wp_query;

	if ( ! woocommerce_products_will_display() || $wp_query->is_search() ) {
		return;
	}
	
	$html = '<div class="view-mode-wrap pull-left clearfix">
				<div class="view-mode">
						<a href="javascript:void(0)" class="grid-view active" title="'. esc_attr__('Grid view', 'autusin').'"><span>'. esc_html__('Grid view', 'autusin').'</span></a>
						<a href="javascript:void(0)" class="list-view" title="'. esc_attr__('List view', 'autusin') .'"><span>'.esc_html__('List view', 'autusin').'</span></a>
				</div>	
			</div>';
	echo  sprintf( '%s', $html );
}

function autusin_template_loop_price(){
	global $product;
	?>
	<?php if ( $price_html = $product->get_price_html() ) : ?>
		<span class="item-price"><?php echo  sprintf( '%s', $price_html ); ?></span>
	<?php endif;
}

function autusin_woocommerce_catalog_ordering() { 
	global $wp_query;

	if ( 1 === (int) $wp_query->found_posts || ! woocommerce_products_will_display() || $wp_query->is_search() ) {
		return;
	}
	
	$url 		= home_url( add_query_arg( null, null ) );
	$query_str  = parse_url( $url );
	$query 		= isset( $query_str['query'] ) ? $query_str['query'] : '';
	parse_str( $query, $params );
	$query_string 	= isset( $query_str['query'] ) ? '?'.$query_str['query'] : '';
	$option_number 	=  sw_options( 'product_number' );
	
	if( $option_number ) {
		$per_page = $option_number;
	} else {
		$per_page = 12;
	}
	
	$pob = !empty( $params['orderby'] ) ? $params['orderby'] : get_option( 'woocommerce_default_catalog_orderby' );
	$po  = !empty($params['product_order'])  ? $params['product_order'] : 'desc';
	$pc  = !empty($params['product_count']) ? $params['product_count'] : $per_page;

	$html = '';
	$html .= '<div class="catalog-ordering">';

	$html .= '<div class="orderby-order-container clearfix">';
	$html .= '<ul class="orderby order-dropdown pull-left">';
	$html .= '<li>';
	$html .= '<span class="current-li"><span class="current-li-content"><a>'.esc_html__('Sort by Default', 'autusin').'</a></span></span>'; $html .= '<ul>';
	$html .= '<li class="'.( ( $pob == 'menu_order' ) ? 'current': '' ).'"><a href="'.autusin_addURLParameter( $query_string, 'orderby', 'menu_order' ).'">' . esc_html__( 'Sort by Default', 'autusin' ) . '</a></li>';
	$html .= '<li class="'.( ( $pob == 'popularity' ) ? 'current': '' ).'"><a href="'.autusin_addURLParameter( $query_string, 'orderby', 'popularity' ).'">' . esc_html__( 'Sort by Popularity', 'autusin' ) . '</a></li>';
	$html .= '<li class="'.( ( $pob == 'rating' ) ? 'current': '' ).'"><a href="'.autusin_addURLParameter( $query_string, 'orderby', 'rating' ).'">' . esc_html__( 'Sort by Rating', 'autusin' ) . '</a></li>';
	$html .= '<li class="'.( ( $pob == 'date' ) ? 'current': '' ).'"><a href="'.autusin_addURLParameter( $query_string, 'orderby', 'date' ).'">' . esc_html__( 'Sort by Date', 'autusin' ) . '</a></li>';
	$html .= '<li class="'.( ( $pob == 'price' ) ? 'current': '' ).'"><a href="'.autusin_addURLParameter( $query_string, 'orderby', 'price' ).'">' . esc_html__( 'Sort by Price', 'autusin' ) . '</a></li>';
	$html .= '<li class="'.( ( $pob == 'price-desc' ) ? 'current': '' ).'"><a href="'.autusin_addURLParameter( $query_string, 'orderby', 'price-desc' ).'">' . esc_html__( 'Sort by Price ( desc )', 'autusin' ) . '</a></li>';
	$html .= '</ul>';
	$html .= '</li>';
	$html .= '</ul>';
	if( !autusin_mobile_check() ) : 
	$html .= '<ul class="order pull-left">';
	if($po == 'desc'):
	$html .= '<li class="desc"><a href="'.autusin_addURLParameter($query_string, 'product_order', 'asc').'"></a></li>';
	endif;
	if($po == 'asc'):
	$html .= '<li class="asc"><a href="'.autusin_addURLParameter($query_string, 'product_order', 'desc').'"></a></li>';
	endif;
	$html .= '</ul>';
	
	
	$html .= '<div class="product-number pull-left clearfix"><span class="show-product pull-left">'. esc_html__( 'Show', 'autusin' ) . ' </span>';
	$html .= '<ul class="sort-count order-dropdown pull-left">';
	$html .= '<li>';
	$html .= '<span class="current-li"><a>'. $per_page .'</a></span>';
	$html .= '<ul>';
	
	$i = 1;
	while( $i > 0 && $i <= $wp_query->max_num_pages ){
		$html .= '<li class="'.( ( $pc == $per_page* $i ) ? 'current': '').'"><a href="'.autusin_addURLParameter( $query_string, 'product_count', $per_page* $i ).'">'.$per_page* $i.'</a></li>';
		$i++;
	}
	
	$html .= '</ul>';
	$html .= '</li>';
	$html .= '</ul></div>';
	endif;
	
	$html .= '</div>';
	$html .= '</div>';
	if( autusin_mobile_check() ) : 
	$html .= '<div class="filter-product">'. esc_html__('Filter','autusin') .'</div>';
		endif;
	echo  sprintf( '%s', $html );
}

add_action('woocommerce_get_catalog_ordering_args', 'autusin_woocommerce_get_catalog_ordering_args', 20);
function autusin_woocommerce_get_catalog_ordering_args($args)
{
	global $woocommerce;

	$url 		= home_url( add_query_arg( null, null ) );
	$query_str  = parse_url( $url );
	$query 		= isset( $query_str['query'] ) ? $query_str['query'] : '';
	parse_str( $query, $params );
	$orderby_value = !empty( $params['orderby'] ) ? $params['orderby'] : get_option( 'woocommerce_default_catalog_orderby' );
	$pob = $orderby_value;

	$po = !empty($params['product_order'])  ? $params['product_order'] : 'desc';
	
	switch($po) {
		case 'desc':
			$order = 'desc';
		break;
		case 'asc':
			$order = 'asc';
		break;
		default:
			$order = 'desc';
		break;
	}
	$args['order'] = $order;

	if( $pob == 'rating' ) {
		$args['order']    = $po == 'desc' ? 'desc' : 'asc';
		$args['order']	  = strtoupper( $args['order'] );
	}

	return $args;
}

add_filter('loop_shop_per_page', 'autusin_loop_shop_per_page');
function autusin_loop_shop_per_page() {
	$url 		= home_url( add_query_arg( null, null ) );
	$query_str  = parse_url( $url );
	$query 		= isset( $query_str['query'] ) ? $query_str['query'] : '';
	parse_str( $query, $params );
	$option_number =  sw_options( 'product_number' );
	
	if( $option_number ) {
		$per_page = $option_number;
	} else {
		$per_page = 12;
	}

	$pc = !empty($params['product_count']) ? $params['product_count'] : $per_page;
	return $pc;
}

/* =====================================================================================================
** Product loop content 
	 ===================================================================================================== */
	 
/*
** attribute for product listing
*/
function autusin_product_attribute(){
	global $woocommerce_loop;
	
	$col_lg = sw_options( 'product_col_large' );
	$col_md = sw_options( 'product_col_medium' );
	$col_sm = sw_options( 'product_col_sm' );
	$class_col= "item ";
	
	if( isset( get_queried_object()->term_id ) ) :
		$term_col_lg  = get_term_meta( get_queried_object()->term_id, 'term_col_lg', true );
		$term_col_md  = get_term_meta( get_queried_object()->term_id, 'term_col_md', true );
		$term_col_sm  = get_term_meta( get_queried_object()->term_id, 'term_col_sm', true );

		$col_lg = ( intval( $term_col_lg ) > 0 ) ? $term_col_lg : sw_options( 'product_col_large' );
		$col_md = ( intval( $term_col_md ) > 0 ) ? $term_col_md : sw_options( 'product_col_medium' );
		$col_sm = ( intval( $term_col_sm ) > 0 ) ? $term_col_sm : sw_options( 'product_col_sm' );
	endif;
	
	$col_large 	= ( $col_lg ) ? $col_lg : 4;
	$col_medium = ( $col_md ) ? $col_md : 4;
	$col_small	= ( $col_sm ) ? $col_sm : 4;
	
	$column1 = str_replace( '.', '' , floatval( 12 / $col_large ) );
	$column2 = str_replace( '.', '' , floatval( 12 / $col_medium ) );
	$column3 = str_replace( '.', '' , floatval( 12 / $col_small ) );

	$class_col .= ' col-lg-'.$column1.' col-md-'.$column2.' col-sm-'.$column3.' col-xs-6';
	
	return esc_attr( $class_col );
}

/*
** Check sidebar 
*/
function autusin_sidebar_product(){
	$autusin_sidebar_product = sw_options('sidebar_product');
	if( isset( get_queried_object()->term_id ) ){
		$autusin_sidebar_product = ( get_term_meta( get_queried_object()->term_id, 'term_sidebar', true ) != '' ) ? get_term_meta( get_queried_object()->term_id, 'term_sidebar', true ) : sw_options('sidebar_product');
	}	
	if( is_singular( 'product' ) ) {
		$autusin_sidebar_product = ( get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) : sw_options('sidebar_product_detail');
	}
	return $autusin_sidebar_product;
}
	 
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'autusin_loop_product_title', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'autusin_product_description', 11 );
add_action( 'woocommerce_after_shop_loop_item', 'autusin_product_addcart_start', 1 );
add_action( 'woocommerce_after_shop_loop_item', 'autusin_product_addcart_mid', 20 );
add_action( 'woocommerce_after_shop_loop_item', 'autusin_product_addcart_end', 99 );
if( sw_options( 'product_listing_countdown' ) && ( is_shop() || is_tax( 'product_cat' ) || is_tax( 'product_tag' ) || is_post_type_archive( 'product' ) ) ){
	add_action( 'woocommerce_before_shop_loop_item_title', 'autusin_product_deal', 20 );
}

function autusin_loop_product_title(){
	?>
		<h4><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php autusin_trim_words( get_the_title() ); ?></a></h4>
	<?php
}
function autusin_product_description(){
	global $post;
	if ( ! $post->post_excerpt ) return;
	
	echo '<div class="item-description">'.wp_trim_words( $post->post_excerpt, 20 ).'</div>';
}

function autusin_product_addcart_start(){
	echo '<div class="item-bottom clearfix">';
}

function autusin_product_addcart_end(){
	echo '</div>';
}

function autusin_product_addcart_mid(){
	global $product, $post;
	$quickview = sw_options( 'product_quickview' );

	$html ='';
	$product_id = $post->ID;
	/* compare & wishlist */
	if( class_exists( 'YITH_WCWL' ) && !autusin_mobile_check() ){
		$html .= do_shortcode( "[yith_wcwl_add_to_wishlist]" );
	}
	if( class_exists( 'YITH_WOOCOMPARE' ) && !autusin_mobile_check() ){		
		$html .= '<div class="compare-button"><a href="javascript:void(0)" class="compare button" data-product_id="'. $product_id .'" rel="nofollow">'. esc_html__( 'Compare', 'autusin' ) .'</a></div>';	
	}
	$html .= autusin_quickview();
	echo  sprintf( '%s', $html );
}

/*
** Add page deal to listing
*/
function autusin_product_deal(){
	global $product;
	$start_time 	= get_post_meta( $product->get_id(), '_sale_price_dates_from', true );
	$countdown_time = get_post_meta( $product->get_id(), '_sale_price_dates_to', true );	
	
	if( !empty ($countdown_time ) && $countdown_time > $start_time ) :
?>
	<div class="product-countdown" data-date="<?php echo esc_attr( $countdown_time ); ?>" data-starttime="<?php echo esc_attr( $start_time ); ?>" data-cdtime="<?php echo esc_attr( $countdown_time ); ?>" data-id="<?php echo esc_attr( 'product_' . $product->get_id() ); ?>"></div>
<?php 
	endif;
}

/*
** Filter product category class
*/
add_filter( 'product_cat_class', 'autusin_product_category_class', 2 );
function autusin_product_category_class( $classes, $category = null ){
	global $woocommerce_loop;
	
	$col_lg = ( sw_options( 'product_colcat_large' ) )  ? sw_options( 'product_colcat_large' ) : 1;
	$col_md = ( sw_options( 'product_colcat_medium' ) ) ? sw_options( 'product_colcat_medium' ) : 1;
	$col_sm = ( sw_options( 'product_colcat_sm' ) )	   ? sw_options( 'product_colcat_sm' ) : 1;
	
	
	$column1 = str_replace( '.', '' , floatval( 12 / $col_lg ) );
	$column2 = str_replace( '.', '' , floatval( 12 / $col_md ) );
	$column3 = str_replace( '.', '' , floatval( 12 / $col_sm ) );

	$classes[] = ' col-lg-'.$column1.' col-md-'.$column2.' col-sm-'.$column3.' col-xs-6';
	
	return $classes;
}

/* ==========================================================================================
	** Single Product
   ========================================================================================== */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_single_product_summary', 'autusin_get_brand', 15 );
remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
add_action( 'woocommerce_single_product_summary', 'autusin_single_title', 5 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'autusin_woocommerce_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'autusin_woocommerce_sharing', 50 );
add_action( 'woocommerce_before_single_product_summary', 'sw_label_sales', 10 );
add_action( 'woocommerce_before_single_product_summary', 'sw_label_stock', 11 );
if( sw_options( 'product_single_countdown' ) ){
	add_action( 'woocommerce_single_product_summary', 'autusin_product_deal',10 );
}

function autusin_woocommerce_sharing(){
	global $product;
	autusin_get_social();
?>
	<div class="item-meta">
			<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', count( $product->get_category_ids() ), 'autusin' ) . ' ', '</span>' ); ?>

			<?php echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'autusin' ) . ' ', '</span>' ); ?>
	</div>
<?php 
}

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'autusin_product_excerpt', 20 );
function autusin_woocommerce_single_price(){
	wc_get_template( 'single-product/price.php' );
}

function autusin_product_excerpt(){
	global $post;
	
	if ( ! $post->post_excerpt ) {
		return;
	}
	$html = '';
	$html .= '<div class="description" itemprop="description">';
	$html .= apply_filters( 'woocommerce_short_description', $post->post_excerpt );
	$html .= '</div>';
	echo  sprintf( '%s', $html );
}

function autusin_single_title(){
	if( !autusin_mobile_check() || sw_options( 'mobile_header_inside' ) ):
		echo the_title( '<h1 itemprop="name" class="product_title entry-title">', '</h1>' );
	endif;
}

/**
* Get brand on the product single
**/
function autusin_get_brand(){
	global $post;
	$terms = get_the_terms( $post->ID, 'product_brand' );
	if( !isset( $terms->errors ) && $terms ){
?>
		<div class="item-brand">
			<span><?php echo esc_html__( 'Product by', 'autusin' ) . ': '; ?></span>
			<?php 
				foreach( $terms as $key => $term ){
					$thumbnail_id = absint( get_woocommerce_term_meta( $term->term_id, 'thumbnail_bid', true ) );
					if( $thumbnail_id && sw_options( 'product_brand' ) ){
			?>
				<a href="<?php echo get_term_link( $term->term_id, 'product_brand' ); ?>"><img src="<?php echo wp_get_attachment_thumb_url( $thumbnail_id ); ?>" alt title="<?php echo esc_attr( $term->name ); ?>"/></a>				
			<?php 
					}else{
			?>
				<a href="<?php echo get_term_link( $term->term_id, 'product_brand' ); ?>"><?php echo esc_html( $term->name ); ?></a>
				<?php echo( ( $key + 1 ) === count( $terms ) ) ? '' : ', '; ?>
			<?php 
					}					
				}
			?>
		</div>
<?php 
	}
}

add_action( 'woocommerce_before_add_to_cart_button', 'autusin_single_addcart_wrapper_start', 10 );
add_action( 'woocommerce_after_add_to_cart_button', 'autusin_single_addcart_wrapper_end', 20 );
add_action( 'woocommerce_after_add_to_cart_button', 'autusin_single_addcart', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

function autusin_single_addcart_wrapper_start(){
	echo '<div class="addcart-wrapper clearfix">';
}

function autusin_single_addcart_wrapper_end(){
	echo "</div>";
}

function autusin_single_addcart(){
	/* compare & wishlist */
	global $product, $post;
	$html = '';
	$product_id = $post->ID;
	/* compare & wishlist */
	if( ( class_exists( 'YITH_WCWL' ) || class_exists( 'YITH_WOOCOMPARE' ) ) && !autusin_mobile_check() ){
		$html .= '<div class="item-bottom">';	
		if( class_exists( 'YITH_WCWL' ) ) :
			$html .= do_shortcode( "[yith_wcwl_add_to_wishlist]" );
		endif;
		if( class_exists( 'YITH_WOOCOMPARE' ) ) : 
			$html .= '<a href="javascript:void(0)" class="compare button" data-product_id="'. $product_id .'" rel="nofollow">'. esc_html__( 'Compare', 'autusin' ) .'</a>';
		endif;
		$html .= '</div>';
	}
	echo  sprintf( '%s', $html );
}

/* 
** Add Product Tag To Tabs 
*/
add_filter( 'woocommerce_product_tabs', 'autusin_tab_tag' );
function autusin_tab_tag($tabs){
	global $post;
	$tag_count = get_the_terms( $post->ID, 'product_tag' );
	if ( $tag_count ) {
		$tabs['product_tag'] = array(
			'title'    => esc_html__( 'Tags', 'autusin' ),
			'priority' => 11,
			'callback' => 'autusin_single_product_tab_tag'
		);
	}
	return $tabs;
}
function autusin_single_product_tab_tag(){
	global $product;
	echo wc_get_product_tag_list( $product->get_id(), ', ', '<span class="tagged_as">' . _n( 'Tag:', 'Tags:', count( $product->get_tag_ids() ), 'autusin' ) . ' ', '</span>' );
}

/*
**Hook into review for rick snippet
*/
add_action( 'woocommerce_review_before_comment_meta', 'autusin_title_ricksnippet', 10 ) ;
function autusin_title_ricksnippet(){
	global $post;
	echo '<span class="hidden" itemprop="itemReviewed" itemscope itemtype="http://schema.org/Thing">
    <span itemprop="name">'. $post->post_title .'</span>
  </span>';
}

/*
** Cart cross sell
*/
add_action('woocommerce_cart_collaterals', 'autusin_cart_collaterals_start', 1 );
add_action('woocommerce_cart_collaterals', 'autusin_cart_collaterals_end', 11 );
function autusin_cart_collaterals_start(){
	echo '<div class="products-wrapper">';
}

function autusin_cart_collaterals_end(){
	echo '</div>';
}

/*
** Set default value for compare and wishlist 
*/
function autusin_cpwl_init(){
	if( class_exists( 'YITH_WCWL' ) ){
		update_option( 'yith_wcwl_button_position', 'shortcode' );
	}
	if( class_exists( 'YITH_WOOCOMPARE' ) ){
		update_option( 'yith_woocompare_compare_button_in_product_page', 'no' );
		update_option( 'yith_woocompare_compare_button_in_products_list', 'no' );
	}
}
add_action('admin_init','autusin_cpwl_init');

/*
** Quickview product
*/
add_action( 'wc_ajax_autusin_quickviewproduct', 'autusin_quickviewproduct' );
add_action( 'wc_ajax_nopriv_autusin_quickviewproduct', 'autusin_quickviewproduct' );
function autusin_quickviewproduct(){
	
	$productid = ( isset( $_REQUEST["product_id"] ) && $_REQUEST["product_id"] > 0 ) ? $_REQUEST["product_id"] : 0;
	$query_args = array(
		'post_type'	=> 'product',
		'p'	=> $productid
	);
	$outputraw = $output = '';
	$r = new WP_Query( $query_args );
	
	if($r->have_posts()){ 
		while ( $r->have_posts() ){ $r->the_post(); setup_postdata( $r->post );
			global $product;
			ob_start();
			wc_get_template_part( 'content', 'quickview-product' );
			$outputraw = ob_get_contents();
			ob_end_clean();
		}
	}
	$output = preg_replace( array('/\s{2,}/', '/[\t\n]/'), ' ', $outputraw );
	echo sprintf( '%s', $output );
	exit();
}

/*
** Custom Login ajax
*/
add_action('wp_ajax_autusin_custom_login_user', 'autusin_custom_login_user_callback' );
add_action('wp_ajax_nopriv_autusin_custom_login_user', 'autusin_custom_login_user_callback' );
function autusin_custom_login_user_callback(){
	// First check the nonce, if it fails the function will break

	// Nonce is checked, get the POST data and sign user on
	$info = array();
	$info['user_login'] = $_POST['username'];
	$info['user_password'] = $_POST['password'];
	$info['remember'] = true;

	$user_signon = wp_signon( $info, false );
	if ( is_wp_error($user_signon) ){
		echo json_encode(array('loggedin'=>false, 'message'=> $user_signon->get_error_message()));
	} else {
		$redirect_url = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
		$user 		  = get_user_by( 'login', $info['user_login'] );
		$user_role 	  = ( is_array( $user->roles ) ) ? $user->roles : array() ;
		if( in_array( 'vendor', $user_role ) ){
			$vendor_option = get_option( 'wc_prd_vendor_options' );
			$vendor_page   = ( array_key_exists( 'vendor_dashboard_page', $vendor_option ) ) ? $vendor_option['vendor_dashboard_page'] : get_option( 'woocommerce_myaccount_page_id' );
			$redirect_url = get_permalink( $vendor_page );
		}
		elseif( in_array( 'seller', $user_role ) ){
			$vendor_option = get_option( 'dokan_pages' );
			$vendor_page   = ( array_key_exists( 'dashboard', $vendor_option ) ) ? $vendor_option['dashboard'] : get_option( 'woocommerce_myaccount_page_id' );
			$redirect_url = get_permalink( $vendor_page );
		}
		elseif( in_array( 'dc_vendor', $user_role ) ){
			$vendor_option = get_option( 'wcmp_vendor_general_settings_name' );
			$vendor_page   = ( array_key_exists( 'wcmp_vendor', $vendor_option ) ) ? $vendor_option['wcmp_vendor'] : get_option( 'woocommerce_myaccount_page_id' );
			$redirect_url = get_permalink( $vendor_page );
		}
		echo json_encode(array('loggedin'=>true, 'message'=>esc_html__('Login Successful, redirecting...', 'autusin'), 'redirect' => esc_url( $redirect_url ) ));
	}

	die();
}

/*
** Add Label New and SoldOut
*/
if( !function_exists( 'sw_label_new' ) ){
	function sw_label_new(){
		global $product;
		$html = '';
		$newtime = ( get_post_meta( $product->get_id(), 'newproduct', true ) != '' && get_post_meta( $product->get_id(), 'newproduct', true ) ) ? get_post_meta( $product->get_id(), 'newproduct', true ) : sw_options( 'newproduct_time' );
		$product_date = get_the_date( 'Y-m-d', $product->get_id() );
		$newdate = strtotime( $product_date ) + intval( $newtime ) * 24 * 3600;
		if( ! $product->is_in_stock() ) :
			$html .= '<span class="sw-outstock">'. esc_html__( 'Out Stock', 'autusin' ) .'</span>';		
		else:
			if( $newtime != '' && $newdate > time() ) :
				$html .= '<span class="sw-newlabel">'. esc_html__( 'New', 'autusin' ) .'</span>';			
			endif;
		endif;
		return apply_filters( 'sw_label_new', $html );
	}
}

/*
** Check for mobile layout
*/
if( autusin_mobile_check() ){
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_pagination', 35 );
	remove_action( 'woocommerce_after_shop_loop', 'autusin_viewmode_wrapper_start', 5 );
	remove_action( 'woocommerce_after_shop_loop', 'autusin_viewmode_wrapper_end', 50 );
	remove_action( 'woocommerce_after_shop_loop', 'autusin_woommerce_view_mode_wrap', 6 );
	remove_action( 'woocommerce_after_shop_loop', 'autusin_woocommerce_catalog_ordering', 7 );
	remove_action( 'woocommerce_single_product_summary', 'autusin_woocommerce_sharing', 50 );
	add_action( 'woocommerce_single_product_summary', 'autusin_mobile_woocommerce_sharing', 5 );
}

function autusin_mobile_woocommerce_sharing(){
	echo '<div class="item-meta-mobile">';
		autusin_get_social();
		if( class_exists( 'YITH_WCWL' ) ) :
			echo do_shortcode( "[yith_wcwl_add_to_wishlist]" );
		endif;
	echo '</div>';
}