<?php 
	global $instance, $post;
	$format = get_post_format();
	$autusin_bclass = ( has_post_thumbnail() ) ? '' : 'no-thumb ';
	$autusin_bclass .= 'clearfix';
?>
	<div id="post-<?php the_ID();?>" <?php post_class( $autusin_bclass ); ?>>
		<div class="entry clearfix">
			<?php if( $format == '' ){?>
				<?php if ( has_post_thumbnail() ){ ?>
				<div class="entry-thumb">	
					<a class="entry-hover" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
						<?php the_post_thumbnail('autusin_detail_thumb'); ?>			
					</a>	
				</div>
				<?php } ?>	
			<div class="entry-content">				
				<div class="content-top clearfix">
					<div class="entry-title">
						<h4><a href="<?php echo get_permalink($post->ID)?>"><?php autusin_trim_words( $post->post_title ); ?></a></h4>
					</div>
					<div class="entry-meta">
							<span class="entry-author">
								<i class="fa fa-user"></i><?php esc_html_e('Post by:', 'autusin'); ?> <?php the_author_posts_link(); ?>
							</span>
							<span class="entry-date"><a href="<?php echo get_permalink($post->ID)?>"><i class="fa fa-clock-o"></i><?php echo get_the_date( '', $post->ID );?></a></span>
							<span class="entry-comment">
								<a href="<?php comments_link(); ?>"><i class="fa fa-comments"></i><?php echo sprintf( _n( '%d Comment', '%d Comments', $post-> comment_count , 'autusin' ), number_format_i18n( $post-> comment_count ) ); ?></a>
							</span>
							<?php if(has_tag()) :?>
								<?php the_tags( '<span class="entry-meta-link entry-meta-tag"><span class="fa fa-tags"></span>', ', ', '</span>' ); ?>
							<?php endif;?>
					</div>
					<div class="entry-summary">
						<?php 												
							if ( preg_match('/<!--more(.*?)?-->/', $post->post_content, $matches) ) {
								echo wp_trim_words($post->post_content, 55, '...');
							} else {
								the_content('...');
							}		
						?>	
					</div>
				</div>
				<div class="readmore"><a href="<?php echo get_permalink($post->ID)?>"><i class="fa fa-caret-right"></i><?php esc_html_e('Read More', 'autusin'); ?></a></div>
			</div>
			<?php } else { ?>
			<div class="wp-entry-thumb">	
					<?php if( $format == 'video' || $format == 'audio' ){ ?>	
						<?php echo sprintf( ( $format == 'video' ) ? '<div class="video-wrapper">%s</div>' : '%s', autusin_get_entry_content_asset( $post->ID ) ); ?>
					<?php } ?>
					<?php if( $format == 'image' ){?>
						<div class="entry-thumb-content">
							<a class="entry-hover" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
								<?php the_post_thumbnail('autusin_detail_thumb');?>				
							</a>	
						</div>
					<?php } ?>
					<?php if( $format == 'gallery' ) { 
						if(preg_match_all('/\[gallery(.*?)?\]/', get_post($instance['post_id'])->post_content, $matches)){
							$attrs = array();
							if (count($matches[1])>0){
								foreach ($matches[1] as $m){
									$attrs[] = shortcode_parse_atts($m);
								}
							}
							$ids = '';
							if (count($attrs)> 0){
								foreach ($attrs as $attr){
									if (is_array($attr) && array_key_exists('ids', $attr)){
										$ids = $attr['ids'];
										break;
									}
								}
							}
						?>
							<div id="gallery_slider_<?php echo esc_attr( $post->ID ); ?>" class="carousel slide gallery-slider" data-interval="0">	
								<div class="carousel-inner">
									<?php
										$ids = explode(',', $ids);						
										foreach ( $ids as $i => $id ){ ?>
											<div class="item<?php echo esc_attr( ( $i== 0 ) ? ' active' : '' ); ?>">			
													<?php echo wp_get_attachment_image($id, 'full'); ?>
											</div>
										<?php }	?>
								</div>
								<a href="#gallery_slider_<?php echo esc_attr( $post->ID ); ?>" class="left carousel-control" data-slide="prev"><?php esc_html_e( 'Prev', 'autusin' ) ?></a>
								<a href="#gallery_slider_<?php echo esc_attr( $post->ID ); ?>" class="right carousel-control" data-slide="next"><?php esc_html_e( 'Next', 'autusin' ) ?></a>
							</div>
						<?php }	?>							
					<?php } ?>
				</div>
				<div class="entry-content">
					<div class="content-top">
						<div class="entry-title">
							<h4><a href="<?php echo get_permalink($post->ID)?>"><?php autusin_trim_words( $post->post_title ); ?></a></h4>
						</div>
						<div class="entry-meta">
							<span class="entry-author">
								<i class="fa fa-user"></i><?php esc_html_e('Post by:', 'autusin'); ?> <?php the_author_posts_link(); ?>
							</span>
							<span class="entry-comment">
								<a href="<?php comments_link(); ?>"><i class="fa fa-comments"></i><?php echo sprintf( _n( '%d Comment', '%d Comments', $post-> comment_count , 'autusin' ), number_format_i18n( $post-> comment_count ) ); ?></a>
							</span>
							<?php if(has_tag()) :?>
								<?php the_tags( '<span class="entry-meta-link entry-meta-tag"><span class="fa fa-tags"></span>', ', ', '</span>' ); ?>
							<?php endif;?>
						</div>
						<div class="entry-summary">
						<?php the_content( '...' ); ?>
						<div class="readmore"><a href="<?php echo get_permalink($post->ID)?>"><i class="fa fa-caret-right"></i><?php esc_html_e('Read More', 'autusin'); ?></a></div>
					</div>
				 </div>
				</div>
			<?php } ?>
		</div>
	</div>