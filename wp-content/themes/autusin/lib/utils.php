<?php 
/**
 * Theme wrapper
 *
 * @link http://scribu.net/wordpress/theme-wrappers.html
 */



/**
 * Page titles
 */
function autusin_title() {
	if (is_home()) {
		if (get_option('page_for_posts', true)) {
			echo get_the_title(get_option('page_for_posts', true));
		} else {
			esc_html_e('Latest Posts', 'autusin');
		}
	} elseif (is_archive()) {
		$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
		if ($term) {
			echo esc_html( $term->name );
		} elseif (is_post_type_archive()) {
			echo get_queried_object()->labels->name;
		} elseif (is_day()) {
			printf(__('Daily Archives: %s', 'autusin'), get_the_date());
		} elseif (is_month()) {
			printf(__('Monthly Archives: %s', 'autusin'), get_the_date('F Y'));
		} elseif (is_year()) {
			printf(__('Yearly Archives: %s', 'autusin'), get_the_date('Y'));
		} elseif (is_author()) {
			printf(__('Author Archives: %s', 'autusin'), get_the_author());
		} else {
			single_cat_title();
		}
	} elseif (is_search()) {
		printf(__('Search Results for <small>%s</small>', 'autusin'), get_search_query());
	} elseif (is_404()) {
		esc_html_e('Not Found', 'autusin');
	} else {
		the_title();
	}
}

/*
** Get content page by ID
*/
function sw_get_the_content_by_id( $post_id ) {
  $page_data = get_page( $post_id );
  if ( $page_data ) {
    $content = do_shortcode( $page_data->post_content );
		return $content;
  }
  else return false;
}

/**
 * Opposite of built in WP functions for trailing slashes
 */
function autusin_leadingslashit($string) {
	return '/' . autusin_unleadingslashit($string);
}

function autusin_unleadingslashit($string) {
	return ltrim($string, '/');
}

function autusin_element_empty($element) {
	$element = trim($element);
	return empty($element) ? false : true;
}
	
/*
** Get Social share
*/
function autusin_get_social() {
	global $post;
	
	$social = sw_options('social_share');	
	
	if ( !$social ) return false;
	ob_start();
?>
	<div class="social-share">
		<div class="title-share"><?php esc_html_e( 'Share','autusin' ) ?></div>
		<div class="wrap-content">
			<a href="http://www.facebook.com/share.php?u=<?php echo get_permalink( $post->ID ); ?>&title=<?php echo get_the_title( $post->ID ); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-facebook"></i></a>
			<a href="http://twitter.com/home?status=<?php echo get_the_title( $post->ID ); ?>+<?php echo get_permalink( $post->ID ); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-twitter"></i></a>
			<a href="https://plus.google.com/share?url=<?php echo get_permalink( $post->ID ); ?>" onclick="javascript:window.open(this.href,'', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;"><i class="fa fa-google-plus"></i></a>				
		</div>
	</div>
<?php 
	$data = ob_get_clean();
	echo sprintf( '%s', $data );

}

/**
 * Use Bootstrap's media object for listing comments
 *
 * @link http://twitter.github.com/bootstrap/components.html#media
 */

function autusin_get_avatar($avatar) {
	$avatar = str_replace("class='avatar", "class='avatar pull-left media-object", $avatar);
	return $avatar;
}
add_filter('get_avatar', 'autusin_get_avatar');


/*
** Check col for sidebar and content product
*/
function autusin_content_product(){ 
	$left_span_class 			= sw_options('sidebar_left_expand');
	$left_span_md_class 	= sw_options('sidebar_left_expand_md');
	$left_span_sm_class 	= sw_options('sidebar_left_expand_sm');
	$right_span_class 		= sw_options('sidebar_right_expand');
	$right_span_md_class 	= sw_options('sidebar_right_expand_md');
	$right_span_sm_class 	= sw_options('sidebar_right_expand_sm');
	$sidebar 							= sw_options('sidebar_product');
	if( !is_post_type_archive( 'product' ) && !is_search() ){
		$term_id = get_queried_object()->term_id;
		$sidebar = ( get_term_meta( $term_id, 'term_sidebar', true ) != '' ) ? get_term_meta( $term_id, 'term_sidebar', true ) : sw_options('sidebar_product');
	}
	
	if( is_active_sidebar('left-product') && is_active_sidebar('right-product') && $sidebar =='lr' ){
		$content_span_class 	= 12 - ( $left_span_class + $right_span_class );
		$content_span_md_class 	= 12 - ( $left_span_md_class +  $right_span_md_class );
		$content_span_sm_class 	= 12 - ( $left_span_sm_class + $right_span_sm_class );
	} 
	elseif( is_active_sidebar('left-product') && $sidebar =='left' ) {
		$content_span_class 		= (	$left_span_class >= 12	) ? 12 : 12 - $left_span_class ;
		$content_span_md_class 	= ( $left_span_md_class >= 12 ) ? 12 : 12 - $left_span_md_class ;
		$content_span_sm_class 	= ( $left_span_sm_class >= 12 ) ? 12 : 12 - $left_span_sm_class ;
	}
	elseif( is_active_sidebar('right-product') && $sidebar =='right' ) {
		$content_span_class 	= ($right_span_class >= 12) ? 12 : 12 - $right_span_class;
		$content_span_md_class 	= ($right_span_md_class >= 12) ? 12 : 12 - $right_span_md_class ;
		$content_span_sm_class 	= ($right_span_sm_class >= 12) ? 12 : 12 - $right_span_sm_class ;
	}
	else {
		$content_span_class 	= 12;
		$content_span_md_class 	= 12;
		$content_span_sm_class 	= 12;
	}
	$classes = array( 'content' );
	
	$classes[] = 'col-lg-'.$content_span_class.' col-md-'.$content_span_md_class .' col-sm-'.$content_span_sm_class;
	
	echo 'class="' . join( ' ', $classes ) . '"';
}

