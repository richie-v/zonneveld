<?php
/* 
** Content Header
*/
$autusin_page_header = get_post_meta(get_the_ID(), 'page_header_style', true);
$autusin_colorset = sw_options('scheme');
$autusin_logo = sw_options('sitelogo');
$sticky_menu = sw_options('sticky_menu');
$autusin_page_header = (get_post_meta(get_the_ID(), 'page_header_style', true) != '') ? get_post_meta(get_the_ID(), 'page_header_style', true) : sw_options('header_style');
$autusin_menu_item = (sw_options('menu_number_item')) ? sw_options('menu_number_item') : 9;
$autusin_more_text = (sw_options('menu_more_text')) ? sw_options('menu_more_text') : esc_html__('See More', 'autusin');
$autusin_less_text = (sw_options('menu_less_text')) ? sw_options('menu_less_text') : esc_html__('See Less', 'autusin');
$autusin_menu_text = (sw_options('menu_title_text')) ? sw_options('menu_title_text') : esc_html__('All Departments', 'autusin');
?>
<header id="header" class="header header-style1">
    <div class="header-top">
        <div class="container">
            <!-- Sidebar Left -->
            <?php if (is_active_sidebar('header-left')) { ?>
                <div class="left-header pull-left">
                    <?php dynamic_sidebar('header-left'); ?>
                </div>
            <?php } ?>
            <!-- Sidebar Right -->
            <?php if (is_active_sidebar('header-right')) { ?>
                <div class="right-header pull-right">
                    <?php /*dynamic_sidebar('header-right'); */ ?>
                    <div class="widget_text widget-1 widget-first widget custom_html-3 widget_custom_html">
                        <div class="widget_text widget-inner">
                            <div class="textwidget custom-html-widget">
                                <div id="lang_sel">
                                    <ul class="nav">
                                        <?php pll_the_languages(array('show_flags'=>1,'show_names'=>0));?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if (is_active_sidebar('header-right2')) { ?>
                <div class="right-header2 pull-right">
                    <div class="sw-autusin-account pull-right">
                        <i class="fa fa-user"
                           aria-hidden="true"></i><span><?php esc_html_e('My Account', 'autusin') ?></span>
                        <div id="sidebar-top-right" class="sidebar-top-right">
                            <?php dynamic_sidebar('header-right2'); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- Sidebar Top Menu -->
            <?php if (!sw_options('disable_search')) : ?>
                <div class="search-cate pull-right">
                    <div class="icon-search">
                        <i class="fa fa-search"></i><span><?php esc_html_e('Search', 'autusin') ?></span>
                    </div>
                    <?php if (is_active_sidebar('search') && class_exists('sw_woo_search_widget')): ?>
                        <?php dynamic_sidebar('search'); ?>
                    <?php else : ?>
                        <div class="widget autusin_top non-margin">
                            <div class="widget-inner">
                                <?php get_template_part('widgets/sw_top/searchcate'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="header-mid">
        <div class="container">
            <div class="row">
                <!-- Logo -->
                <div class="mid-header col-lg-2 col-md-3 col-sm-3 col-xs-12 pull-left">
                    <div class="autusin-logo">
                        <?php autusin_logo(); ?>
                    </div>
                </div>
                <!-- Primary navbar -->
                <?php if (has_nav_menu('primary_menu')) { ?>
                    <div id="main-menu" class="main-menu pull-left clearfix">
                        <nav id="primary-menu" class="primary-menu">
                            <div class="mid-header clearfix">
                                <div class="navbar-inner navbar-inverse">
                                    <?php
                                    $autusin_menu_class = 'nav nav-pills';
                                    if ('mega' == sw_options('menu_type')) {
                                        $autusin_menu_class .= ' nav-mega';
                                    } else $autusin_menu_class .= ' nav-css';
                                    ?>
                                    <?php wp_nav_menu(array('theme_location' => 'primary_menu', 'menu_class' => $autusin_menu_class)); ?>
                                </div>
                            </div>
                        </nav>
                    </div>
                <?php } ?>
                <!-- /Primary navbar -->
                <!-- Sidebar Right -->
                <?php if (!sw_options('disable_cart')) : ?>
                    <?php get_template_part('woocommerce/minicart-ajax'); ?>
                <?php endif; ?>
                <?php if (is_active_sidebar('bottom-header')) { ?>
                    <div class="bottom-header pull-right">
                        <?php dynamic_sidebar('bottom-header'); ?>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</header>