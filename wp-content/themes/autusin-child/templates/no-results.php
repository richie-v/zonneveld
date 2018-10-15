<?php
	if( autusin_mobile_check() ) : ?>
	<div class="no-result">
		<div class="no-result-image">
			<span class="image">
				<img class="img_logo" alt="<?php esc_attr__( '404', 'autusin' ) ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/no-result.png">
			</span>
		</div>
		<h3><?php esc_html_e('no products found','autusin');?></h3>
		<p><?php esc_html_e('Sorry, but nothing matched your search terms.','autusin');?><br/><?php esc_html_e('Please try again with some different keywords.', 'autusin'); ?></p>
		<a href="<?php echo get_permalink( get_option('woocommerce_shop_page_id') ); ?>" title="<?php esc_attr__( 'Shop', 'autusin' ) ?>"><?php esc_html_e('back to categories','autusin');?></a>
	</div>
<?php else : ?>
	<div class="no-result">		
			<p><?php esc_html_e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'autusin'); ?></p>
		<?php get_search_form(); ?>
	</div>
<?php endif; ?>