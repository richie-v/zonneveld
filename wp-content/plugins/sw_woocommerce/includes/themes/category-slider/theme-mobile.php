<?php 
	$viewall = get_permalink( wc_get_page_id( 'shop' ) );
	$widget_id = isset( $widget_id ) ? $widget_id : 'category_slide_'.$this->generateID();
	if( $category == '' ){
		return '<div class="alert alert-warning alert-dismissible" role="alert">
			<a class="close" data-dismiss="alert">&times;</a>
			<p>'. esc_html__( 'Please select a category for SW Woocommerce Category Slider. Layout ', 'sw_woocommerce' ) . $layout .'</p>
		</div>';
	}
?>
<div id="<?php echo 'slider_' . $widget_id; ?>" class="featured-categories-mobile style-moblie">
	<?php if( $title1 != '' ){ ?>
	<div class="block-title clearfix">
		<h2><?php echo ( $title1 != '' ) ? $title1 : $term_name; ?></h2>
		<a class="view-all" href="<?php echo esc_url( $viewall ); ?>"><i class="fa fa-caret-right"></i><?php echo esc_html__('view all','sw_woocommerce'); ?></a>
	</div>
	<?php } ?>
	<div class="resp-slider-container">
		<div class="items-wrapper clearfix">
		<?php
			if( !is_array( $category ) ){
				$category = explode( ',', $category );
			}
				foreach( $category as $cat ){
				$term = get_term_by('slug', $cat, 'product_cat');
				if( $term ) :
				$thumbnail_id 	= get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
				$thumb = wp_get_attachment_image( $thumbnail_id,'thumbnail' );
		?>
			<div class="item item-product-cat">
				<div class="item-inner">
					<div class="item-image">
						<a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>" title="<?php echo esc_attr( $term->name ); ?>"><?php echo $thumb; ?></a>
					</div>
					<div class="item-content">
						<h3><a href="<?php echo get_term_link( $term->term_id, 'product_cat' ); ?>"><?php sw_trim_words( $term->name, $title_length ); ?></a></h3>
					</div>
				</div>
			</div>
			<?php endif; ?>
		<?php } ?>
		</div>
	</div>
</div>		