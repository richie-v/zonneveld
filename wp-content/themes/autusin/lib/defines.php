<?php
$lib_dir = trailingslashit( str_replace( '\\', '/', get_template_directory() . '/lib/' ) );

if( !defined('AUTUSIN_DIR') ){
	define( 'AUTUSIN_DIR', $lib_dir );
}

if( !defined('AUTUSIN_URL') ){
	define( 'AUTUSIN_URL', trailingslashit( get_template_directory_uri() ) . 'lib' );
}

if (!isset($content_width)) { $content_width = 940; }

define("AUTUSIN_PRODUCT_TYPE","product");
define("AUTUSIN_PRODUCT_DETAIL_TYPE","product_detail");

if ( !defined('SW_THEME') ){
	define( 'SW_THEME', 'autusin_theme' );
}

require_once( get_template_directory().'/lib/options.php' );

if( class_exists( 'SW_Options' ) ) :
	function autusin_Options_Setup(){
		global $sw_options, $options, $options_args;

		$options = array();
		$options[] = array(
			'title' => esc_html__('General', 'autusin'),
			'desc' => wp_kses( __('<p class="description">The theme allows to build your own styles right out of the backend without any coding knowledge. Upload new logo and favicon or get their URL.</p>', 'autusin'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it autusin for default.
			'icon' => AUTUSIN_URL.'/admin/img/glyphicons/glyphicons_019_cogwheel.png',
			//Lets leave this as a autusin section, no options just some intro text set above.
			'fields' => array(	

				array(
					'id' => 'sitelogo',
					'type' => 'upload',
					'title' => esc_html__('Logo Image', 'autusin'),
					'sub_desc' => esc_html__( 'Use the Upload button to upload the new logo and get URL of the logo', 'autusin' ),
					'std' => get_template_directory_uri().'/assets/img/logo-default.png'
				),

				array(
					'id' => 'favicon',
					'type' => 'upload',
					'title' => esc_html__('Favicon', 'autusin'),
					'sub_desc' => esc_html__( 'Use the Upload button to upload the custom favicon', 'autusin' ),
					'std' => ''
				),

				array(
					'id' => 'tax_select',
					'type' => 'multi_select_taxonomy',
					'title' => esc_html__('Select Taxonomy', 'autusin'),
					'sub_desc' => esc_html__( 'Select taxonomy to show custom term metabox', 'autusin' ),
				),

				array(
					'id' => 'title_length',
					'type' => 'text',
					'title' => esc_html__('Title Length Of Item Listing Page', 'autusin'),
					'sub_desc' => esc_html__( 'Choose title length if you want to trim word, leave 0 to not trim word', 'autusin' ),
					'std' => 0
				),

				array(
					'id' => 'page_404',
					'type' => 'pages_select',
					'title' => esc_html__('404 Page Content', 'autusin'),
					'sub_desc' => esc_html__('Select page 404 content', 'autusin'),
					'std' => ''
				),
			)		
		);

		$options[] = array(
			'title' => esc_html__('Schemes', 'autusin'),
			'desc' => wp_kses( __('<p class="description">Custom color scheme for theme. Unlimited color that you can choose.</p>', 'autusin'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it autusin for default.
			'icon' => AUTUSIN_URL.'/admin/img/glyphicons/glyphicons_163_iphone.png',
			//Lets leave this as a autusin section, no options just some intro text set above.
			'fields' => array(		
				array(
					'id' => 'scheme',
					'type' => 'radio_img',
					'title' => esc_html__('Color Scheme', 'autusin'),
					'sub_desc' => esc_html__( 'Select one of 1 predefined schemes', 'autusin' ),
					'desc' => '',
					'options' => array(
						'default' => array('title' => 'Default', 'img' => get_template_directory_uri().'/assets/img/default.png'),
						), //Must provide key => value(array:title|img) pairs for radio options
					'std' => 'default'
				),
				
				array(
					'id' => 'custom_color',
					'title' => esc_html__( 'Enable Custom Color', 'autusin' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Check this field to enable custom color and when you update your theme, custom color will not lose.', 'autusin' ),
					'desc' => '',
					'std' => '0'
				),

				array(
					'id' => 'developer_mode',
					'title' => esc_html__( 'Developer Mode', 'autusin' ),
					'type' => 'checkbox',
					'sub_desc' => esc_html__( 'Turn on/off compile less to css and custom color', 'autusin' ),
					'desc' => '',
					'std' => '0'
				),
				
				array(
					'id' => 'scheme_color',
					'type' => 'color',
					'title' => esc_html__('Color', 'autusin'),
					'sub_desc' => esc_html__('Select main custom color.', 'autusin'),
					'std' => ''
				),
				
				array(
					'id' => 'scheme_body',
					'type' => 'color',
					'title' => esc_html__('Body Color', 'autusin'),
					'sub_desc' => esc_html__('Select main body custom color.', 'autusin'),
					'std' => ''
				),
				
				array(
					'id' => 'scheme_border',
					'type' => 'color',
					'title' => esc_html__('Border Color', 'autusin'),
					'sub_desc' => esc_html__('Select main border custom color.', 'autusin'),					
					'std' => ''
				)			
			)
		);

		$options[] = array(
			'title' => esc_html__('Layout', 'autusin'),
			'desc' => wp_kses( __('<p class="description">WpThemeGo Framework comes with a layout setting that allows you to build any number of stunning layouts and apply theme to your entries.</p>', 'autusin'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it autusin for default.
			'icon' => AUTUSIN_URL.'/admin/img/glyphicons/glyphicons_319_sort.png',
			//Lets leave this as a autusin section, no options just some intro text set above.
			'fields' => array(
				array(
					'id' => 'layout',
					'type' => 'select',
					'title' => esc_html__('Box Layout', 'autusin'),
					'sub_desc' => esc_html__( 'Select Layout Box or Wide', 'autusin' ),
					'options' => array(
						'full' => esc_html__( 'Wide', 'autusin' ),
						'boxed' => esc_html__( 'Boxed', 'autusin' )
					),
					'std' => 'wide'
				),
				
				array(
					'id' => 'bg_box_img',
					'type' => 'upload',
					'title' => esc_html__('Background Box Image', 'autusin'),
					'sub_desc' => '',
					'std' => ''
				),
				array(
					'id' => 'sidebar_left_expand',
					'type' => 'select',
					'title' => esc_html__('Left Sidebar Expand', 'autusin'),
					'options' => array(
						'2' => '2/12',
						'3' => '3/12',
						'4' => '4/12',
						'5' => '5/12', 
						'6' => '6/12',
						'7' => '7/12',
						'8' => '8/12',
						'9' => '9/12',
						'10' => '10/12',
						'11' => '11/12',
						'12' => '12/12'
					),
					'std' => '3',
					'sub_desc' => esc_html__( 'Select width of left sidebar.', 'autusin' ),
				),

				array(
					'id' => 'sidebar_right_expand',
					'type' => 'select',
					'title' => esc_html__('Right Sidebar Expand', 'autusin'),
					'options' => array(
						'2' => '2/12',
						'3' => '3/12',
						'4' => '4/12',
						'5' => '5/12',
						'6' => '6/12',
						'7' => '7/12',
						'8' => '8/12',
						'9' => '9/12',
						'10' => '10/12',
						'11' => '11/12',
						'12' => '12/12'
					),
					'std' => '3',
					'sub_desc' => esc_html__( 'Select width of right sidebar medium desktop.', 'autusin' ),
				),
				array(
					'id' => 'sidebar_left_expand_md',
					'type' => 'select',
					'title' => esc_html__('Left Sidebar Medium Desktop Expand', 'autusin'),
					'options' => array(
						'2' => '2/12',
						'3' => '3/12',
						'4' => '4/12',
						'5' => '5/12',
						'6' => '6/12',
						'7' => '7/12',
						'8' => '8/12',
						'9' => '9/12',
						'10' => '10/12',
						'11' => '11/12',
						'12' => '12/12'
					),
					'std' => '4',
					'sub_desc' => esc_html__( 'Select width of left sidebar medium desktop.', 'autusin' ),
				),
				array(
					'id' => 'sidebar_right_expand_md',
					'type' => 'select',
					'title' => esc_html__('Right Sidebar Medium Desktop Expand', 'autusin'),
					'options' => array(
						'2' => '2/12',
						'3' => '3/12',
						'4' => '4/12',
						'5' => '5/12',
						'6' => '6/12',
						'7' => '7/12',
						'8' => '8/12',
						'9' => '9/12',
						'10' => '10/12',
						'11' => '11/12',
						'12' => '12/12'
					),
					'std' => '4',
					'sub_desc' => esc_html__( 'Select width of right sidebar.', 'autusin' ),
				),
				array(
					'id' => 'sidebar_left_expand_sm',
					'type' => 'select',
					'title' => esc_html__('Left Sidebar Tablet Expand', 'autusin'),
					'options' => array(
						'2' => '2/12',
						'3' => '3/12',
						'4' => '4/12',
						'5' => '5/12',
						'6' => '6/12',
						'7' => '7/12',
						'8' => '8/12',
						'9' => '9/12',
						'10' => '10/12',
						'11' => '11/12',
						'12' => '12/12'
					),
					'std' => '4',
					'sub_desc' => esc_html__( 'Select width of left sidebar tablet.', 'autusin' ),
				),
				array(
					'id' => 'sidebar_right_expand_sm',
					'type' => 'select',
					'title' => esc_html__('Right Sidebar Tablet Expand', 'autusin'),
					'options' => array(
						'2' => '2/12',
						'3' => '3/12',
						'4' => '4/12',
						'5' => '5/12',
						'6' => '6/12',
						'7' => '7/12',
						'8' => '8/12',
						'9' => '9/12',
						'10' => '10/12',
						'11' => '11/12',
						'12' => '12/12'
					),
					'std' => '4',
					'sub_desc' => esc_html__( 'Select width of right sidebar tablet.', 'autusin' ),
				),				
			)
		);
$options[] = array(
	'title' => esc_html__('Mobile Layout', 'autusin'),
	'desc' => wp_kses( __('<p class="description">WpThemeGo Framework comes with a mobile setting home page layout.</p>', 'autusin'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it autusin for default.
	'icon' => AUTUSIN_URL.'/admin/img/glyphicons/glyphicons_163_iphone.png',
			//Lets leave this as a autusin section, no options just some intro text set above.
	'fields' => array(				
		array(
			'id' => 'mobile_enable',
			'type' => 'checkbox',
			'title' => esc_html__('Enable Mobile Layout', 'autusin'),
			'sub_desc' => '',
			'desc' => '',
							'std' => '1'// 1 = on | 0 = off
						),

		array(
			'id' => 'mobile_logo',
			'type' => 'upload',
			'title' => esc_html__('Logo Mobile Image', 'autusin'),
			'sub_desc' => esc_html__( 'Use the Upload button to upload the new mobile logo', 'autusin' ),
			'std' => get_template_directory_uri().'/assets/img/logo-mobile.png'
		),

		array(
			'id' => 'mobile_logo_account',
			'type' => 'upload',
			'title' => esc_html__('Logo Mobile My Account Page', 'autusin'),
			'sub_desc' => esc_html__( 'Use the Upload button to upload the new mobile logo in my account page', 'autusin' ),
			'std' => get_template_directory_uri().'/assets/img/icon-myaccount.png'
		),

		array(
			'id' => 'sticky_mobile',
			'type' => 'checkbox',
			'title' => esc_html__('Sticky Mobile', 'autusin'),
			'sub_desc' => '',
			'desc' => '',
							'std' => '0'// 1 = on | 0 = off
				),

		array(
			'id' => 'mobile_content',
			'type' => 'pages_select',
			'title' => esc_html__('Mobile Layout Content', 'autusin'),
			'sub_desc' => esc_html__('Select content index for this mobile layout', 'autusin'),
			'std' => ''
		),

		array(
			'id' => 'mobile_header_style',
			'type' => 'select',
			'title' => esc_html__('Header Mobile Style', 'autusin'),
			'sub_desc' => esc_html__('Select header mobile style', 'autusin'),
			'options' => array(
				'mstyle1'  => esc_html__( 'Style 1', 'autusin' ),
			),
			'std' => 'style1'
		),

		array(
			'id' => 'mobile_footer_style',
			'type' => 'select',
			'title' => esc_html__('Footer Mobile Style', 'autusin'),
			'sub_desc' => esc_html__('Select footer mobile style', 'autusin'),
			'options' => array(
				'mstyle1'  => esc_html__( 'Style 1', 'autusin' ),
			),
			'std' => 'style1'
		),

		array(
			'id' => 'mobile_addcart',
			'type' => 'checkbox',
			'title' => esc_html__('Enable Add To Cart Button', 'autusin'),
			'sub_desc' => esc_html__( 'Enable Add To Cart Button on product listing', 'autusin' ),
			'desc' => '',
						'std' => '0'// 1 = on | 0 = off
					),

		array(
			'id' => 'mobile_header_inside',
			'type' => 'checkbox',
			'title' => esc_html__('Enable Header Other Pages', 'autusin'),
			'sub_desc' => esc_html__( 'Enable header in other pages which are different with homepage', 'autusin' ),
			'desc' => '',
						'std' => '0'// 1 = on | 0 = off
					),

		array(
			'id' => 'mobile_jquery',
			'type' => 'checkbox',
			'title' => esc_html__('Include Jquery Autusinlution', 'autusin'),
			'sub_desc' => esc_html__( 'Enable jquery autusinlution slider on mobile layout.', 'autusin' ),
			'desc' => '',
						'std' => '0'// 1 = on | 0 = off
					),
	)
);

$options[] = array(
	'title' => esc_html__('Header & Footer', 'autusin'),
	'desc' => wp_kses( __('<p class="description">WpThemeGo Framework comes with a header and footer setting that allows you to build style header.</p>', 'autusin'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it autusin for default.
	'icon' => AUTUSIN_URL.'/admin/img/glyphicons/glyphicons_336_read_it_later.png',
			//Lets leave this as a autusin section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'header_style',
			'type' => 'select',
			'title' => esc_html__('Header Style', 'autusin'),
			'sub_desc' => esc_html__('Select Header style', 'autusin'),
			'options' => array(
				'style1'  => esc_html__( 'Style 1', 'autusin' ),
				'style2'  => esc_html__( 'Style 2', 'autusin' ),
			),
			'std' => 'style1'
		),

		array(
			'id' => 'disable_search',
			'title' => esc_html__( 'Disable Search', 'autusin' ),
			'type' => 'checkbox',
			'sub_desc' => esc_html__( 'Check this to disable search on header', 'autusin' ),
			'desc' => '',
			'std' => '0'
		),

		array(
			'id' => 'disable_cart',
			'title' => esc_html__( 'Disable Cart', 'autusin' ),
			'type' => 'checkbox',
			'sub_desc' => esc_html__( 'Check this to disable cart on header', 'autusin' ),
			'desc' => '',
			'std' => '0'
		),				

		array(
			'id' => 'footer_style',
			'type' => 'pages_select',
			'title' => esc_html__('Footer Style', 'autusin'),
			'sub_desc' => esc_html__('Select Footer style', 'autusin'),
			'std' => ''
		),

		array(
			'id' => 'footer_copyright',
			'type' => 'editor',
			'sub_desc' => '',
			'title' => esc_html__( 'Copyright text', 'autusin' )
		),	

	)
);
$options[] = array(
	'title' => esc_html__('Navbar Options', 'autusin'),
	'desc' => wp_kses( __('<p class="description">If you got a big site with a lot of sub menus we recommend using a mega menu. Just select the dropbox to display a menu as mega menu or dropdown menu.</p>', 'autusin'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it autusin for default.
	'icon' => AUTUSIN_URL.'/admin/img/glyphicons/glyphicons_157_show_lines.png',
			//Lets leave this as a autusin section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'menu_type',
			'type' => 'select',
			'title' => esc_html__('Menu Type', 'autusin'),
			'options' => array( 
				'dropdown' => esc_html__( 'Dropdown Menu', 'autusin' ), 
				'mega' => esc_html__( 'Mega Menu', 'autusin' ) 
			),
			'std' => 'mega'
		),	

		array(
			'id' => 'menu_location',
			'type' => 'menu_location_multi_select',
			'title' => esc_html__('Theme Location', 'autusin'),
			'sub_desc' => esc_html__( 'Select theme location to active mega menu and menu responsive.', 'autusin' ),
			'std' => 'primary_menu'
		),		

		array(
			'id' => 'sticky_menu',
			'type' => 'checkbox',
			'title' => esc_html__('Active sticky menu', 'autusin'),
			'sub_desc' => '',
			'desc' => '',
						'std' => '0'// 1 = on | 0 = off
					),

		array(
			'id' => 'more_menu',
			'type' => 'checkbox',
			'title' => esc_html__('Active More Menu', 'autusin'),
			'sub_desc' => esc_html__('Active more menu if your primary menu is too long', 'autusin'),
			'desc' => '',
						'std' => '0'// 1 = on | 0 = off
					),

		array(
			'id' => 'menu_event',
			'type' => 'select',
			'title' => esc_html__('Menu Event', 'autusin'),
			'options' => array( 
				'' 		=> esc_html__( 'Hover Event', 'autusin' ), 
				'click' => esc_html__( 'Click Event', 'autusin' ) 
			),
			'std' => ''
		),

		array(
			'id' => 'menu_number_item',
			'type' => 'text',
			'title' => esc_html__( 'Number Item Vertical', 'autusin' ),
			'sub_desc' => esc_html__( 'Number item vertical to show', 'autusin' ),
			'std' => 8
		),	

		array(
			'id' => 'menu_title_text',
			'type' => 'text',
			'title' => esc_html__('Vertical Title Text', 'autusin'),
			'sub_desc' => esc_html__( 'Change title text on vertical menu', 'autusin' ),
			'std' => ''
		),

		array(
			'id' => 'menu_more_text',
			'type' => 'text',
			'title' => esc_html__('Vertical More Text', 'autusin'),
			'sub_desc' => esc_html__( 'Change more text on vertical menu', 'autusin' ),
			'std' => ''
		),

		array(
			'id' => 'menu_less_text',
			'type' => 'text',
			'title' => esc_html__('Vertical Less Text', 'autusin'),
			'sub_desc' => esc_html__( 'Change less text on vertical menu', 'autusin' ),
			'std' => ''
		)	
	)
);
$options[] = array(
	'title' => esc_html__('Blog Options', 'autusin'),
	'desc' => wp_kses( __('<p class="description">Select layout in blog listing page.</p>', 'autusin'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it autusin for default.
	'icon' => AUTUSIN_URL.'/admin/img/glyphicons/glyphicons_071_book.png',
		//Lets leave this as a autusin section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'sidebar_blog',
			'type' => 'select',
			'title' => esc_html__('Sidebar Blog Layout', 'autusin'),
			'options' => array(
				'full' 	=> esc_html__( 'Full Layout', 'autusin' ),		
				'left'	=> esc_html__( 'Left Sidebar', 'autusin' ),
				'right' => esc_html__( 'Right Sidebar', 'autusin' ),
			),
			'std' => 'left',
			'sub_desc' => esc_html__( 'Select style sidebar blog', 'autusin' ),
		),
		array(
			'id' => 'blog_layout',
			'type' => 'select',
			'title' => esc_html__('Layout blog', 'autusin'),
			'options' => array(
				'list'	=>  esc_html__( 'List Layout', 'autusin' ),
				'grid' 	=>  esc_html__( 'Grid Layout', 'autusin' )								
			),
			'std' => 'list',
			'sub_desc' => esc_html__( 'Select style layout blog', 'autusin' ),
		),
		array(
			'id' => 'blog_column',
			'type' => 'select',
			'title' => esc_html__('Blog column', 'autusin'),
			'options' => array(								
				'2' =>  esc_html__( '2 Columns', 'autusin' ),
				'3' =>  esc_html__( '3 Columns', 'autusin' ),
				'4' =>  esc_html__( '4 Columns', 'autusin' )								
			),
			'std' => '2',
			'sub_desc' => esc_html__( 'Select style number column blog', 'autusin' ),
		),
	)
);	
$options[] = array(
	'title' => esc_html__('Product Options', 'autusin'),
	'desc' => wp_kses( __('<p class="description">Select layout in product listing page.</p>', 'autusin'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it autusin for default.
	'icon' => AUTUSIN_URL.'/admin/img/glyphicons/glyphicons_202_shopping_cart.png',
		//Lets leave this as a autusin section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'info_typo1',
			'type' => 'info',
			'title' => esc_html__( 'Product Categories Config', 'autusin' ),
			'desc' => '',
			'class' => 'autusin-opt-info'
		),

		array(
			'id' => 'product_colcat_large',
			'type' => 'select',
			'title' => esc_html__('Product Category Listing column Desktop', 'autusin'),
			'options' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',							
			),
			'std' => '4',
			'sub_desc' => esc_html__( 'Select number of column on Desktop Screen', 'autusin' ),
		),

		array(
			'id' => 'product_colcat_medium',
			'type' => 'select',
			'title' => esc_html__('Product Listing Category column Medium Desktop', 'autusin'),
			'options' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',	
				'5' => '5',
				'6' => '6',
			),
			'std' => '3',
			'sub_desc' => esc_html__( 'Select number of column on Medium Desktop Screen', 'autusin' ),
		),

		array(
			'id' => 'product_colcat_sm',
			'type' => 'select',
			'title' => esc_html__('Product Listing Category column Tablet', 'autusin'),
			'options' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',	
				'5' => '5',
				'6' => '6'
			),
			'std' => '2',
			'sub_desc' => esc_html__( 'Select number of column on Tablet Screen', 'autusin' ),
		),

		array(
			'id' => 'info_typo1',
			'type' => 'info',
			'title' => esc_html__( 'Product General Config', 'autusin' ),
			'desc' => '',
			'class' => 'autusin-opt-info'
		),

		array(
			'id' => 'product_banner',
			'title' => esc_html__( 'Select Banner', 'autusin' ),
			'type' => 'select',
			'sub_desc' => '',
			'options' => array(
				'' 			=> esc_html__( 'Use Banner', 'autusin' ),
				'listing' 	=> esc_html__( 'Use Category Product Image', 'autusin' ),
			),
			'std' => '',
		),

		array(
			'id' => 'product_listing_banner',
			'type' => 'upload',
			'title' => esc_html__('Listing Banner Product', 'autusin'),
			'sub_desc' => esc_html__( 'Use the Upload button to upload banner product listing', 'autusin' ),
			'std' => get_template_directory_uri().'/assets/img/listing-banner.png'
		),

		array(
			'id' => 'product_col_large',
			'type' => 'select',
			'title' => esc_html__('Product Listing column Desktop', 'autusin'),
			'options' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',							
			),
			'std' => '3',
			'sub_desc' => esc_html__( 'Select number of column on Desktop Screen', 'autusin' ),
		),

		array(
			'id' => 'product_col_medium',
			'type' => 'select',
			'title' => esc_html__('Product Listing column Medium Desktop', 'autusin'),
			'options' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',	
				'5' => '5',
				'6' => '6',
			),
			'std' => '2',
			'sub_desc' => esc_html__( 'Select number of column on Medium Desktop Screen', 'autusin' ),
		),

		array(
			'id' => 'product_col_sm',
			'type' => 'select',
			'title' => esc_html__('Product Listing column Tablet', 'autusin'),
			'options' => array(
				'2' => '2',
				'3' => '3',
				'4' => '4',	
				'5' => '5',
				'6' => '6'
			),
			'std' => '2',
			'sub_desc' => esc_html__( 'Select number of column on Tablet Screen', 'autusin' ),
		),

		array(
			'id' => 'sidebar_product',
			'type' => 'select',
			'title' => esc_html__('Sidebar Product Layout', 'autusin'),
			'options' => array(
				'left'	=> esc_html__( 'Left Sidebar', 'autusin' ),
				'full' 	=> esc_html__( 'Full Layout', 'autusin' ),		
				'right' => esc_html__( 'Right Sidebar', 'autusin' )
			),
			'std' => 'left',
			'sub_desc' => esc_html__( 'Select style sidebar product', 'autusin' ),
		),

		array(
			'id' => 'product_quickview',
			'title' => esc_html__( 'Quickview', 'autusin' ),
			'type' => 'checkbox',
			'sub_desc' => '',
			'desc' => esc_html__( 'Turn On/Off Product Quickview', 'autusin' ),
			'std' => '1'
		),

		array(
			'id' => 'product_listing_countdown',
			'title' => esc_html__( 'Enable Countdown', 'autusin' ),
			'type' => 'checkbox',
			'sub_desc' => '',
			'desc' => esc_html__( 'Turn On/Off Product Countdown on product listing', 'autusin' ),
			'std' => '1'
		),


		array(
			'id' => 'product_number',
			'type' => 'text',
			'title' => esc_html__('Product Listing Number', 'autusin'),
			'sub_desc' => esc_html__( 'Show number of product in listing product page.', 'autusin' ),
			'std' => 12
		),

		array(
			'id' => 'newproduct_time',
			'title' => esc_html__( 'New Product', 'autusin' ),
			'type' => 'number',
			'sub_desc' => '',
			'desc' => esc_html__( 'Set day for the new product label from the date publish product.', 'autusin' ),
			'std' => '1'
		),

		array(
			'id' => 'info_typo1',
			'type' => 'info',
			'title' => esc_html__( 'Product Single Config', 'autusin' ),
			'desc' => '',
			'class' => 'autusin-opt-info'
		),

		array(
			'id' => 'sidebar_product_detail',
			'type' => 'select',
			'title' => esc_html__('Sidebar Product Single Layout', 'autusin'),
			'options' => array(
				'left'	=> esc_html__( 'Left Sidebar', 'autusin' ),
				'full' 	=> esc_html__( 'Full Layout', 'autusin' ),		
				'right' => esc_html__( 'Right Sidebar', 'autusin' )
			),
			'std' => 'left',
			'sub_desc' => esc_html__( 'Select style sidebar product single', 'autusin' ),
		),

		array(
			'id' => 'product_single_style',
			'type' => 'select',
			'title' => esc_html__('Product Detail Style', 'autusin'),
			'options' => array(
				'default'	=> esc_html__( 'Default', 'autusin' ),
				'style1' 	=> esc_html__( 'Full Width', 'autusin' ),	
				'style2' 	=> esc_html__( 'Full Width With Accordion', 'autusin' ),	
				'style3' 	=> esc_html__( 'Full Width With Accordion 1', 'autusin' ),	
			),
			'std' => 'default',
			'sub_desc' => esc_html__( 'Select style for product single', 'autusin' ),
		),

		array(
			'id' => 'product_single_thumbnail',
			'type' => 'select',
			'title' => esc_html__('Product Thumbnail Position', 'autusin'),
			'options' => array(
				'bottom'	=> esc_html__( 'Bottom', 'autusin' ),
				'left' 		=> esc_html__( 'Left', 'autusin' ),	
				'right' 	=> esc_html__( 'Right', 'autusin' ),	
				'top' 		=> esc_html__( 'Top', 'autusin' ),					
			),
			'std' => 'bottom',
			'sub_desc' => esc_html__( 'Select style for product single thumbnail', 'autusin' ),
		),		


		array(
			'id' => 'product_zoom',
			'title' => esc_html__( 'Product Zoom', 'autusin' ),
			'type' => 'checkbox',
			'sub_desc' => '',
			'desc' => esc_html__( 'Turn On/Off image zoom when hover on single product', 'autusin' ),
			'std' => '1'
		),

		array(
			'id' => 'product_brand',
			'title' => esc_html__( 'Enable Product Brand Image', 'autusin' ),
			'type' => 'checkbox',
			'sub_desc' => '',
			'desc' => esc_html__( 'Turn On/Off product brand image show on single product.', 'autusin' ),
			'std' => '1'
		),

		array(
			'id' => 'product_single_countdown',
			'title' => esc_html__( 'Enable Countdown Single', 'autusin' ),
			'type' => 'checkbox',
			'sub_desc' => '',
			'desc' => esc_html__( 'Turn On/Off Product Countdown on product single', 'autusin' ),
			'std' => '1'
		),

		array(
			'id' => 'info_typo1',
			'type' => 'info',
			'title' => esc_html__( 'Config For Product Categories Widget', 'autusin' ),
			'desc' => '',
			'class' => 'autusin-opt-info'
		),

		array(
			'id' => 'product_number_item',
			'type' => 'text',
			'title' => esc_html__( 'Category Number Item Show', 'autusin' ),
			'sub_desc' => esc_html__( 'Choose to number of item category that you want to show, leave 0 to show all category', 'autusin' ),
			'std' => 8
		),	

		array(
			'id' => 'product_more_text',
			'type' => 'text',
			'title' => esc_html__( 'Category More Text', 'autusin' ),
			'sub_desc' => esc_html__( 'Change more text on category product', 'autusin' ),
			'std' => ''
		),

		array(
			'id' => 'product_less_text',
			'type' => 'text',
			'title' => esc_html__( 'Category Less Text', 'autusin' ),
			'sub_desc' => esc_html__( 'Change less text on category product', 'autusin' ),
			'std' => ''
		)	
	)
);		
$options[] = array(
	'title' => esc_html__('Typography', 'autusin'),
	'desc' => wp_kses( __('<p class="description">Change the font style of your blog, custom with Google Font.</p>', 'autusin'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it autusin for default.
	'icon' => AUTUSIN_URL.'/admin/img/glyphicons/glyphicons_151_edit.png',
			//Lets leave this as a autusin section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'info_typo1',
			'type' => 'info',
			'title' => esc_html__( 'Global Typography', 'autusin' ),
			'desc' => '',
			'class' => 'autusin-opt-info'
		),

		array(
			'id' => 'google_webfonts',
			'type' => 'google_webfonts',
			'title' => esc_html__('Use Google Webfont', 'autusin'),
			'sub_desc' => esc_html__( 'Insert font style that you actually need on your webpage.', 'autusin' ), 
			'std' => ''
		),

		array(
			'id' => 'webfonts_weight',
			'type' => 'multi_select',
			'sub_desc' => esc_html__( 'For weight, see Google Fonts to custom for each font style.', 'autusin' ),
			'title' => esc_html__('Webfont Weight', 'autusin'),
			'options' => array(
				'100' => '100',
				'200' => '200',
				'300' => '300',
				'400' => '400',
				'500' => '500',
				'600' => '600',
				'700' => '700',
				'800' => '800',
				'900' => '900'
			),
			'std' => ''
		),

		array(
			'id' => 'info_typo2',
			'type' => 'info',
			'title' => esc_html__( 'Header Tag Typography', 'autusin' ),
			'desc' => '',
			'class' => 'autusin-opt-info'
		),

		array(
			'id' => 'header_tag_font',
			'type' => 'google_webfonts',
			'title' => esc_html__('Header Tag Font', 'autusin'),
			'sub_desc' => esc_html__( 'Select custom font for header tag ( h1...h6 )', 'autusin' ), 
			'std' => ''
		),

		array(
			'id' => 'info_typo2',
			'type' => 'info',
			'title' => esc_html__( 'Main Menu Typography', 'autusin' ),
			'desc' => '',
			'class' => 'autusin-opt-info'
		),

		array(
			'id' => 'menu_font',
			'type' => 'google_webfonts',
			'title' => esc_html__('Main Menu Font', 'autusin'),
			'sub_desc' => esc_html__( 'Select custom font for main menu', 'autusin' ), 
			'std' => ''
		),

		array(
			'id' => 'info_typo2',
			'type' => 'info',
			'title' => esc_html__( 'Custom Typography', 'autusin' ),
			'desc' => '',
			'class' => 'autusin-opt-info'
		),

		array(
			'id' => 'custom_font',
			'type' => 'google_webfonts',
			'title' => esc_html__('Custom Font', 'autusin'),
			'sub_desc' => esc_html__( 'Select custom font for custom class', 'autusin' ), 
			'std' => ''
		),

		array(
			'id' => 'custom_font_class',
			'title' => esc_html__( 'Custom Font Class', 'autusin' ),
			'type' => 'text',
			'sub_desc' => esc_html__( 'Put custom class to this field. Each class separated by commas.', 'autusin' ),
			'desc' => '',
			'std' => '',
		),

	)
);

$options[] = array(
	'title' => __('Social', 'autusin'),
	'desc' => wp_kses( __('<p class="description">This feature allow to you link to your social.</p>', 'autusin'), array( 'p' => array( 'class' => array() ) ) ),
		//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
		//You dont have to though, leave it blank for default.
	'icon' => AUTUSIN_URL.'/admin/img/glyphicons/glyphicons_222_share.png',
		//Lets leave this as a blank section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'social-share-fb',
			'title' => esc_html__( 'Facebook', 'autusin' ),
			'type' => 'text',
			'sub_desc' => '',
			'desc' => '',
			'std' => '',
		),
		array(
			'id' => 'social-share-tw',
			'title' => esc_html__( 'Twitter', 'autusin' ),
			'type' => 'text',
			'sub_desc' => '',
			'desc' => '',
			'std' => '',
		),
		array(
			'id' => 'social-share-tumblr',
			'title' => esc_html__( 'Tumblr', 'autusin' ),
			'type' => 'text',
			'sub_desc' => '',
			'desc' => '',
			'std' => '',
		),
		array(
			'id' => 'social-share-in',
			'title' => esc_html__( 'Linkedin', 'autusin' ),
			'type' => 'text',
			'sub_desc' => '',
			'desc' => '',
			'std' => '',
		),
		array(
			'id' => 'social-share-instagram',
			'title' => esc_html__( 'Instagram', 'autusin' ),
			'type' => 'text',
			'sub_desc' => '',
			'desc' => '',
			'std' => '',
		),
		array(
			'id' => 'social-share-go',
			'title' => esc_html__( 'Google+', 'autusin' ),
			'type' => 'text',
			'sub_desc' => '',
			'desc' => '',
			'std' => '',
		),
		array(
			'id' => 'social-share-pi',
			'title' => esc_html__( 'Pinterest', 'autusin' ),
			'type' => 'text',
			'sub_desc' => '',
			'desc' => '',
			'std' => '',
		)

	)
);

$options[] = array(
	'title' => esc_html__('Popup Config', 'autusin'),
	'desc' => wp_kses( __('<p class="description">Enable popup and more config for Popup.</p>', 'autusin'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it autusin for default.
	'icon' => AUTUSIN_URL.'/admin/img/glyphicons/glyphicons_318_more-items.png',
			//Lets leave this as a autusin section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'popup_active',
			'type' => 'checkbox',
			'title' => esc_html__( 'Active Popup Subscribe', 'autusin' ),
			'sub_desc' => esc_html__( 'Check to active popup subscribe', 'autusin' ),
			'desc' => '',
						'std' => '0'// 1 = on | 0 = off
					),	

		array(
			'id' => 'popup_background',
			'title' => esc_html__( 'Popup Background', 'autusin' ),
			'type' => 'upload',
			'sub_desc' => esc_html__( 'Choose popup background image', 'autusin' ),
			'desc' => '',
			'std' => get_template_directory_uri().'/assets/img/popup/bg-main.jpg'
		),

		array(
			'id' => 'popup_content',
			'title' => esc_html__( 'Popup Content', 'autusin' ),
			'type' => 'editor',
			'sub_desc' => esc_html__( 'Change text of popup mode', 'autusin' ),
			'desc' => '',
			'std' => ''
		),	

		array(
			'id' => 'popup_form',
			'title' => esc_html__( 'Popup Form', 'autusin' ),
			'type' => 'text',
			'sub_desc' => esc_html__( 'Put shortcode form to this field and it will be shown on popup mode frontend.', 'autusin' ),
			'desc' => '',
			'std' => ''
		),

	)
);

$options[] = array(
	'title' => esc_html__('Advanced', 'autusin'),
	'desc' => wp_kses( __('<p class="description">Custom advanced with Cpanel, Widget advanced, Developer mode </p>', 'autusin'), array( 'p' => array( 'class' => array() ) ) ),
			//all the glyphicons are included in the options folder, so you can hook into them, or link to your own custom ones.
			//You dont have to though, leave it autusin for default.
	'icon' => AUTUSIN_URL.'/admin/img/glyphicons/glyphicons_083_random.png',
			//Lets leave this as a autusin section, no options just some intro text set above.
	'fields' => array(
		array(
			'id' => 'show_cpanel',
			'title' => esc_html__( 'Show cPanel', 'autusin' ),
			'type' => 'checkbox',
			'sub_desc' => esc_html__( 'Turn on/off Cpanel', 'autusin' ),
			'desc' => '',
			'std' => ''
		),

		array(
			'id' => 'widget-advanced',
			'title' => esc_html__('Widget Advanced', 'autusin'),
			'type' => 'checkbox',
			'sub_desc' => esc_html__( 'Turn on/off Widget Advanced', 'autusin' ),
			'desc' => '',
			'std' => '1'
		),					

		array(
			'id' => 'social_share',
			'title' => esc_html__( 'Social Share', 'autusin' ),
			'type' => 'checkbox',
			'sub_desc' => esc_html__( 'Turn on/off social share', 'autusin' ),
			'desc' => '',
			'std' => '1'
		),

		array(
			'id' => 'breadcrumb_active',
			'title' => esc_html__( 'Turn Off Breadcrumb', 'autusin' ),
			'type' => 'checkbox',
			'sub_desc' => esc_html__( 'Turn off breadcumb on all page', 'autusin' ),
			'desc' => '',
			'std' => '0'
		),

		array(
			'id' => 'back_active',
			'type' => 'checkbox',
			'title' => esc_html__('Back to top', 'autusin'),
			'sub_desc' => '',
			'desc' => '',
						'std' => '1'// 1 = on | 0 = off
					),	

		array(
			'id' => 'direction',
			'type' => 'select',
			'title' => esc_html__('Direction', 'autusin'),
			'options' => array( 'ltr' => 'Left to Right', 'rtl' => 'Right to Left' ),
			'std' => 'ltr'
		),


	)
);

$options_args = array();

	//Setup custom links in the footer for share icons
$options_args['share_icons']['facebook'] = array(
	'link' => 'http://www.facebook.com/wpthemego',
	'title' => 'Facebook',
	'img' => AUTUSIN_URL.'/admin/img/glyphicons/glyphicons_320_facebook.png'
);
$options_args['share_icons']['twitter'] = array(
	'link' => 'https://twitter.com/wpthemego/',
	'title' => 'Folow me on Twitter',
	'img' => AUTUSIN_URL.'/admin/img/glyphicons/glyphicons_322_twitter.png'
);


	//Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
$options_args['opt_name'] = SW_THEME;
$webfonts = ( sw_options( 'google_webfonts_api' ) ) ? sw_options( 'google_webfonts_api' ) : 'AIzaSyAL_XMT9t2KuBe2MIcofGl6YF1IFzfB4L4';
	$options_args['google_api_key'] = $webfonts; //must be defined for use with google webfonts field type

	//Custom menu title for options page - default is "Options"
	$options_args['menu_title'] = esc_html__('Theme Options', 'autusin');

	//Custom Page Title for options page - default is "Options"
	$options_args['page_title'] = esc_html__('Autusin Options ', 'autusin');

	//Custom page slug for options page (wp-admin/themes.php?page=***) - default is "autusin_theme_options"
	$options_args['page_slug'] = 'autusin_theme_options';

	//page type - "menu" (adds a top menu section) or "submenu" (adds a submenu) - default is set to "menu"
	$options_args['page_type'] = 'submenu';

	//custom page location - default 100 - must be unique or will override other items
	$options_args['page_position'] = 27;
	$sw_options = new SW_Options( $options, $options_args );
}
add_action( 'init', 'autusin_Options_Setup', 0 );
// autusin_Options_Setup();
endif; 


/*
** Define widget
*/
function autusin_widget_setup_args(){
	$autusin_widget_areas = array(
		
		array(
			'name' => esc_html__('Sidebar Left Blog', 'autusin'),
			'id'   => 'left-blog',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="block-title-widget"><h2><span>',
			'after_title' => '</span></h2></div>'
		),

		array(
			'name' => esc_html__('Sidebar Right Blog', 'autusin'),
			'id'   => 'right-blog',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="block-title-widget"><h2><span>',
			'after_title' => '</span></h2></div>'
		),
		
		array(
			'name' => esc_html__('Header Left', 'autusin'),
			'id'   => 'header-left',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		),
		array(
			'name' => esc_html__('Header Mid', 'autusin'),
			'id'   => 'mid-header',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		),
		array(
			'name' => esc_html__('Header Right', 'autusin'),
			'id'   => 'header-right',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		),
		array(
			'name' => esc_html__('Header Right2', 'autusin'),
			'id'   => 'header-right2',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		),
		array(
			'name' => esc_html__('Bottom Header', 'autusin'),
			'id'   => 'bottom-header',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		),

		array(
			'name' => esc_html__('Sidebar Left Product', 'autusin'),
			'id'   => 'left-product',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="block-title-widget"><h2><span>',
			'after_title' => '</span></h2></div>'
		),
		
		array(
			'name' => esc_html__('Sidebar Right Product', 'autusin'),
			'id'   => 'right-product',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="block-title-widget"><h2><span>',
			'after_title' => '</span></h2></div>'
		),
		
		array(
			'name' => esc_html__('Banner Mobile', 'autusin'),
			'id'   => 'banner-mobile',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="block-title-widget"><h2><span>',
			'after_title' => '</span></h2></div>'
		),
		
		array(
			'name' => esc_html__('Sidebar Left Detail Product', 'autusin'),
			'id'   => 'left-product-detail',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="block-title-widget"><h2><span>',
			'after_title' => '</span></h2></div>'
		),
		
		array(
			'name' => esc_html__('Sidebar Right Detail Product', 'autusin'),
			'id'   => 'right-product-detail',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="block-title-widget"><h2><span>',
			'after_title' => '</span></h2></div>'
		),
		
		array(
			'name' => esc_html__('Sidebar Bottom Detail Product', 'autusin'),
			'id'   => 'bottom-detail-product',
			'before_widget' => '<div class="widget %1$s %2$s" data-scroll-reveal="enter bottom move 20px wait 0.2s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		),
		
		array(
			'name' => esc_html__('Bottom Detail Product Mobile', 'autusin'),
			'id'   => 'bottom-detail-product-mobile',
			'before_widget' => '<div class="widget %1$s %2$s" data-scroll-reveal="enter bottom move 20px wait 0.2s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		),
		
		array(
			'name' => esc_html__('Filter Mobile', 'autusin'),
			'id'   => 'filter-mobile',
			'before_widget' => '<div class="widget %1$s %2$s" data-scroll-reveal="enter bottom move 20px wait 0.2s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		),

		array(
			'name' => esc_html__('Footer Copyright', 'autusin'),
			'id'   => 'footer-copyright',
			'before_widget' => '<div class="widget %1$s %2$s"><div class="widget-inner">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>'
		),
	);
return apply_filters( 'autusin_widget_register', $autusin_widget_areas );
}