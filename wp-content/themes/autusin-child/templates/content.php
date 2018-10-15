<?php get_template_part('header'); ?>
<?php 
	$autusin_sidebar_template =( sw_options('sidebar_blog') ) ? sw_options('sidebar_blog') : 'right';
	$autusin_blog_styles = ( sw_options('blog_layout') ) ? sw_options('blog_layout') : 'list';
?>

<div class="autusin_breadcrumbs">
	<div class="container">
		<?php
			if (!is_front_page() ) {
				if (function_exists('autusin_breadcrumb')){
					autusin_breadcrumb('<div class="breadcrumbs custom-font theme-clearfix">', '</div>');
				} 
			} 
		?>
	</div>
</div>

<div class="container">
	<div class="row sidebar-row">
		<!-- Left Sidebar -->
		<?php $sidebar_template 		= ( sw_options('sidebar_blog') ) ? sw_options('sidebar_blog') : ''; ?>
		<?php if ( is_active_sidebar('left-blog') ):
			$autusin_left_span_class = ( sw_options('sidebar_left_expand') ) ? 'col-lg-'.sw_options('sidebar_left_expand') : 'col-lg-3';
			$autusin_left_span_class .= ( sw_options('sidebar_left_expand_md') ) ? ' col-md-'.sw_options('sidebar_left_expand_md') : ' col-md-3';
			$autusin_left_span_class .= ( sw_options('sidebar_left_expand_sm') ) ? ' col-sm-'.sw_options('sidebar_left_expand_sm') : ' col-sm-4';
		?>
		<aside id="left" class="sidebar <?php echo esc_attr($autusin_left_span_class); ?> <?php echo esc_attr( ( $sidebar_template == 'right' ||  $sidebar_template == 'full' ) ? 'hidden' : '' ) ?>">
			<?php dynamic_sidebar('left-blog'); ?>
		</aside>
		<?php endif; ?>
		
		<div class="category-contents <?php autusin_content_blog(); ?>">
			<div class="listing-title">			
				<h1><span><?php autusin_title(); ?></span></h1>				
			</div>
			<!-- No Result -->
			<?php if (!have_posts()) : ?>
			<?php get_template_part('templates/no-results'); ?>
			<?php endif; ?>			
			
			<?php 
				$autusin_blogclass = 'blog-content blog-content-'. $autusin_blog_styles;
				if( $autusin_blog_styles == 'grid' ){
					$autusin_blogclass .= ' row';
				}
			?>
			<div class="<?php echo esc_attr( $autusin_blogclass ); ?>">
			<?php 			
				while( have_posts() ) : the_post();
					get_template_part( 'templates/content', $autusin_blog_styles );
				endwhile;
			?>
			<?php get_template_part('templates/pagination'); ?>
			</div>
			<div class="clearfix"></div>
		</div>
		
		<!-- Right Sidebar -->
		<?php if ( is_active_sidebar('right-blog') ):
			$autusin_right_span_class = ( sw_options('sidebar_right_expand') ) ? 'col-lg-'.sw_options('sidebar_right_expand') : 'col-lg-3';
			$autusin_right_span_class .= ( sw_options('sidebar_right_expand_md') ) ? ' col-md-'.sw_options('sidebar_right_expand_md') : ' col-md-3';
			$autusin_right_span_class .= ( sw_options('sidebar_right_expand_sm') ) ? ' col-sm-'.sw_options('sidebar_right_expand_sm') : ' col-sm-4';
		?>
		<aside id="right" class="sidebar <?php echo esc_attr($autusin_right_span_class); ?> <?php echo esc_attr( ( $sidebar_template == 'left' ||  $sidebar_template == 'full' ) ? 'hidden' : '' ) ?>">
			<?php dynamic_sidebar('right-blog'); ?>
		</aside>
		<?php endif; ?>
	</div>
</div>
<?php get_template_part('footer'); ?>
