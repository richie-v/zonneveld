<?php 
/* 
** Content Header
*/
$sticky_mobile	= sw_options( 'sticky_menu' );
?>
<?php if( is_front_page() || get_post_meta( get_the_ID(), 'page_mobile_enable', true ) || is_search()):?>
	<header id="header" class="header header-mobile-style1">
		<div class="header-wrrapper clearfix">
			<div class="header-top-mobile clearfix">
				<div class="header-menu-categories pull-left">
					<?php if ( has_nav_menu('vertical_menu') ) {?>
					<div class="vertical_megamenu">
						<?php wp_nav_menu(array('theme_location' => 'vertical_menu', 'menu_class' => 'nav vertical-megamenu')); ?>
					</div>
					<?php } ?>
				</div>
				<div class="autusin-logo pull-left">
					<?php autusin_logo(); ?>
				</div>
				<div class="header-cart">
					<a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id') ); ?>">
						<?php get_template_part( 'woocommerce/minicart-ajax-mobile' ); ?>
					</a>
				</div>
				<div class="mobile-wishlist pull-right">
					<a href="<?php echo get_permalink( get_option('yith_wcwl_wishlist_page_id') ); ?>" title="<?php esc_attr_e('Wishlist','autusin'); ?>"></a>
				</div>
				<div class="mobile-search pull-right">
					<div class="icon-seach"></div>
					<?php if( is_active_sidebar( 'search' ) && class_exists( 'sw_woo_search_widget' ) ): ?>
						<?php dynamic_sidebar( 'search' ); ?>
					<?php else : ?>
						<div class="non-margin">
							<div class="widget-inner">
								<?php get_template_part( 'widgets/sw_top/searchcate' ); ?>
							</div>
						</div>
					<?php endif; ?>	
				</div>
			</div>
		</div>
	</header>
<?php else : ?>
	<!--  header page -->
	<?php get_template_part( 'mlayouts/breadcrumb', 'mobile' ); ?>
	<!-- End header -->
<?php endif; ?>