/*
** Check col for sidebar and content product detail
*/
function autusin_content_product_detail(){
	$left_span_class 			= sw_options('sidebar_left_expand');
	$left_span_md_class 	= sw_options('sidebar_left_expand_md');
	$left_span_sm_class 	= sw_options('sidebar_left_expand_sm');
	$right_span_class 		= sw_options('sidebar_right_expand');
	$right_span_md_class 	= sw_options('sidebar_right_expand_md');
	$right_span_sm_class 	= sw_options('sidebar_right_expand_sm');
	$sidebar_template 		= sw_options('sidebar_product_detail');
	
	if( is_singular( 'product' ) ) :
		$sidebar_template = ( get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) : sw_options('sidebar_product_detail');
		$sidebar 					= ( get_post_meta( get_the_ID(), 'page_sidebar_template', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_sidebar_template', true ) : 'left-product-detail';
	endif;
	
	if( is_active_sidebar($sidebar) && $sidebar_template == 'left' ) {
		$content_span_class 		= (	$left_span_class >= 12	) ? 12 : 12 - $left_span_class ;
		$content_span_md_class 	= ( $left_span_md_class >= 12 ) ? 12 : 12 - $left_span_md_class ;
		$content_span_sm_class 	= ( $left_span_sm_class >= 12 ) ? 12 : 12 - $left_span_sm_class ;
	}
	elseif( is_active_sidebar($sidebar) && $sidebar_template == 'right' ) {
		$content_span_class 	= ($right_span_class >= 12) ? 12 : 12 - $right_span_class;
		$content_span_md_class 	= ($right_span_md_class >= 12) ? 12 : 12 - $right_span_md_class ;
		$content_span_sm_class 	= ($right_span_sm_class >= 12) ? 12 : 12 - $right_span_sm_class ;
	}
	else {
		$content_span_class 	= 12;
		$content_span_md_class 	= 12;
		$content_span_sm_class 	= 12;
	}
	$classes = array( 'content' );
	
	$classes[] = 'col-lg-'.$content_span_class.' col-md-'.$content_span_md_class .' col-sm-'.$content_span_sm_class;
	
	echo 'class="' . join( ' ', $classes ) . '"';
}

/*
** Check col for sidebar and content blog
*/
function autusin_content_blog(){
	$left_span_class 		= ( sw_options('sidebar_left_expand') ) ? sw_options('sidebar_left_expand') : 3;
	$left_span_md_class 	= ( sw_options('sidebar_left_expand_md') ) ? sw_options('sidebar_left_expand_md') : 3;
	$left_span_sm_class 	= ( sw_options('sidebar_left_expand_sm') ) ? sw_options('sidebar_left_expand_sm') : 3;
	$right_span_class 		= ( sw_options('sidebar_right_expand') ) ? sw_options('sidebar_right_expand') : 3;
	$right_span_md_class 	= ( sw_options('sidebar_right_expand_md') ) ? sw_options('sidebar_right_expand_md') : 3;
	$right_span_sm_class 	= ( sw_options('sidebar_right_expand_sm') ) ? sw_options('sidebar_right_expand_sm') : 4;
	$sidebar_template 		= ( sw_options('sidebar_blog') ) ? sw_options('sidebar_blog') : '';

	$content_span_class 	= '';
	$content_span_md_class 	= '';
	$content_span_sm_class 	= '';

	if( is_single() ) :
		$sidebar_template = ( strlen( get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) ) > 0 ) ? get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) : $sidebar_template;
	endif;

	if( $sidebar_template ){
		if( is_active_sidebar('left-blog') && $sidebar_template == 'left' ) {
			$content_span_class 	= ($left_span_class >= 12) ? 12 : 12 - $left_span_class ;
			$content_span_md_class 	= ($left_span_md_class >= 12) ? 12 : 12 - $left_span_md_class ;
			$content_span_sm_class 	= ($left_span_sm_class >= 12) ? 12 : 12 - $left_span_sm_class ;
		} 
		elseif( is_active_sidebar('right-blog') && $sidebar_template == 'right' ) {
			$content_span_class 	= ($right_span_class >= 12) ? 12 : 12 - $right_span_class;
			$content_span_md_class 	= ($right_span_md_class >= 12) ? 12 : 12 - $right_span_md_class ;
			$content_span_sm_class 	= ($right_span_sm_class >= 12) ? 12 : 12 - $right_span_sm_class ;
		} 
		else {
			$content_span_class 	= 12;
			$content_span_md_class 	= 12;
			$content_span_sm_class 	= 12;
		}
	}else{

		if( is_active_sidebar('left-blog') && is_active_sidebar('right-blog') ){
			$content_span_class 	= 12 - $left_span_class - $right_span_class;
			$content_span_md_class 	= 12 - $left_span_md_class - $right_span_md_class;
			$content_span_sm_class 	= 12 - $left_span_sm_class - $right_span_sm_class;
		}
		elseif( is_active_sidebar( 'left-blog' ) ) {
			$content_span_class 	= ($left_span_class >= 12) ? 12 : 12 - $left_span_class ;
			$content_span_md_class 	= ($left_span_md_class >= 12) ? 12 : 12 - $left_span_md_class ;
			$content_span_sm_class 	= ($left_span_sm_class >= 12) ? 12 : 12 - $left_span_sm_class ;
		} 
		elseif( is_active_sidebar('right-blog') ) {
			$content_span_class 	= ($right_span_class >= 12) ? 12 : 12 - $right_span_class;
			$content_span_md_class 	= ($right_span_md_class >= 12) ? 12 : 12 - $right_span_md_class ;
			$content_span_sm_class 	= ($right_span_sm_class >= 12) ? 12 : 12 - $right_span_sm_class ;
		} 
		
		else {
			$content_span_class 	= 12;
			$content_span_md_class 	= 12;
			$content_span_sm_class 	= 12;
		}
	}
	$classes = array( '' );
	
	$classes[] = 'col-lg-'.$content_span_class.' col-md-'.$content_span_md_class .' col-sm-'.$content_span_sm_class . ' col-xs-12';
	
	echo  join( ' ', $classes ) ;
}

