<?php get_template_part('header'); ?>
<div class="wrapper_404">
	<div class="container">
		<div class="row">
			<?php $autusin_404page = sw_options( 'page_404' ); ?>
			<?php if( $autusin_404page != '' ) : ?>
				<?php echo sw_get_the_content_by_id( $autusin_404page ); ?>
			<?php else: ?>	
				<div class="content_404">
					<div class="item-left">
						<div class="erro-image">
							<span class="erro-key">
								<img class="img_logo" alt="<?php esc_attr__( '404', 'autusin' ); ?>" src="<?php echo get_template_directory_uri(); ?>/assets/img/img-404.png">
							</span>
							<div class="erro-content">
								<h2><?php esc_html_e( 'Page Not Found', 'autusin') ?></h2>
							</div>
						</div>
					</div>
					<div class="item-right">
						<div class="block-top">
							<h3><?php esc_html_e( 'The page you are looking for does not appear to exit. Please check the URL or try the search box below.', 'autusin') ?></h3>
						</div>
						<div class="block-middle">
							<div class="autusin_search_404">
								<?php get_template_part( 'widgets/sw_top/search' ); ?>
							</div>
						</div>
						<div class="block-bottom">
							<a href="<?php echo esc_url( home_url('/') ); ?>" class="btn-404 back2home" title="<?php esc_attr__( 'Go Home', 'autusin' ) ?>"><?php esc_html_e( "BACK TO HOME", 'autusin' )?></a>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php get_template_part('footer'); ?>