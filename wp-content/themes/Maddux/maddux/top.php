<?php
global $smof_data, $ts_top_ad, $woocommerce, $ts_page_id;
$ts_small_nav_visibility = ts_option_vs_default('small_nav_visibility','small_nav_social');
$ts_show_top_ad = (ts_option_vs_default('show_top_ad', 1) == 1) ? true : false;
$ts_show_top_bar = (ts_option_vs_default('show_top_bar', 1) == 1) ? true : false;
?>
                <div id="top-wrap">             
                    <!-- top-bar -->
                    <?php
                    if(ts_attr_is_true($ts_show_top_bar)) :
                        echo ts_get_top_bar();
                    endif;
                    ?>
                    <!-- /top-bar -->
                              
                    <!-- top-ad -->
                    <?php
                    if($ts_show_top_ad) :
                        echo ts_get_top_ad();
                    endif;
                    ?>
                    <!-- /top-ad -->
                    
                    <!-- Top -->
                    <div id="top-container" class="top-default">
                        <div id="top" class="ts-top container">
                            <div id="logo-nav" class="container main-logo-nav">
                                <div id="logo" class="main-logo">
                                    <?php 
                                    echo ts_theme_logo();
                                    ?>
                                </div>
                                
                                <?php
                                if(ts_option_vs_default('logo_alignment_layout') != 'centered') :   
                                    $social_icons_search_content_option = ts_option_vs_default('social_icons_search_content_option', 'social_search');
                                    if($social_icons_search_content_option == 'social_search') :
                                ?>
                                
                                <div id="social-search">
                                    <div id="header-social" class="social-icons-widget-style"><?php echo ts_small_nav_social();?></div>
                                    
                                    <?php                                    
                                    if(ts_option_vs_default('show_top_search', 1) == 1) :
                                        echo ts_html5_search_form();
                                    endif;
                                    ?>
                                </div>
                                
                                <?php
                                elseif($social_icons_search_content_option == 'alternative_field') :
                                ?>
                                
                                <div id="social-search" class="alternative-field">
                                    <?php echo ts_option_vs_default('alternative_to_social_icons_search', '');?>
                                </div>
                                
                                <?php
                                elseif($social_icons_search_content_option == 'top_header_widget_area') :
                                ?>
                                
                                <div id="social-search" class="top-header-widget-area">
                                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("ts-top-header-widgets-area") ) : ?>  
                                    <?php endif; ?>
                                </div>
                                
                                <?php
                                    endif;
                                endif;
                                ?>
                                
                            </div>
                            
                            <div id="nav" class="main-nav-wrap">
                                <div class="mobile-nav"><a id="ts-top-mobile-menu" class="mobile-menu"><strong class="mobile-menu-icon"></strong><span class="mobile-menu-sep"></span><?php _e('Site Navigation','ThemeStockyard');?></a></div>
                                <div id="main-nav" class="main-nav normal">
                                    <?php
                                    $nav_menu_options = array(
                                        'container'         => false, 
                                        'theme_location'    => 'main_nav', 
                                        'menu_class'        => 'sf-menu clearfix', 
                                        'depth'             => 3, 
                                        'menu_id'           => 'main-nav-links',
                                        'link_before'       => '<span>', 
                                        'link_after'        => '</span>',
                                        'items_wrap'        => '<ul class="sf-menu clearfix">%3$s</ul>'
                                    );
                                    if( function_exists( 'uberMenu_direct' ) ) {
                                        $ts_ubermenu = uberMenu_direct( 'main_nav', false, false);
                                        echo $ts_ubermenu;
                                    } else {
                                        wp_nav_menu($nav_menu_options);
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / #top -->
                </div>
                <!-- / #top-wrap -->