/*
** Check sidebar blog
*/
function autusin_sidebar_template(){
	$autusin_sidebar_teplate = sw_options('sidebar_blog');
	if( !is_archive() ){
		$autusin_sidebar_teplate = ( get_term_meta( get_queried_object()->term_id, 'term_sidebar', true ) != '' ) ? get_term_meta( get_queried_object()->term_id, 'term_sidebar', true ) : sw_options('sidebar_blog');
	}	
	if( is_single() ) {
		$autusin_sidebar_teplate = ( get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_sidebar_layout', true ) : sw_options('sidebar_blog');
	}
	return $autusin_sidebar_teplate;
}

/*
** Check col for sidebar and content page
*/
function autusin_content_page(){
	$left_span_class 			= sw_options('sidebar_left_expand');
	$left_span_md_class 	= sw_options('sidebar_left_expand_md');
	$left_span_sm_class 	= sw_options('sidebar_left_expand_sm');
	$right_span_class 		= sw_options('sidebar_right_expand');
	$right_span_md_class 	= sw_options('sidebar_right_expand_md');
	$right_span_sm_class 	= sw_options('sidebar_right_expand_sm');
	$sidebar_template 		= get_post_meta( get_the_ID(), 'page_sidebar_layout', true );
	$sidebar 							= get_post_meta( get_the_ID(), 'page_sidebar_template', true );
	
	if( is_active_sidebar( $sidebar ) && $sidebar_template == 'left' ) {
		$content_span_class 		= ( $left_span_class >= 12 ) ? 12 : 12 - $left_span_class ;
		$content_span_md_class 	= ( $left_span_md_class >= 12) ? 12 : 12 - $left_span_md_class ;
		$content_span_sm_class 	= ( $left_span_sm_class >= 12) ? 12 : 12 - $left_span_sm_class ;
	} 
	elseif( is_active_sidebar( $sidebar ) && $sidebar_template == 'right' ) {
		$content_span_class 	= ($right_span_class >= 12) ? 12 : 12 - $right_span_class;
		$content_span_md_class 	= ($right_span_md_class >= 12) ? 12 : 12 - $right_span_md_class ;
		$content_span_sm_class 	= ($right_span_sm_class >= 12) ? 12 : 12 - $right_span_sm_class ;
	} 
	else {
		$content_span_class 	= 12;
		$content_span_md_class 	= 12;
		$content_span_sm_class 	= 12;
	}
	$classes = array( '' );
	
	$classes[] = 'col-lg-'.$content_span_class.' col-md-'.$content_span_md_class .' col-sm-'.$content_span_sm_class . ' col-xs-12';
	
	echo  join( ' ', $classes ) ;
}

/*
** Typography
*/
function autusin_typography_css(){
	$styles = '';
	$page_webfonts  = get_post_meta( get_the_ID(), 'google_webfonts', true );
	$webfont 		= ( $page_webfonts != '' ) ? $page_webfonts : sw_options( 'google_webfonts' );
	$header_webfont = sw_options( 'header_tag_font' );
	$menu_webfont 	= sw_options( 'menu_font' );
	$custom_webfont = sw_options( 'custom_font' );
	$custom_class 	= sw_options( 'custom_font_class' );
	$webfont = ( $webfont == '' ) ? 'Poppins' : $webfont;
	
	$styles = '<style>';
	if ( $webfont ):	
		$webfonts_assign = ( get_post_meta( get_the_ID(), 'webfonts_assign', true ) != '' ) ? get_post_meta( get_the_ID(), 'webfonts_assign', true ) : '';
		if ( $webfonts_assign == 'headers' ){
			$styles .= 'h1, h2, h3, h4, h5, h6 {';
		} else if ( $webfonts_assign == 'custom' ){
			$custom_assign = ( get_post_meta( get_the_ID(), 'webfonts_custom', true ) ) ? get_post_meta( get_the_ID(), 'webfonts_custom', true ) : '';
			$custom_assign = trim($custom_assign);
			if ( !$custom_assign ) return '';
			$styles .= $custom_assign . ' {';
		} else {
			$styles .= 'body, input, button, select, textarea, .search-query {';
		}
		$styles .= 'font-family: ' . esc_attr( $webfont ) . ' !important;}';
	endif;
	
	/* Header webfont */
	if( $header_webfont ) :
		$styles .= 'h1, h2, h3, h4, h5, h6 {';
		$styles .= 'font-family: ' . esc_attr( $header_webfont ) . ' !important;}';
	endif;
	
	/* Menu Webfont */
	if( $menu_webfont ) :
		$styles .= '.primary-menu .menu-title, .vertical_megamenu .menu-title {';
		$styles .= 'font-family: ' . esc_attr( $menu_webfont ) . ' !important;}';
	endif;
	
	/* Custom Webfont */
	if( $custom_webfont && trim( $custom_class ) ) :
		$styles .= $custom_class . ' {';
		$styles .= 'font-family: ' . esc_attr( $custom_webfont ) . ' !important;}';
	endif;
	
	$styles .= '</style>';
	return $styles;
}

function autusin_typography_css_cache(){ 
		
	/* Custom Css */
	if ( sw_options('advanced_css') != '' ){
		echo'<style>'. sw_options( 'advanced_css' ) .'</style>';
	}
	$data = autusin_typography_css();
	echo sprintf( '%s', $data );
}
add_action( 'wp_head', 'autusin_typography_css_cache', 12, 0 );

function autusin_typography_webfonts(){
	$page_google_webfonts = get_post_meta( get_the_ID(), 'google_webfonts', true );
	$webfont 		= ( $page_google_webfonts != '' ) ? $page_google_webfonts : sw_options('google_webfonts');
	$header_webfont = sw_options( 'header_tag_font' );
	$menu_webfont 	= sw_options( 'menu_font' );
	$custom_webfont = sw_options( 'custom_font' );
	$webfont = ( $webfont == '' ) ? 'Poppins' : $webfont;
	
	if ( $webfont || $header_webfont || $menu_webfont || $custom_webfont ):
		$font_url = '';
		$webfont_weight = array();
		$webfont_weight	= ( get_post_meta( get_the_ID(), 'webfonts_weight', true ) ) ? get_post_meta( get_the_ID(), 'webfonts_weight', true ) : sw_options('webfonts_weight');
		$font_weight = '';
		if( empty($webfont_weight) ){
			$font_weight = '300,400,500,600,700';
		}
		else{
			foreach( $webfont_weight as $i => $wf_weight ){
				( $i < 1 )?	$font_weight .= '' : $font_weight .= ',';
				$font_weight .= $wf_weight;
			}
		}
		
		$webfont = $webfont . ':' . $font_weight;
		
		if( $header_webfont ){
			$webfont1 = ( $webfont ) ? '|' . $header_webfont : $header_webfont;
			$webfont .= $webfont1 . ':' . $font_weight;
		}
		
		if( $menu_webfont ){
			$webfont1 = ( $webfont ) ? '|' . $menu_webfont : $menu_webfont;
			$webfont .= $webfont1 . ':' . $font_weight;
		}
		
		if( $custom_webfont ){
			$webfont1 = ( $webfont ) ? '|' . $custom_webfont : $custom_webfont;
			$webfont .= $webfont1 . ':' . $font_weight;
		}
		if ( 'off' !== _x( 'on', 'Google font: on or off', 'autusin' ) ) {
			$font_url = add_query_arg( 'family', urlencode( $webfont ), "//fonts.googleapis.com/css" );
		}
		return $font_url;
	endif;
}

function autusin_googlefonts_script() {
    wp_enqueue_style( 'autusin-googlefonts', autusin_typography_webfonts(), array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'autusin_googlefonts_script' );


/* 
** Get video or iframe from content 
*/
function autusin_get_entry_content_asset( $post_id ){
	global $post;
	$post = get_post( $post_id );
	
	$content = apply_filters ("the_content", $post->post_content);
	
	$value=preg_match('/<iframe.*src=\"(.*)\".*><\/iframe>/isU',$content,$results);
	if($value){
		return $results[0];
	}else{
		return '';
	}
}

function autusin_excerpt($limit) {
  $excerpt = explode(' ', get_the_content(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}

/*
** Tag cloud size
*/
add_filter( 'widget_tag_cloud_args', 'autusin_tag_clound' );
function autusin_tag_clound($args){
	$args['largest'] = 8;
	return $args;
}

/*
** Direction
*/
if( !is_admin() ){
	add_filter( 'language_attributes', 'autusin_direction', 20 );
	function autusin_direction( $doctype = 'html' ){
		$autusin_direction = sw_options( 'direction' );
		if ( ( function_exists( 'is_rtl' ) && is_rtl() ) || $autusin_direction == 'rtl' )
			$autusin_attribute[] = 'dir="rtl"';
		( $autusin_direction === 'rtl' ) ? $lang = 'ar' : $lang = get_bloginfo('language');
		if ( $lang ) {
		if ( get_option('html_type') == 'text/html' || $doctype == 'html' )
			$autusin_attribute[] = "lang=\"$lang\"";

		if ( get_option('html_type') != 'text/html' || $doctype == 'xhtml' )
			$autusin_attribute[] = "xml:lang=\"$lang\"";
		}
		$autusin_output = implode(' ', $autusin_attribute);
		return $autusin_output;
	}
}

/**
 * This class handles the Breadcrumbs generation and display
 */
class autusin_Breadcrumbs {

	/**
	 * Wrapper function for the breadcrumb so it can be output for the supported themes.
	 */
	function breadcrumb_output() {
		$this->breadcrumb( '<div class="breadcumbs">', '</div>' );
	}

	/**
	 * Get a term's parents.
	 *
	 * @param object $term Term to get the parents for
	 * @return array
	 */
	function get_term_parents( $term ) {
		$tax     = $term->taxonomy;
		$parents = array();
		while ( $term->parent != 0 ) {
			$term      = get_term( $term->parent, $tax );
			$parents[] = $term;
		}
		return array_reverse( $parents );
	}

	/**
	 * Display or return the full breadcrumb path.
	 *
	 * @param string $before  The prefix for the breadcrumb, usually something like "You're here".
	 * @param string $after   The suffix for the breadcrumb.
	 * @param bool   $display When true, echo the breadcrumb, if not, return it as a string.
	 * @return string
	 */
	function breadcrumb( $before = '', $after = '', $display = true ) {
		$options = array('breadcrumbs-home' => esc_html__( 'Home', 'autusin' ), 'breadcrumbs-blog-remove' => false, 'post_types-post-maintax' => '0');
		
		global $wp_query, $post;	
		$on_front  = get_option( 'show_on_front' );
		$blog_page = get_option( 'page_for_posts' );

		$links = array(
			array(
				'url'  => get_home_url(),
				'text' => ( isset( $options['breadcrumbs-home'] ) && $options['breadcrumbs-home'] != '' ) ? $options['breadcrumbs-home'] : esc_html__( 'Home', 'autusin' )
			)
		);

		if ( ( $on_front == "page" && is_front_page() ) || ( $on_front == "posts" && is_home() ) ) {

		} else if ( $on_front == "page" && is_home() ) {
			$links[] = array( 'id' => $blog_page );
		} else if ( is_singular() ) {		
			$tax = get_object_taxonomies( $post->post_type );
			if ( 0 == $post->post_parent ) {
				if ( isset( $tax ) && count( $tax ) > 0 ) {
					$main_tax = $tax[0];
					if( $post->post_type == 'product' ){
						$main_tax = 'product_cat';
					}					
					$terms    = wp_get_object_terms( $post->ID, $main_tax );
					
					if ( count( $terms ) > 0 ) {
						// Let's find the deepest term in this array, by looping through and then unsetting every term that is used as a parent by another one in the array.
						$terms_by_id = array();
						foreach ( $terms as $term ) {
							$terms_by_id[$term->term_id] = $term;
						}
						foreach ( $terms as $term ) {
							unset( $terms_by_id[$term->parent] );
						}

						// As we could still have two subcategories, from different parent categories, let's pick the first.
						reset( $terms_by_id );
						$deepest_term = current( $terms_by_id );

						if ( is_taxonomy_hierarchical( $main_tax ) && $deepest_term->parent != 0 ) {
							foreach ( $this->get_term_parents( $deepest_term ) as $parent_term ) {
								$links[] = array( 'term' => $parent_term );
							}
						}
						$links[] = array( 'term' => $deepest_term );
					}

				}
			} else {
				if ( isset( $post->ancestors ) ) {
					if ( is_array( $post->ancestors ) )
						$ancestors = array_values( $post->ancestors );
					else
						$ancestors = array( $post->ancestors );
				} else {
					$ancestors = array( $post->post_parent );
				}

				// Reverse the order so it's oldest to newest
				$ancestors = array_reverse( $ancestors );

				foreach ( $ancestors as $ancestor ) {
					$links[] = array( 'id' => $ancestor );
				}
			}
			$links[] = array( 'id' => $post->ID );
		} else {
			if ( is_post_type_archive() ) {
				$links[] = array( 'ptarchive' => get_post_type() );
			} else if ( is_tax() || is_tag() || is_category() ) {
				$term = $wp_query->get_queried_object();

				if ( is_taxonomy_hierarchical( $term->taxonomy ) && $term->parent != 0 ) {
					foreach ( $this->get_term_parents( $term ) as $parent_term ) {
						$links[] = array( 'term' => $parent_term );
					}
				}

				$links[] = array( 'term' => $term );
			} else if ( is_date() ) {
				$bc = esc_html__( 'Archives for', 'autusin' );
				
				if ( is_day() ) {
					global $wp_locale;
					$links[] = array(
						'url'  => get_month_link( get_query_var( 'year' ), get_query_var( 'monthnum' ) ),
						'text' => $wp_locale->get_month( get_query_var( 'monthnum' ) ) . ' ' . get_query_var( 'year' )
					);
					$links[] = array( 'text' => $bc . " " . get_the_date() );
				} else if ( is_month() ) {
					$links[] = array( 'text' => $bc . " " . single_month_title( ' ', false ) );
				} else if ( is_year() ) {
					$links[] = array( 'text' => $bc . " " . get_query_var( 'year' ) );
				}
			} elseif ( is_author() ) {
				$bc = esc_html__( 'Archives for', 'autusin' );
				$user    = $wp_query->get_queried_object();
				$links[] = array( 'text' => $bc . " " . esc_html( $user->display_name ) );
			} elseif ( is_search() ) {
				$bc = esc_html__( 'You searched for', 'autusin' );
				$links[] = array( 'text' => $bc . ' "' . esc_html( get_search_query() ) . '"' );
			} elseif ( is_404() ) {
				$crumb404 = esc_html__( 'Error 404: Page not found', 'autusin' );
				$links[] = array( 'text' => $crumb404 );
			}
		}
		
		$output = $this->create_breadcrumbs_string( $links );

		if ( $display ) {
			echo sprintf( $before . '%s' . $after, $output );
			return true;
		} else {
			return $before . $output . $after;
		}
	}

	/**
	 * Take the links array and return a full breadcrumb string.
	 *
	 * Each element of the links array can either have one of these keys:
	 * "id"            for post types;
	 * "ptarchive"  for a post type archive;
	 * "term"         for a taxonomy term.
	 * If either of these 3 are set, the url and text are retrieved. If not, url and text have to be set.
	 *
	 * @link http://support.google.com/webmasters/bin/answer.py?hl=en&answer=185417 Google documentation on RDFA
	 *
	 * @param array  $links   The links that should be contained in the breadcrumb.
	 * @param string $wrapper The wrapping element for the entire breadcrumb path.
	 * @param string $element The wrapping element for each individual link.
	 * @return string
	 */
	function create_breadcrumbs_string( $links, $wrapper = 'ul', $element = 'li' ) {
		global $paged;
		
		$output = '';

		foreach ( $links as $i => $link ) {

			if ( isset( $link['id'] ) ) {
				$link['url']  = get_permalink( $link['id'] );
				$link['text'] = strip_tags( get_the_title( $link['id'] ) );
			}

			if ( isset( $link['term'] ) ) {
				$link['url']  = get_term_link( $link['term'] );
				$link['text'] = $link['term']->name;
			}

			if ( isset( $link['ptarchive'] ) ) {
				$post_type_obj = get_post_type_object( $link['ptarchive'] );
				$archive_title = $post_type_obj->labels->menu_name;
				$link['url']  = get_post_type_archive_link( $link['ptarchive'] );
				$link['text'] = $archive_title;
			}
			
			$link_class = '';
			if ( isset( $link['url'] ) && ( $i < ( count( $links ) - 1 ) || $paged ) ) {
				$link_output = '<a href="' . esc_url( $link['url'] ) . '" >' . esc_html( $link['text'] ) . '</a><span class="go-page"></span>';
			} else {
				$link_class = ' class="active" ';
				$link_output = '<span>' . esc_html( $link['text'] ) . '</span>';
			}
			
			$element = esc_attr(  $element );
			$element_output = '<' . $element . $link_class . '>' . $link_output . '</' . $element . '>';
			
			$output .=  $element_output;
			
			$class = ' class="breadcrumb" ';
		}

		return '<' . $wrapper . $class . '>' . $output . '</' . $wrapper . '>';
	}

}

global $autusin_breadcrumb;
$autusin_breadcrumb = new autusin_Breadcrumbs();

if ( !function_exists( 'autusin_breadcrumb' ) ) {
	/**
	 * Template tag for breadcrumbs.
	 *
	 * @param string $before  What to show before the breadcrumb.
	 * @param string $after   What to show after the breadcrumb.
	 * @param bool   $display Whether to display the breadcrumb (true) or return it (false).
	 * @return string
	 */
	function autusin_breadcrumb( $before = '', $after = '', $display = true ) {
		global $autusin_breadcrumb;
		
		/* Turn off Breadcrumb */
		if( sw_options( 'breadcrumb_active' ) ) :
			$display = false;
		endif;
		return $autusin_breadcrumb->breadcrumb( $before, $after, $display );
	}
}


/*
** Footer Adnvanced
*/
add_action( 'wp_footer', 'autusin_footer_advanced' );
function autusin_footer_advanced(){
	/* 
	** Back To Top 
	*/
	if( sw_options( 'back_active' ) ) :
		echo '<a id="autusin-totop" href="#" ></a>';
	endif;
	
	/* 
	** Popup 
	*/
	if( sw_options( 'popup_active' ) ) :
		$autusin_content = sw_options( 'popup_content' );
		$autusin_shortcode = sw_options( 'popup_form' );
		$popup_attr = ( sw_options( 'popup_background' ) != '' ) ? 'style="background: url( '. esc_url( sw_options( 'popup_background' ) ) .' )"' : '';
?>
		<div id="subscribe_popup" class="subscribe-popup"<?php echo sprintf( '%s', $popup_attr ); ?>>
			<div class="subscribe-popup-container">
				<?php if( $autusin_content != '' ) : ?>
				<div class="popup-content">
					<?php echo sprintf( '%s', $autusin_content ); ?>
				</div>
				<?php endif; ?>
				
				<?php if( $autusin_shortcode != '' ) : ?>
				<div class="subscribe-form">
					<?php	echo do_shortcode( $autusin_shortcode ); ?>
				</div>
				<?php endif; ?>
				
				<div class="subscribe-checkbox">
					<label for="popup_check">
						<input id="popup_check" name="popup_check" type="checkbox" />
						<?php echo '<span>' . esc_html__( "Don't show this popup again!", "autusin" ) . '</span>'; ?>
					</label>
				</div>				
			</div>
			<div class="subscribe-social">
				<h3><?php echo esc_html__('follow us','autusin'); ?></h3>
				<div class="subscribe-social-inner">
					<?php sw_social_link() ?>
				</div>
			</div>
		</div>
	<?php 
	endif;
	
	/*
	** Login Form 
	*/
	if( class_exists( 'WooCommerce' ) ){		
?>
	<div class="modal fade" id="login_form" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog block-popup-login">
			<?php ob_start(); ?>
			<a href="javascript:void(0)" title="<?php esc_attr_e( 'Close', 'autusin' ) ?>" class="close close-login" data-dismiss="modal"><?php esc_html_e( 'Close', 'autusin' ) ?></a>
			<div class="tt_popup_login"><strong><?php esc_html_e('Sign in Or Register', 'autusin'); ?></strong></div>
			<?php get_template_part('woocommerce/myaccount/login-form'); ?>
			<?php 
				if( class_exists( 'APSL_Lite_Class' ) ) :
					echo '<div class="login-line"><span>'. esc_html__( 'Or', 'autusin' ) .'</span></div>';
						echo do_shortcode('[apsl-login-lite]'); 
				endif;
				
				$html = ob_get_clean();
				echo apply_filters( 'autusin_custom_login_filter', $html );
			?>
		</div>
	</div>
<?php 	
	
	/*
	** Quickview Footer
	*/
	if( sw_options( 'product_quickview' ) ){
?>
	<div class="sw-quickview-bottom">
		<div class="quickview-content" id="quickview_content">
			<a href="javascript:void(0)" class="quickview-close">x</a>
			<div class="quickview-inner"></div>
		</div>	
	</div>
<?php 
		}
	}
	
	/*
	** Search form to footer
	*/
?>
	<div class="modal fade" id="search_form" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog block-popup-search-form">
			<form role="search" method="get" class="form-search searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input type="text" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" class="search-query" placeholder="<?php esc_attr_e( 'Enter your keyword...', 'autusin' ) ?>">
				<button type="submit" class=" fa fa-search button-search-pro form-button"></button>
				<a href="javascript:void(0)" title="<?php esc_attr_e( 'Close', 'autusin' ) ?>" class="close close-search" data-dismiss="modal"><?php esc_html_e( 'X', 'autusin' ) ?></a>
			</form>
		</div>
	</div>
<?php 
}

/**
* Popup Newsletter & Menu Sticky
**/
function autusin_advanced(){	
	$autusin_popup	 		= sw_options( 'popup_active' );
	$sticky_mobile	 		= sw_options( 'sticky_mobile' );
	$output  = '';
	$output .= '(function($) {';
	if( !autusin_mobile_check() ) : 
		$sticky_menu 		= sw_options( 'sticky_menu' );
		$autusin_header_style 	= ( get_post_meta( get_the_ID(), 'page_header_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_header_style', true ) : sw_options('header_style');
		$output_css = '';
		$layout = sw_options('layout');
		$bg_image = sw_options('bg_box_img');
		$header_mid = sw_options('header_mid');
		$bg_header_mid = sw_options('bg_header_mid');			
		
		if( $layout == 'boxed' ){
			$output_css .= 'body{';		
			$output_css .= ( $bg_image != '' ) ? 'background-image: url('.esc_attr( $bg_image ).');
				background-position: top center; 
				background-attachment: fixed;' : '';
			$output_css .= '}';
			wp_enqueue_style(	'autusin-custom-style',	get_template_directory_uri() . '/css/custom_css.css' );
			wp_add_inline_style( 'autusin-custom-style', $output_css );
		}
		
		/*
		** Add background header mid
		*/
		
		if( $header_mid ){
			$output_css .= '#header .header-mid{';		
			$output_css .= ( $bg_header_mid != '' ) ? 'background-image: url('.esc_attr( $bg_header_mid ).');
				background-position: top center; 
				background-attachment: fixed;' : '';
			$output_css .= '}';
			wp_enqueue_style(	'autusin-custom-style',	get_template_directory_uri() . '/css/custom_css.css' );
			wp_add_inline_style( 'autusin-custom-style', $output_css );
		}
		
		/*
		** Menu Sticky 
		*/
		if( $sticky_menu ) :		
				if( $autusin_header_style == 'style1' || $autusin_header_style == ''){			
					$output .= 'var sticky_navigation_offset = $("#header .header-bottom").offset();';
					$output .= 'if( typeof sticky_navigation_offset != "undefined" ) {';
					$output .= 'var sticky_navigation_offset_top = sticky_navigation_offset.top;';
					$output .= 'var sticky_navigation = function(){';
					$output .= 'var scroll_top = $(window).scrollTop();';
					$output .= 'if (scroll_top > sticky_navigation_offset_top) {';
					$output .= '$("#header .header-mid").addClass("sticky-menu");';
					$output .= '$("#header .header-mid").css({ "top":0, "left":0, "right" : 0 });';
					$output .= '} else {';
					$output .= '$("#header .header-mid").removeClass("sticky-menu");';
					$output .= '}';
					$output .= '};';
					$output .= 'sticky_navigation();';
					$output .= '$(window).scroll(function() {';
					$output .= 'sticky_navigation();';
					$output .= '}); }';
				}
				elseif( $autusin_header_style == 'style11' ){
					$output .= 'var sticky_navigation = function(){';
					$output .= 'var scroll_top = $(window).scrollTop();';
					$output .= 'if ( scroll_top > 100) {';
					$output .= '$("#header .header-mid").addClass("sticky-menu");';
					$output .= '$("#header .header-mid").css({ "top":0, "left":0, "right" : 0 });';
					$output .= '} else {';
					$output .= '$("#header .header-mid").removeClass("sticky-menu");';
					$output .= '}';
					$output .= '};';
					$output .= 'sticky_navigation();';
					$output .= '$(window).scroll(function() {';
					$output .= 'sticky_navigation();';
					$output .= '}); ';
				}
				elseif( $autusin_header_style == 'style2' || $autusin_header_style == 'style3' || $autusin_header_style == 'style5' || $autusin_header_style == 'style6' || $autusin_header_style == 'style7' || $autusin_header_style == 'style8'|| $autusin_header_style == 'style9'
				        || $autusin_header_style == 'style10' || $autusin_header_style == 'style12'){
					$output .= 'var sticky_navigation_offset = $("#header .header-bottom").offset();';
					$output .= 'if( typeof sticky_navigation_offset != "undefined" ) {';
					$output .= 'var sticky_navigation_offset_top = sticky_navigation_offset.top;';
					$output .= 'var sticky_navigation = function(){';
					$output .= 'var scroll_top = $(window).scrollTop();';
					$output .= 'if (scroll_top > sticky_navigation_offset_top) {';
					$output .= '$("#header .header-bottom").addClass("sticky-menu");';
					$output .= '$("#header .header-mid").addClass("sticky-mid");';
					$output .= '$("#header .header-bottom").css({ "top":0, "left":0, "right" : 0 });';
					$output .= '} else {';
					$output .= '$("#header .header-bottom").removeClass("sticky-menu");';
					$output .= '$("#header .header-mid").removeClass("sticky-mid");';
					$output .= '}';
					$output .= '};';
					$output .= 'sticky_navigation();';
					$output .= '$(window).scroll(function() {';
					$output .= 'sticky_navigation();';
					$output .= '}); }';
				}
			endif;
			
			/*
			** Adnvanced JS
			*/
			if( sw_options( 'advanced_js' ) != '' ) :
				$output .= sw_options( 'advanced_js' );
			endif;
			
		endif;			
			/*
			** Popup Newsletter
			*/
			if( $autusin_popup ){
				$output .= '$(document).ready(function() {
						var check_cookie = $.cookie("subscribe_popup");
						if(check_cookie == null || check_cookie == "shown") {
							 popupNewsletter();
						 }
						$("#subscribe_popup input#popup_check").on("click", function(){
							if($(this).parent().find("input:checked").length){        
								var check_cookie = $.cookie("subscribe_popup");
								 if(check_cookie == null || check_cookie == "shown") {
									$.cookie("subscribe_popup","dontshowitagain");            
								}
								else
								{
									$.cookie("subscribe_popup","shown");
									popupNewsletter();
								}
							} else {
								$.cookie("subscribe_popup","shown");
							}
						}); 
					});

					function popupNewsletter() {
						jQuery.fancybox({
							href: "#subscribe_popup",
							autoResize: true
						});
						jQuery("#subscribe_popup").trigger("click");
						jQuery("#subscribe_popup").parents(".fancybox-overlay").addClass("popup-fancy");
					};';
			}
			
			if( !isset($_COOKIE["device_pixel_ratio"]) ){				
				$output .= "if( document.cookie.indexOf('device_pixel_ratio') == -1 && 'devicePixelRatio' in window	&& window.devicePixelRatio == 2 ){
					var date = new Date();
					date.setTime( date.getTime() + 3600000 );
					document.cookie = 'device_pixel_ratio=' + window.devicePixelRatio + ';' +  ' expires=' + date.toUTCString() +'; path=/';
					if(document.cookie.indexOf('device_pixel_ratio') != -1) {
						window.location.reload();
					}
				}";
			}
			
			/*
			** Sticky Mobile
			*/
			if( autusin_mobile_check() ) : 
				
				if( $sticky_mobile ) :
				
					$output .= '$(window).scroll(function() {   
					if( $( "body" ).hasClass( "mobile-layout" ) ) {
						var target = $( ".mobile-layout #header" );
							var scroll_top = $(window).scrollTop();
							if ( scroll_top > 46 ) {
								$(".mobile-layout #header").addClass("sticky-mobile");
							}else{
								$(".mobile-layout #header").removeClass("sticky-mobile");
							}
					}
				});';
				
				endif;
				
			endif;
		$output .= '}(jQuery));';
		
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
		wp_add_inline_script( 'autusin-custom-script', $output );
	
}
add_action( 'wp_enqueue_scripts', 'autusin_advanced', 101 );


