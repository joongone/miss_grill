<?php
function ts_dynamic_css($color = '', $layout = '', $bg_image = '') 
{
    if(function_exists('ts_option_vs_default'))
    {
?>
    <?php
    $sidebar_width = ts_option_vs_default('sidebar_width', '310px');
    ?>
    #sidebar { width: <?php echo ts_sidebar_width($sidebar_width, 'sidebar');?>; }
    #main.has-sidebar-content-left #ts-post-content-wrap,
    #main.has-sidebar-comments-left #ts-comments-wrap,
    #main.has-sidebar-content-right #ts-post-content-wrap,
    #main.has-sidebar-comments-right #ts-comments-wrap,
    #main { width: <?php echo ts_sidebar_width($sidebar_width, 'main');?>; }
    
    <?php
    /* ubermenu compatibility coming soon if sales are decent */
    if(ts_option_vs_default('override_ubermenu_styling', 1) == 1 && function_exists('uberMenu_direct')) :
        $ubermenu_prefix = 'uber';
        $ubermenu_important = ' !important';
        $ubermenu = true;
    else :
        $ubermenu_prefix = '';
        $ubermenu_important = '';
        $ubermenu = false;
    endif;
    ?>

    
    
    
    
    
    /******************** ***********************/
    

    /* SECTION 3: TYPOGRAPHY

        Within this section....
        - Section 3a: font-famiy
        - Section 3b: font-size
        - Section 3c: font-style
        - Section 3d: line-height
    ================================================== */
    <?php
    $logo_font_family = ts_option_vs_default('logo_font_family', 'Droid Serif');    
    $body_font_family = ts_option_vs_default('body_font_family', 'Droid Serif');    
    $h1_font_family = ts_option_vs_default('h1_font_family', 'Droid Serif');
    $h2_font_family = ts_option_vs_default('h2_font_family', 'Droid Serif');
    $h3_font_family = ts_option_vs_default('h3_font_family', 'Droid Serif');
    $h4_font_family = ts_option_vs_default('h4_font_family', 'Droid Serif');
    $h5_font_family = ts_option_vs_default('h5_font_family', 'Open Sans');
    $h6_font_family = ts_option_vs_default('h6_font_family', 'Open Sans');    
    $small_font_family = ts_option_vs_default('small_font_family', 'Open Sans');    
    $main_nav_font_family = ts_option_vs_default('main_nav_font_family', 'Open Sans');
    $main_nav_submenu_font = ts_option_vs_default('main_nav_submenu_font', 'Open Sans');
    ?>

    /* Section 3a: font-family */
    #logo .logo-text { font-family: <?php echo $logo_font_family;?>; }
    body { font-family: <?php echo $body_font_family;?>; }
    h1 { font-family: <?php echo $h1_font_family;?>; }
    h2 { font-family: <?php echo $h2_font_family;?>; }
    h3 { font-family: <?php echo $h3_font_family;?>; }
    h4 { font-family: <?php echo $h4_font_family;?>; }
    h5,
    .ts-tabs-widget .tab-header li { font-family: <?php echo $h5_font_family;?>; }
    h6 { font-family: <?php echo $h6_font_family;?>; }
    .main-nav { font-family: <?php echo $main_nav_font_family;?>; }
    .main-nav ul ul { font-family: <?php echo $main_nav_submenu_font;?>; }
    small,
    .small,
    .smaller,
    .mimic-small,
    .mimic-smaller,
    button,
    .button,
    .wpcf7-submit,
    #button,
    #header-social,
    .dem-tags a, 
    .post-tags a,
    #copyright-nav,
    .widget .tagcloud a,
    select,
    textarea, 
    input[type="tel"], 
    input[type="url"],
    input[type="text"], 
    input[type="email"],  
    input[type="search"],
    input[type="submit"],
    input[type="password"],
    .post .wp-caption-text,
    .mimic-post .wp-caption-text,
    ol.commentlist .comment-head,
    .post-single-prev-next strong,
    .woocommerce input[type="submit"], 
    .woocommerce input[type="button"], 
    .woocommerce .product-remove a.remove,
    .woocommerce-page .select2-drop-active,
    .woocommerce .select2-container .select2-choice { font-family: <?php echo $small_font_family;?>; }

    
    <?php    
    $body_font_size  = ts_option_vs_default('body_font_style::size', '14px');
    ?>
    /* Section 3b: font-size */
    body,
    blockquote p,
    select,
    textarea, 
    input[type="tel"], 
    input[type="url"],
    input[type="text"], 
    input[type="email"],  
    input[type="search"],
    input[type="number"],
    input[type="password"],
    .woocommerce-page .select2-drop-active,
    .woocommerce .select2-container .select2-choice { font-size: <?php echo $body_font_size;?>; }
    
    <?php
    $h1_font_size  = ts_option_vs_default('h1_font_style::size', '36px');
    $h1_font_style  = ts_option_vs_default('h1_font_style::style', 'normal');
    $h2_font_size  = ts_option_vs_default('h2_font_style::size', '26px');
    $h2_font_style  = ts_option_vs_default('h2_font_style::style', 'normal');
    $h3_font_size  = ts_option_vs_default('h3_font_style::size', '20px');
    $h3_font_style  = ts_option_vs_default('h3_font_style::style', 'normal');
    $h4_font_size  = ts_option_vs_default('h4_font_style::size', '15px');
    $h4_font_style  = ts_option_vs_default('h4_font_style::style', 'normal');
    $h5_font_size  = ts_option_vs_default('h5_font_style::size', '14px');
    $h5_font_style  = ts_option_vs_default('h5_font_style::style', 'normal');
    $h6_font_size  = ts_option_vs_default('h6_font_style::size', '12px');
    $h6_font_style  = ts_option_vs_default('h6_font_style::style', 'normal');
    ?>
    h1 { font-size: <?php echo $h1_font_size;?>; <?php echo aq_font_style($h1_font_style);?> }
    h2 { font-size: <?php echo $h2_font_size;?>; <?php echo aq_font_style($h2_font_style);?> }
    h3 { font-size: <?php echo $h3_font_size;?>; <?php echo aq_font_style($h3_font_style);?> }
    h4 { font-size: <?php echo $h4_font_size;?>; <?php echo aq_font_style($h4_font_style);?> }
    h5,
    .ts-tabs-widget .tab-header li { font-size: <?php echo $h5_font_size;?>; <?php echo aq_font_style($h5_font_style);?> }
    h6 { font-size: <?php echo $h6_font_size;?>; <?php echo aq_font_style($h6_font_style);?> }
    
    <?php
    $main_nav_font_size  = ts_option_vs_default('main_nav_font_style::size', '14px');
    $main_nav_submenu_font_size  = ts_option_vs_default('main_nav_submenu_font_style::size', '14px');
    ?>
    .main-nav > ul > li,
    .main-nav > div > ul > li,
    #header-social .social .icon-style,
    .social-icons-widget-style .social .icon-style { font-size: <?php echo $main_nav_font_size;?>; }
    .main-nav ul ul { font-size: <?php echo $main_nav_submenu_font_size;?>; }
    
    <?php
    $logo_font_size  = ts_option_vs_default('logo_font_style::size', '36px');
    $logo_font_style  = ts_option_vs_default('logo_font_style::style', 'normal');
    ?>
    #logo .logo-text { font-size: <?php echo $logo_font_size;?>; <?php echo aq_font_style($logo_font_style);?> }



    /* SECTION 4: BACKGROUNDS
    ================================================== */
    
    <?php
    $primary_color = ts_option_vs_default('primary_color', '#E8B71A');
    $primary_color_rgb = (isset($primary_color)) ? ts_hex2rgb($primary_color, 'string') : '232, 183, 26';
    $standard_border_color = ts_option_vs_default('standard_border_color', '#eee');
    $subtle_bg_color = ts_option_vs_default('subtle_bg_color', '#f5f5f5');
    ?>

    /* primary/highlight color */
    .widget_calendar table td#today,
    #title-bar ul.post-categories li a,
    #ts-news-ticker-nav .flex-direction-nav a,
    button,
    .button,
    .wpcf7-submit,
    #button,
    .spinner > div,
    .woocommerce input[type="submit"], 
    .woocommerce input[type="button"], 
    .woocommerce .product-remove a.remove { background-color: <?php echo $primary_color;?>; }

    <?php
    $use_custom_background_image = ts_option_vs_default('use_custom_background_image', 0);
    $custom_background_image = ts_option_vs_default('custom_background_image', null);
    $custom_background_position = ts_option_vs_default('custom_background_positioning::position', 'top left');
    $custom_background_repeat = ts_option_vs_default('custom_background_positioning::repeat', 'repeat');
    $custom_background_attachment = ts_option_vs_default('custom_background_positioning::attachment', 'fixed');

    $background_color  = ts_option_vs_default('background_color', '#fff');
    $content_background_color  = ts_option_vs_default('content_background_color', '#fff');
    
    if($content_background_color && ts_option_vs_default('layout', 1) != 1) 
    {
        $content_bg = $content_background_color;
        $content_bg_rgb = ts_hex2rgb($content_background_color, 'string');
    }
    else
    {
        $content_bg = $background_color;
        $content_bg_rgb = ts_hex2rgb($background_color, 'string');
    }
    ?>
    /* body background color */
    body,
    #ts-style-selector-wrap,
    #ts-style-selector-toggle { background-color: <?php echo $background_color;?>; }
    body.not-wall-to-wall #wrap,
    .woocommerce #payment, 
    .woocommerce-page #payment,
    .vertical-tabs ul.tab-header li.active:before { background-color: <?php echo $content_bg;?>; }
    
    <?php 
    if($use_custom_background_image && $custom_background_image) : 
    ?>
    body.has-custom-bg-image { 
        background: url(<?php echo esc_url($custom_background_image);?>) 
            <?php echo $custom_background_position.' '.$custom_background_repeat.' '.$custom_background_attachment;?> !important; 
    }
    <?php 
    endif; 
    ?>

    <?php
    $top_bar_bg_color = ts_option_vs_default('top_bar_bg_color', '#f5f5f5')
    ?>
    /* top bar */
    #top-small-bar { background-color: <?php echo $top_bar_bg_color;?>; }

    
    <?php
    $main_nav_submenu_bg_color = ts_option_vs_default('main_nav_submenu_bg_color', '#222')
    ?>
    /* main nav: sub-menu */
    .main-nav ul ul.children,
    .main-nav ul ul.sub-menu,
    .main-nav ul .main-nav-search-sub-menu,
    .main-nav ul .main-nav-shop-sub-menu { background-color: <?php echo $main_nav_submenu_bg_color;?>; }

    /* subtle background color */
    code.ts-inline-code,
    .pagination>a:hover, 
    .pagination>a:focus, 
    .pagination>a.active, 
    .pagination>span.active,
    .tagline-shortcode .tagline,
    #title-bar-wrap .breadcrumbs,
    form#commentform .form-allowed-tags code,
    .traditional-tabs.horizontal-tabs .tab-header li.active, 
    .traditional-tabs.vertical-tabs ul.tab-header li.active,
    .woocommerce table.shop_table thead, 
    .woocommerce-page table.shop_table thead,
    .woocommerce table.shop_table tfoot th, 
    .woocommerce-page table.shop_table tfoot th,
    .woocommerce #payment div.payment_box, 
    .woocommerce-page #payment div.payment_box,
    .woocommerce .widget_price_filter .ui-slider .ui-slider-handle, 
    .woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle { background-color: <?php echo $subtle_bg_color;?>; }
    
    <?php
    $masonry_cards_bg_color = ts_option_vs_default('masonry_cards_bg_color', '#fff')
    ?>
    /* masonry cards background */
    .masonry-cards .card-butt p,
    .masonry-cards .entry-content .entry-content-inner { background-color: <?php echo $masonry_cards_bg_color;?>; }
    
    <?php
    $footer_widget_bg_color = ts_option_vs_default('footer_widget_bg_color', '#f5f5f5');
    ?>
    /* footer background color */
    #footer-wrap { background-color: <?php echo $footer_widget_bg_color;?>; }




    /* TYPOGRAPHY COLORS (and other relevant items)
    ================================================== */
    
    <?php
    $body_font_color  = ts_option_vs_default('body_font_color', '#555');
    ?>
    /* body: plain text */
    body,
    .mobile-menu,
    code.ts-inline-code, 
    form#commentform .form-allowed-tags code,
    .woocommerce-info, 
    .woocommerce-error,
    .woocommerce-message,
    .woocommerce #payment div.payment_box, 
    .woocommerce-page #payment div.payment_box { color: <?php echo $body_font_color;?>; }
    
    /* mobile nav */
    .mobile-menu-icon { background-color: <?php echo $body_font_color;?>; }
    .mobile-menu-icon:before { border-color: <?php echo $body_font_color;?>; }
    
    <?php
    $heading_font_color  = ts_option_vs_default('heading_font_color', '#444');
    ?>
    /* body: h1-6 headings */
    h1, h2, h3, h4, h5, h6 { color: <?php echo $heading_font_color;?>; }
    
    <?php
    $logo_font_color = ts_option_vs_default('logo_font_color', '#212121');
    ?>
    /* alternate logo */
    #logo a { color: <?php echo $logo_font_color;?>; }
    
    <?php
    $title_bar_heading_color = ts_option_vs_default('title_bar_heading_color', '#212121');
    ?>
    /* title bar heading color */
    #title-bar h1,
    #title-bar h1 a { color: <?php echo $title_bar_heading_color;?>; }
    
    <?php
    $body_link_color  = ts_option_vs_default('body_link_color', '#212121');
    ?>
    /* body: link color */
    a, 
    a:hover,
    a:visited, 
    a:active,
    a:focus,
    button, 
    .tp-caption a,
    .tab-head.active,
    h1 a,
    h2 a, 
    h3 a, 
    h4 a,
    h5 a,
    h6 a,
    .post h1 a,
    .post h2 a, 
    .post h3 a, 
    .post h4 a,
    .post h5 a,
    .post h6 a,
    #sidebar h1 a,
    #sidebar h2 a, 
    #sidebar h3 a, 
    #sidebar h4 a,
    #sidebar h5 a,
    #sidebar h6 a,
    #page-share a,
    #ts-post-author a,
    .post .dem-tags.smaller a,
    .pagination a.active,
    #title-bar .to-comments-link,
    .ts-tabs-widget .tab-header li.active { color: <?php echo $body_link_color;?>; }
    .woocommerce .tabs-widget .quantity input[type="button"] { /*background-color: <?php echo $body_link_color;?>;*/ }

    <?php
    $subtle_text_color = ts_option_vs_default('subtle_text_color', '#999');
    ?>
    /* subtle text color */
    del,
    small,
    .small,
    .smaller,
    small a,
    .small a,
    .smaller a,
    .post small a,
    .post .small a,
    .post .smaller a,
    #sidebar small a,
    #sidebar .small a,
    #sidebar .smaller a,
    strike,
    #header-social,
    #header-social ul li a,
    .subtle-text-color,
    .title-bar-caption, 
    .loop .entry .title-info p,
    .widget_rss li .rssSummary,
    ol.commentlist .comment-head,
    .post-single-prev-next a strong,
    .widget_calendar table caption,
    .ts-tabs-widget .tab-header li,
    .ts-tabs-widget .tab-header li:before,
    .ts-searchform button,
    .widget_search button,
    .ts-searchform input[type="submit"],
    .widget_search input[type="submit"],
    #header-social .social .icon-style,
    .social-icons-widget-style .social .icon-style,
    .woocommerce p.stars span a, 
    .woocommerce-page p.stars span a,
    .woocommerce .shop_table .product-name dt { color: <?php echo $subtle_text_color;?>; }
    
    <?php
    $body_post_content_link_color = ts_option_vs_default('body_post_content_link_color', '#E8B71A');
    ?>
    /* primary color */
    .post a,
    #sidebar a,
    #comments .comment-message a { color: <?php echo $body_post_content_link_color;?>; }
    .woocommerce p.stars span a:hover, 
    .woocommerce-page p.stars span a:hover,
    .woocommerce p.stars span a.active, 
    .woocommerce-page p.stars span a.active { color: <?php echo $primary_color;?>; }
    .highlight { background-color: rgba(<?php echo $primary_color_rgb;?>, .1); color: <?php echo $primary_color;?>; }

    <?php
    $top_bar_font_color = ts_option_vs_default('top_bar_font_color', '#808080');
    $top_bar_link_color = ts_option_vs_default('top_bar_link_color', '#383838');
    $woo_price_color = ts_option_vs_default('woocommerce_price_color', '#7ac142');
    $footer_link_color = ts_option_vs_default('footer_widgets_link_color', '#E8B71A');
    $footer_link_color_rgb = (isset($footer_link_color)) ? ts_hex2rgb($footer_link_color, 'string') : '232, 183, 26';
    ?>
    /* top bar */
    #top-small-bar { color: <?php echo $top_bar_font_color;?>; }
    #top-small-bar a,
    #top-small-bar a:active,
    #top-small-bar a:focus,
    #top-small-bar a:hover { color: <?php echo $top_bar_link_color;?>; }
    

    <?php
    $main_nav_link_color = ts_option_vs_default('main_nav_link_color', '#808080');
    ?>
    /* main nav */
    .main-nav > ul > li > a, 
    .main-nav > div > ul > li > a { color: <?php echo $main_nav_link_color;?>; }
    .main-nav > ul > li.menu-item-has-children > a:after, 
    .main-nav > div > ul > li.menu-item-has-children > a:after { border-top-color: <?php echo $main_nav_link_color;?>; }
    <?php
    $main_nav_hover_color = ts_option_vs_default('main_nav_hover_color', '#383838');
    ?>
    .main-nav-wrap #header-social ul li:before,
    .main-nav-wrap #header-social ul li a:hover,
    .main-nav ul > li.menu-item > a:hover,
    .main-nav ul.sf-menu > li.menu-item:hover > a,
    .main-nav ul.megaMenu > li.menu-item:hover > a,
    .main-nav ul.ubermenu-nav > li.menu-item:hover > a,
    .main-nav > ul > li > a:hover, 
    .main-nav > div > ul > li > a:hover, 
    .main-nav > ul > li.current_page_item > a, 
    .main-nav > ul > li.current-menu-item > a,
    .main-nav > div > ul > li.current_page_item > a, 
    .main-nav > div > ul > li.current-menu-item > a,
    .main-nav > ul > li.inuse > a,
    .main-nav > div > ul > li.inuse > a,
    .main-nav > ul > li.current_page_parent > a,
    .main-nav > ul > li.current_page_ancestor > a,
    .main-nav > div > ul > li.current_page_parent > a,
    .main-nav > div > ul > li.current_page_ancestor > a,
    .main-nav > ul > li.current_page_parent > a > .sf-sub-indicator,
    .main-nav > div > ul > li.current_page_ancestor > a > .sf-sub-indicator { color: <?php echo $main_nav_hover_color;?>; }
    .main-nav > ul > li > a:hover:after, 
    .main-nav > div > ul > li > a:hover:after,
    .main-nav > ul > li.current_page_item > a:after, 
    .main-nav > ul > li.current-menu-item > a:after,
    .main-nav > div > ul > li.current_page_item > a:after, 
    .main-nav > div > ul > li.current-menu-item > a:after,
    .main-nav > ul > li.inuse > a:after,
    .main-nav > div > ul > li.inuse > a:after { border-top-color: <?php echo $main_nav_hover_color;?>; }

    <?php
    $main_nav_submenu_text_color = ts_option_vs_default('main_nav_submenu_text_color', '#aaa');
    $main_nav_submenu_link_color = ts_option_vs_default('main_nav_submenu_link_color', '#ccc');
    $main_nav_submenu_hover_color = ts_option_vs_default('main_nav_submenu_hover_color', '#fff');
    ?>
    /* main nav: sub-menu */
    .main-nav ul ul.children,
    .main-nav ul ul.sub-menu,
    .main-nav ul .main-nav-search-sub-menu,
    .main-nav ul .main-nav-shop-sub-menu { color: <?php echo $main_nav_submenu_text_color;?>; }
    .main-nav ul ul.children a,
    .main-nav ul ul.sub-menu a,
    .main-nav ul .main-nav-search-sub-menu a,
    .main-nav ul .main-nav-shop-sub-menu a { color: <?php echo $main_nav_submenu_link_color;?>; }    
    .main-nav ul ul li.menu-item-has-children > a:after { border-color: transparent transparent transparent <?php echo $main_nav_submenu_link_color;?>; }
    .main-nav ul ul li.menu-item > a:hover,
    .main-nav ul ul li.current_page_item > a, 
    .main-nav ul ul li.current-menu-item > a { color: <?php echo $main_nav_submenu_hover_color;?>; }
    .main-nav ul ul li.menu-item-has-children > a:hover:after { border-color: transparent transparent transparent <?php echo $main_nav_submenu_hover_color;?>; }

    <?php
    $footer_widget_font_color = ts_option_vs_default('footer_widget_font_color', '#808080');
    $footer_widget_headings_color = ts_option_vs_default('footer_widget_headings_color', '#808080');
    $footer_widgets_link_color = ts_option_vs_default('footer_widgets_link_color', '#383838');
    ?>
    /* footer colors */
    #footer { color: <?php echo $footer_widget_font_color;?>; }
    #footer a,
    #footer a:active,
    #footer a:focus,
    #footer a:hover,
    #footer .ts-tabs-widget .tab-header li.active { color: <?php echo $footer_widgets_link_color;?>; }
    #footer h1,
    #footer h2,
    #footer h3,
    #footer h4,
    #footer h5,
    #footer h6,
    #footer .ts-tabs-widget .tab-header li { color: <?php echo $footer_widget_headings_color;?>; }

    <?php
    $woocommerce_price_color = ts_option_vs_default('woocommerce_price_color', '#7ac142');
    ?>
    /* woocommerce price */
    .woocommerce .price, 
    .woocommerce-page .price,
    .woocommerce div.product span.price, 
    .woocommerce-page div.product span.price, 
    .woocommerce #content div.product span.price, 
    .woocommerce-page #content div.product span.price, 
    .woocommerce div.product p.price, 
    .woocommerce-page div.product p.price, 
    .woocommerce #content div.product p.price, 
    .woocommerce-page #content div.product p.price,
    .woocommerce ul.products li.product .price, 
    .woocommerce-page ul.products li.product .price,
    .product.woocommerce span.amount,
    .woocommerce div.product .stock, 
    .woocommerce-page div.product .stock, 
    .woocommerce #content div.product .stock, 
    .woocommerce-page #content div.product .stock { color: <?php echo $woocommerce_price_color;?>; }


    /* BORDERS / BORDER COLORS (and other relevant items)
    ================================================== */

    /* primary color */
    .ts-pricing-column.featured,
    button.outline,
    .button.outline,
    #button.outline { border-color: <?php echo $primary_color;?>; }
    .loop-slider-wrap .ts-item-details .comment-bubble:after { border-top-color: <?php echo $primary_color;?>; }
    
    <?php
    $top_bar_border_color = ts_option_vs_default('top_bar_border_color', '#eee', true);
    ?>
    /* top bar */
    #top-small-bar { border-color: <?php echo $top_bar_border_color;?>; }

    /* standard border color */

    @media only screen and (max-width: 900px) {
        .main-nav,
        .main-nav > ul > li,
        .main-nav > div > ul > li,
        .main-nav ul ul.sub-menu { border-color: <?php echo $standard_border_color;?>; }
    }
    
    .ts-progress-bar-wrap ,
    body.single-post #ts-post-wrap .dem-tags .sep { background-color: <?php echo $standard_border_color;?>; }
    
    #ts-style-selector-toggle,
    #ts-style-selector-wrap,
    #ts-style-selector-wrap h3,
    
    hr,
    abbr,
    acronym,
    
    .ts-top,
    #header-social .social .icon-style,
    .social-icons-widget-style .social .icon-style,
    #bottom-ad-inner,
    #ts-comments-wrap-wrap,
    #megaMenu #megaMenuToggle,
    .ubermenu .ubermenu-toggle,
    body.has-no-footer-widgets #copyright-nav,
    #copyright-nav ul li,
    .mobile-nav,
    .mobile-menu-sep,
    .top-default .main-nav,
    
    #title-bar,
    #title-bar-wrap .breadcrumbs,
    #main-slider-wrap,
    
    body.page #ts-page-featured-media-wrap .featured-media-wrap,
    body.single-post #ts-post-featured-media-wrap .featured-media-wrap,
    body.single-post #main.has-sidebar-right #ts-post-featured-media-wrap .featured-media-wrap,
    body.single-post #main.has-sidebar-left #ts-post-featured-media-wrap .featured-media-wrap,
    body.single-post #ts-post-the-content .ts-gallery-wrapper,

    #page-share.pull-right,
    #page-share.pull-left,
    .search-result-caption,

    .loop .entry .read-more-wrap,
    .loop-default .featured-media-wrap,
    .loop-widget .entry,

    .post-single-prev-next,

    .pagination a,
    .pagination span,
    .masonry-cards .entry-content .read-more,

    .wp-caption,
    .page-links span.wp-link-pages > span,
    .gallery .gallery-item .gallery-icon img,
    #main .single-entry .ts-about-author,
    .ts-related-posts-on-single,
    .traditional-tabs.horizontal-tabs .tab-header li.active,
    #sidebar .widget li,
    .wpmega-widgetarea .widget li,
    .ubermenu-widget-area .widget li,
    .widget .tagcloud a, 
    .post-tags a,
    .widget .tab-header,
    .widget_calendar table td, 
    .widget_calendar table th,
    .widget .blog-author .avatar-wrap,
    .flickr-widget li a,
    .post-widget .widget-thumbnail .thumb-link,
    .widget .tab-header,
    .divider-shortcode.line .divider,
    .divider-shortcode.dotted .divider,
    .divider-shortcode.dashed .divider,
    .divider-shortcode.double-line .divider,
    .divider-shortcode.double-dotted .divider,
    .divider-shortcode.double-dashed .divider,
    .divider-shortcode .divider-sep,
    .divider-shortcode .shapes .ts-circle,
    .divider-shortcode .shapes .ts-square,
    .title-shortcode .title-sep,
    .title-shortcode.dashed .title-sep,
    .title-shortcode.dotted .title-sep,
    .title-shortcode.double-line .title-sep,
    .title-shortcode.double-dashed .title-sep,
    .title-shortcode.double-dotted .title-sep,

    .vertical-tabs ul.tab-header li,
    .vertical-tabs ul.tab-header li:first-child,
    .traditional-tabs.vertical-tabs .tab-contents,
    .traditional-tabs.vertical-tabs ul.tab-header li,
    .simple-tabs.vertical-tabs-left .tab-contents,
    .simple-tabs.vertical-tabs-right .tab-contents,

    .toggle-block,
    .accordion-block
    .toggle-block .tab-body,
    .accordion-block .tab-body,
    .toggles-wrapper .accordion-block,
    .accordion-wrapper .accordion-block,
    .tagline-shortcode,
    .tagline-shortcode .tagline,
    .ts-pricing-column,
    .ts-pricing-column ul li,

    .ts-blockquote-shortcode.pull-left,
    .ts-blockquote-shortcode.pull-right,

    .ts-loop-product-title,
    .woocommerce-page div.product #reviews .comment img,
    .woocommerce #content div.product #reviews .comment, 
    .woocommerce div.product #reviews .comment, 
    .woocommerce-page #content div.product #reviews .comment, 
    .woocommerce-page div.product #reviews .comment,
    .woocommerce-info,
    .woocommerce-message { border-color: <?php echo $standard_border_color;?> }
    
    <?php
    $footer_widget_border_color = ts_option_vs_default('footer_widget_border_color', '#eee');
    ?>
    /* footer widget border color */
    #footer .widget * { border-color: <?php echo $footer_widget_border_color;?>; }
    
    <?php
    $footer_border_color = ts_option_vs_default('footer_border_color', '#eee');
    ?>
    /* footer wrap border color */
    #footer-wrap { border-color: <?php echo $footer_border_color;?>; }




    /* FORM ELEMENT COLORS 
    ================================================== */
    
    <?php
    $form_font_color = ts_option_vs_default('form_font_color', '#808080');
    $form_background_color = ts_option_vs_default('form_background_color', '#f9f9f9');
    $form_focus_background_color = ts_option_vs_default('form_focus_background_color', '#fff');
    $form_border_color = ts_option_vs_default('form_border_color', '#ddd');
    ?>
    .woocommerce .select2-container .select2-choice,
    .woocommerce-page .select2-drop-active,
    input.input-text, 
    input[type="text"], 
    input[type="search"], 
    input[type="email"], 
    input[type="password"],
    input[type="number"],
    input[type="tel"], 
    input[type="url"], 
    textarea, 
    select { 
        background-color: <?php echo $form_background_color;?>;
        border-color: <?php echo $form_border_color;?>;
        color: <?php echo $form_font_color;?>;
    }
    .ts-searchform button { color: <?php echo $form_font_color;?> !important; }
    .woocommerce .select2-container .select2-choice:focus,
    .woocommerce-page .select2-drop-active,
    .woocommerce .select2-drop-active,
    input.input-text:focus, 
    input[type="text"]:focus, 
    input[type="search"]:focus, 
    input[type="email"]:focus, 
    input[type="password"]:focus,
    input[type="number"]:focus,
    input[type="tel"]:focus, 
    input[type="url"]:focus, 
    textarea:focus, 
    select:focus { background-color: <?php echo $form_focus_background_color;?>; }

    <?php
    $main_nav_submenu_text_color = ts_option_vs_default('main_nav_submenu_text_color', '#aaa');
    $main_nav_submenu_subtle_bg_color = ts_option_vs_default('main_nav_submenu_subtle_bg_color', '#282828');
    $main_nav_submenu_border_color = ts_option_vs_default('main_nav_submenu_border_color', '#333');
    ?>
    #main-nav ul ul input[type="text"], 
    #main-nav ul ul input[type="search"], 
    #main-nav ul ul input[type="email"], 
    #main-nav ul ul input[type="password"],
    #main-nav ul ul input[type="number"],
    #main-nav ul ul input[type="tel"], 
    #main-nav ul ul input[type="url"], 
    #main-nav ul ul textarea, 
    #main-nav ul ul select { 
        background-color: <?php echo $main_nav_submenu_subtle_bg_color;?>;
        border-color: <?php echo $main_nav_submenu_border_color;?>;
        color: <?php echo $main_nav_submenu_text_color;?>;
    }
    #main-nav ul ul .ts-searchform button { color: <?php echo $main_nav_submenu_text_color;?> !important; }
    #main-nav ul ul input[type="text"]:focus, 
    #main-nav ul ul input[type="search"]:focus, 
    #main-nav ul ul input[type="email"]:focus, 
    #main-nav ul ul input[type="password"]:focus,
    #main-nac ul ul input[type="number"]:focus,
    #main-nav ul ul input[type="tel"]:focus, 
    #main-nav ul ul input[type="url"]:focus, 
    #main-nav ul ul textarea:focus, 
    #main-nav ul ul select:focus { background-color: <?php echo $main_nav_submenu_subtle_bg_color;?>; }

    <?php
    $footer_form_font_color = ts_option_vs_default('footer_form_font_color', '#555');
    $footer_form_background_color = ts_option_vs_default('footer_form_background_color', '#fff');
    $footer_form_border_color = ts_option_vs_default('main_nav_submenu_border_color', '#ddd');
    ?>
    #footer input[type="text"], 
    #footer input[type="search"], 
    #footer input[type="email"], 
    #footer input[type="password"],
    #footer input[type="number"],
    #footer input[type="tel"], 
    #footer input[type="url"], 
    #footer textarea, 
    #footer select { 
        background-color: <?php echo $footer_form_background_color;?>;
        border-color: <?php echo $footer_form_border_color;?>;
        color: <?php echo $footer_form_font_color;?>;
    }
    #footer .ts-searchform button { color: <?php echo $footer_form_font_color;?> !important; }
    #footer input[type="text"]:focus, 
    #footer input[type="search"]:focus, 
    #footer input[type="email"]:focus, 
    #footer input[type="password"]:focus,
    #footer input[type="number"]:focus,
    #footer input[type="tel"]:focus, 
    #footer input[type="url"]:focus, 
    #footer textarea:focus, 
    #footer select:focus { background-color: <?php echo $footer_form_background_color;?>; }
    
    
    /*======================================================================== 
                                #STANDARD COLORS
                                - borders
                                - backgrounds
                                - text
                                - buttons
    =========================================================================*/
    .border-standard { border-color: <?php echo $standard_border_color;?> !important; }
    .border-primary { border-color: <?php echo $primary_color;?> !important; }

    /* Begin Background Colors */
    .bg-primary { background-color: <?php echo $primary_color;?> !important; }

    /* Begin Text Colors */
    .primary-color, 
    .color-shortcode.primary,
    .color-primary { color: <?php echo $primary_color;?> !important; }

    /* Begin Button Colors */
    .button.default,
    .button.primary {
        background-color: <?php echo $primary_color;?> !important;
    }

<?php
    }
}