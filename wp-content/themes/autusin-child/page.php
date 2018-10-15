<?php get_header(); ?>
<?php 
	$autusin_sidebar_template	= get_post_meta( get_the_ID(), 'page_sidebar_layout', true );
	$autusin_sidebar 			= get_post_meta( get_the_ID(), 'page_sidebar_template', true );
?>
	<?php if ( !is_front_page() ) { ?>
	<div class="autusin_breadcrumbs">
		<div class="container">
			<?php				
				if ( function_exists( 'autusin_breadcrumb' ) ){
					autusin_breadcrumb( '<div class="breadcrumbs custom-font theme-clearfix">', '</div>' );
				} 
			?>
			<div class="listing-title">			
				<h1><span><?php autusin_title(); ?></span></h1>				
			</div>
		</div>
	</div>	
	<?php } ?>
	
	<div class="container">
		<div class="row">
		<?php 
			if ( is_active_sidebar( $autusin_sidebar ) && $autusin_sidebar_template != 'right' && $autusin_sidebar_template !='full' ):
			$autusin_left_span_class = 'col-lg-'.sw_options('sidebar_left_expand');
			$autusin_left_span_class .= ' col-md-'.sw_options('sidebar_left_expand_md');
			$autusin_left_span_class .= ' col-sm-'.sw_options('sidebar_left_expand_sm');
		?>
			<aside id="left" class="sidebar <?php echo esc_attr( $autusin_left_span_class ); ?>">
				<?php dynamic_sidebar( $autusin_sidebar ); ?>
			</aside>
		<?php endif; ?>
		
			<div id="contents" role="main" class="main-page <?php autusin_content_page(); ?>">
				<?php
				get_template_part('templates/content', 'page')
				?>
			</div>
			<?php 
			if ( is_active_sidebar( $autusin_sidebar ) && $autusin_sidebar_template != 'left' && $autusin_sidebar_template !='full' ):
				$autusin_left_span_class = 'col-lg-'.sw_options('sidebar_left_expand');
				$autusin_left_span_class .= ' col-md-'.sw_options('sidebar_left_expand_md');
				$autusin_left_span_class .= ' col-sm-'.sw_options('sidebar_left_expand_sm');
			?>
				<aside id="right" class="sidebar <?php echo esc_attr($autusin_left_span_class); ?>">
					<?php dynamic_sidebar( $autusin_sidebar ); ?>
				</aside>
			<?php endif; ?>
		</div>		
	</div>
<?php get_footer(); ?>