/**
* Set and Get view count
**/
function autusin_getPostViews($postID){    
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
		return "0";
	}
	return $count;
}

function autusin_setPostViews($postID) {
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if($count==''){
			$count = 0;
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
	}else{
			$count++;
			update_post_meta($postID, $count_key, $count);
	}
}  

/*
** Create Postview on header
*/
add_action( 'wp_head', 'autusin_create_postview' );
function autusin_create_postview(){
	if( is_single() || is_singular( 'product' ) ) :
		autusin_setPostViews( get_the_ID() );
	endif;
}

/*
** Logo
*/
function autusin_logo(){
	$scheme_meta = get_post_meta( get_the_ID(), 'scheme', true );
	$scheme 		 = ( $scheme_meta != '' && $scheme_meta != 'none' ) ? $scheme_meta : sw_options( 'scheme' );
	$meta_img_ID = get_post_meta( get_the_ID(), 'page_logo', true );
	$meta_img 	 = ( $meta_img_ID != '' ) ? wp_get_attachment_image_url( $meta_img_ID, 'full' ) : '';
	$mobile_logo = sw_options( 'mobile_logo' );
	$logo_select = ( autusin_mobile_check() && $mobile_logo != ''  ) ? $mobile_logo : sw_options( 'sitelogo' );
	$main_logo	 = ( $meta_img != '' )? $meta_img : $logo_select;
	global $is_retina;
?>
	<a  href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php if( $main_logo != '' ){ ?>
				<img src="<?php echo esc_url( $main_logo ); ?>" alt="<?php bloginfo('name'); ?>"/>
			<?php }else{
				$logo = get_template_directory_uri().'/assets/img/logo-default.png';
				if ( $scheme ){ 
					$logo = get_template_directory_uri().'/assets/img/logo-'. $scheme .'.png'; 
				}
			?>
				<img src="<?php echo esc_url( $logo ); ?>" alt="<?php bloginfo('name'); ?>"/>
			<?php } ?>
	</a>
<?php 
}

