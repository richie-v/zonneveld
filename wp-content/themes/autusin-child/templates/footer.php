<?php 	
$autusin_page_footer   	 = ( get_post_meta( get_the_ID(), 'page_footer_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'page_footer_style', true ) : sw_options( 'footer_style' );
$autusin_copyright_text 	 = sw_options( 'footer_copyright' );
$autusin_copyright_footer = get_post_meta( get_the_ID(), 'copyright_footer_style', true );
$autusin_copyright_footer  = ( get_post_meta( get_the_ID(), 'copyright_footer_style', true ) != '' ) ? get_post_meta( get_the_ID(), 'copyright_footer_style', true ) : sw_options('copyright_style');
?>

<footer id="footer" class="footer default theme-clearfix">
	<!-- Content footer -->
	<div class="container">
		<?php 
			if( $autusin_page_footer != '' ) :
				echo sw_get_the_content_by_id( $autusin_page_footer ); 
			endif;
		?>
	</div>
	<div class="footer-copyright <?php echo esc_attr( $autusin_copyright_footer ); ?>">
		<div class="container">
			<!-- Copyright text -->
			<div class="copyright-text">
				<?php if( $autusin_copyright_text == '' ) : ?>
					<p>&copy;<?php echo date_i18n('Y') .' '. esc_html__('WordPress Theme SW Autusin. All Rights Reserved. Designed by ','autusin'); ?><a class="mysite" href="<?php echo esc_url( 'http://wpthemego.com/' ); ?>"><?php esc_html_e('WPThemeGo.Com','autusin');?></a>.</p>
				<?php else : ?>
					<?php echo wp_kses( $autusin_copyright_text, array( 'a' => array( 'href' => array(), 'title' => array(), 'class' => array() ), 'p' => array()  ) ) ; ?>
				<?php endif; ?>
			</div>
			<?php if (is_active_sidebar('footer-copyright')){ ?>
			<div class="sidebar-copyright">
				<?php dynamic_sidebar('footer-copyright'); ?>
			</div>
		<?php } ?>
		</div>
	</div>
</footer>