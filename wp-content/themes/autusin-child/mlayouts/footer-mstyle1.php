<?php 
	/* 
	** Content Footer Mobile
	*/	
?>
<footer id="footer" class="footer-mstyle1 theme-clearfix">
	<div class="footer-container">
		<div class="footer-menu clearfix">
			<div class="menu-item">
				<div class="footer-home">
					<a href="<?php echo esc_url( home_url('/') ); ?>" title="<?php esc_attr_e( 'Home', 'autusin' ) ?>">
						<span class="icon-menu"></span>
						<span class="menu-text"><?php esc_html_e( "Home", 'autusin' )?></span>
					</a>
				</div>
			</div>
			<div class="menu-item">
				<div class="footer-search">
					<a href="javascript:void(0)" title="<?php esc_attr__( 'Search', 'autusin' ) ?>">
						<span class="icon-menu"></span>
						<span class="menu-text"><?php esc_html_e( "Search", 'autusin' )?></span>
					</a>
					<?php get_template_part( 'widgets/sw_top/searchcate' ); ?>
				</div>
			</div>
			<div class="menu-item">
				<div class="footer-cart">
					<a href="<?php echo get_permalink(get_option('woocommerce_cart_page_id') ); ?>">
						<?php get_template_part( 'woocommerce/minicart-ajax-mobile' ); ?>
					</a>
				</div>
			</div>
			<div class="menu-item">
				<div class="footer-myaccount">
					<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php esc_attr_e('My Account','autusin'); ?>">
						<span class="icon-menu"></span>
						<span class="menu-text"><?php esc_html_e('My Account','autusin'); ?></span>
					</a>
				</div>
			</div>
			<div class="menu-item">
				<div class="footer-more">
					<a href="javascript:void(0)" title="<?php esc_attr_e('More','autusin'); ?>">
						<span class="icon-menu"></span>
						<span class="menu-text"><?php esc_html_e('More','autusin'); ?></span>
					</a>
				</div>
			</div>
			<div class="menu-item-hidden">
				<?php if ( has_nav_menu('mobile_menu1') ) {?>
					<div class="wrapper_menu_footer">
						<?php wp_nav_menu(array('theme_location' => 'mobile_menu1', 'menu_class' => 'menu-footer')); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</footer>