/*
** Function Get datetime blog 
*/
function autusin_get_time(){
	global $post;
	echo '<span class="entry-date latest_post_date">
		<span class="day-time">'. get_the_time( 'd', $post->ID ) . '</span>
		<span class="month-time">'. get_the_time( 'M', $post->ID ) . '</span>
	</span>';
}

/*
** BLog columns
*/
function autusin_blogcol(){
	global $sw_blogcol;
	$blog_col = ( isset( $sw_blogcol ) && $sw_blogcol > 0 ) ? $sw_blogcol : sw_options('blog_column');
	$col = 'col-md-'.( 12/$blog_col ).' col-sm-6 col-xs-12 theme-clearfix';
	$col .= ( get_the_post_thumbnail() ) ? '' : ' no-thumb';
	return $col;
}

/*
** Trimword Title
*/

function autusin_trim_words( $title ){
	$title_length = intval( sw_options( 'title_length' ) );
	$html = '';
	if( $title_length > 0 ){
		$html .= wp_trim_words( $title, $title_length, '...' );
	}else{
		$html .= $title;
	}
	echo esc_html( $html );
}

/*
** Advanced Favico
*/
add_filter( 'get_site_icon_url', 'autusin_site_favicon', 10, 1 );
function autusin_site_favicon( $url ){
	if ( sw_options('favicon') ){
		$url = esc_url( sw_options('favicon') );
	}
	return $url;
}

