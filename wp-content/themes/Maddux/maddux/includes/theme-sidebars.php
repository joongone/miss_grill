<?php
global $smof_data;

/*-----------------------------------------------------------------------------------*/
/* Register the theme's widget areas
/*-----------------------------------------------------------------------------------*/

if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name'          => __('Primary Sidebar', 'ThemeStockyard'),
        'description'   => __('Default sidebar.', 'ThemeStockyard'),
        'id'            => 'ts-primary-sidebar',
        'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
        'after_widget'  => '</div>',
        'before_title'  => '<div class="page-title clearfix"><h5>',
        'after_title'   => '</h5></div>'
    ));
    
    if(ts_option_vs_default('social_icons_search_content_option', 'social_search') == 'top_header_widget_area') {
        register_sidebar(array(
            'name'          => __('Top Header Widgets Area', 'ThemeStockyard'),
            'description'   => __('Shown as an alternative to the social icons and search field.', 'ThemeStockyard'),
            'id'            => 'ts-top-header-widgets-area',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<div class="page-title clearfix"><h5>',
            'after_title'   => '</h5></div>'
        ));
    }



    if(isset($smof_data['footer_layout'])) {
        switch ($smof_data['footer_layout']) {
            case "footer1":
                register_sidebar(array(
                    'name'          => __('Footer Area 1', 'ThemeStockyard'),
                    'id'            => 'ts-footer-sidebar-1',
                    'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<div class="page-title clearfix"><h5>',
                    'after_title'   => '</h5></div>'
                ));
                
                register_sidebar(array(
                    'name'          => __('Footer Area 2', 'ThemeStockyard'),
                    'id'            => 'ts-footer-sidebar-2',
                    'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<div class="page-title clearfix"><h5>',
                    'after_title'   => '</h5></div>'
                ));
                
                register_sidebar(array(
                    'name'          => __('Footer Area 3', 'ThemeStockyard'),
                    'id'            => 'ts-footer-sidebar-3',
                    'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<div class="page-title clearfix"><h5>',
                    'after_title'   => '</h5></div>'
                ));
                
                register_sidebar(array(
                    'name'          => __('Footer Area 4', 'ThemeStockyard'),
                    'id'            => 'ts-footer-sidebar-4',
                    'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<div class="page-title clearfix"><h5>',
                    'after_title'   => '</h5></div>'
                ));
                break;

            default:
            case "footer2":
            case "footer5":
            case "footer6":
                register_sidebar(array(
                    'name'          => __('Footer Area 1', 'ThemeStockyard'),
                    'id'            => 'ts-footer-sidebar-1',
                    'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<div class="page-title clearfix"><h5>',
                    'after_title'   => '</h5></div>'
                ));
                
                register_sidebar(array(
                    'name'          => __('Footer Area 2', 'ThemeStockyard'),
                    'id'            => 'ts-footer-sidebar-2',
                    'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<div class="page-title clearfix"><h5>',
                    'after_title'   => '</h5></div>'
                ));
                
                register_sidebar(array(
                    'name'          => __('Footer Area 3', 'ThemeStockyard'),
                    'id'            => 'ts-footer-sidebar-3',
                    'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<div class="page-title clearfix"><h5>',
                    'after_title'   => '</h5></div>'
                ));
                break;

            case "footer3":
            case "footer7":
            case "footer8":
                register_sidebar(array(
                    'name'          => __('Footer Area 1', 'ThemeStockyard'),
                    'id'            => 'ts-footer-sidebar-1',
                    'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<div class="page-title clearfix"><h5>',
                    'after_title'   => '</h5></div>'
                ));
                
                register_sidebar(array(
                    'name'          => __('Footer Area 2', 'ThemeStockyard'),
                    'id'            => 'ts-footer-sidebar-2',
                    'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<div class="page-title clearfix"><h5>',
                    'after_title'   => '</h5></div>'
                ));
                break;

            case "footer4":
                register_sidebar(array(
                    'name'          => __('Footer Area 1', 'ThemeStockyard'),
                    'id'            => 'ts-footer-sidebar-1',
                    'before_widget' => '<div id="%1$s" class="widget %2$s clearfix">',
                    'after_widget'  => '</div>',
                    'before_title'  => '<div class="page-title clearfix"><h5>',
                    'after_title'   => '</h5></div>'
                ));
                break;

       }
   }
}