/*
** Social Link
*/
if( !function_exists( 'sw_social_link' ) ) {
	function sw_social_link(){
		$fb_link = sw_options('social-share-fb');
		$tw_link = sw_options('social-share-tw');
		$tb_link = sw_options('social-share-tumblr');
		$li_link = sw_options('social-share-in');
		$gg_link = sw_options('social-share-go');
		$pt_link = sw_options('social-share-pi');
		$it_link = sw_options('social-share-instagram');

		$html = '';
		if( $fb_link != '' || $tw_link != '' || $tb_link != '' || $li_link != '' || $gg_link != '' || $pt_link != '' ):
		$html .= '<div class="autusin-socials"><ul>';
			if( $fb_link != '' ):
				$html .= '<li><a href="'. esc_url( $fb_link ) .'" title="'. esc_attr__( 'Facebook', 'autusin' ) .'"><i class="fa fa-facebook"></i></a></li>';
			endif;
			
			if( $tw_link != '' ):
				$html .= '<li><a href="'. esc_url( $tw_link ) .'" title="'. esc_attr__( 'Twitter', 'autusin' ) .'"><i class="fa fa-twitter"></i></a></li>';
			endif;
			
			if( $tb_link != '' ):
				$html .= '<li><a href="'. esc_url( $tb_link ) .'" title="'. esc_attr__( 'Tumblr', 'autusin' ) .'"><i class="fa fa-tumblr"></i></a></li>';
			endif;
			
			if( $li_link != '' ):
				$html .= '<li><a href="'. esc_url( $li_link ) .'" title="'. esc_attr__( 'Linkedin', 'autusin' ) .'"><i class="fa fa-linkedin"></i></a></li>';
			endif;
			
			if( $it_link != '' ):
				$html .= '<li><a href="'. esc_url( $it_link ) .'" title="'. esc_attr__( 'Instagram', 'autusin' ) .'"><i class="fa fa-instagram"></i></a></li>';
			endif;
			
			if( $gg_link != '' ):
				$html .= '<li><a href="'. esc_url( $gg_link ) .'" title="'. esc_attr__( 'Google+', 'autusin' ) .'"><i class="fa fa-google-plus"></i></a></li>';
			endif;
			
			if( $pt_link != '' ):
				$html .= '<li><a href="'. esc_url( $pt_link ) .'" title="'. esc_attr__( 'Pinterest', 'autusin' ) .'"><i class="fa fa-pinterest"></i></a></li>';
			endif;
		$html .= '</ul></div>';
		endif;
		echo wp_kses( $html, array( 'div' => array( 'class' => array() ), 'ul' => array(), 'li' => array(), 'a' => array( 'href' => array(), 'class' => array(), 'title' => array() ), 'i' => array( 'class' => array() ) ) );
	}
}

/**
* Change position of comment form
**/
function autusin_move_comment_field_to_bottom( $fields ) {
$comment_field = $fields['comment'];
unset( $fields['comment'] );
$fields['comment'] = $comment_field;
return $fields;
}
 
add_filter( 'comment_form_fields', 'autusin_move_comment_field_to_bottom' );

/*
** Retina php
*/
add_action( 'init', 'autusin_retina' );
function autusin_retina(){
	global $is_retina;  
    $is_retina = isset( $_COOKIE["device_pixel_ratio"] ) AND $_COOKIE["device_pixel_ratio"] >= 2;
}
