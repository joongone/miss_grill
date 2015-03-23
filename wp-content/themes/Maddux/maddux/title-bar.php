<?php
global $ts_page_title, $ts_show_title_bar_override, $ts_caption, $ts_page_id, $smof_data, $post;

$ts_show_title_bar_default = (ts_option_vs_default('show_titlebar', 1) != 1) ? 'no' : 'yes';

if(is_single()) :
    $ts_show_title_bar_on_posts = (ts_option_vs_default('show_titlebar_on_posts', 1) != 1) ? 'no' : $ts_show_title_bar_default;
    $ts_show_title_bar = ts_postmeta_vs_default($ts_page_id, '_p_titlebar', $ts_show_title_bar_on_posts);
    $ts_show_breadcrumbs = (ts_option_vs_default('show_breadcrumbs_on_posts', 0) == 1) ? 'yes' : 'no';
    $ts_show_breadcrumbs = ts_postmeta_vs_default($ts_page_id, '_p_show_breadcrumbs', $ts_show_breadcrumbs);
else :
    $ts_show_title_bar_on_pages = (ts_option_vs_default('show_titlebar_on_pages', 1) != 1) ? 'no' : $ts_show_title_bar_default;
    $ts_show_title_bar = ts_postmeta_vs_default($ts_page_id, '_page_titlebar', $ts_show_title_bar_on_pages);
    $ts_show_breadcrumbs = (ts_option_vs_default('show_breadcrumbs_on_pages', 1) != 1) ? 'no' : 'yes';
    $ts_show_breadcrumbs = ts_postmeta_vs_default($ts_page_id, '_page_show_breadcrumbs', $ts_show_breadcrumbs);
endif;

$_ts_caption = '';
if(is_single() || is_page()) :
    $_ts_caption = (is_single()) ? get_post_meta($ts_page_id, '_p_titlebar_caption', true) : get_post_meta($ts_page_id, '_page_titlebar_caption', true);
endif;
$ts_caption = (trim($_ts_caption)) ? $_ts_caption : $ts_caption;

if($ts_show_title_bar == 'yes' || $ts_show_title_bar == 1 || $ts_show_title_bar_override == 'yes' || $ts_show_breadcrumbs) :
?>
            <div id="title-bar-wrap" class="container title-bar-layout-<?php echo esc_attr(ts_option_vs_default('titlebar_layout','normal'));?>">
                <?php
                if(in_array($ts_show_breadcrumbs, array('1','true','yes'))) :
                    $has_yoast_breadcrumbs = false;
                    if(function_exists('yoast_breadcrumb')) :
                        $yoast_breadcrumbs = yoast_breadcrumb('<div class="breadcrumbs small" data-breadcrumbs-by="yoast">', '</div>', false);
                
                        $has_yoast_breadcrumbs = (trim($yoast_breadcrumbs)) ? true : false;
                    endif;
                    
                    if(!$has_yoast_breadcrumbs) :
                        dimox_breadcrumbs();
                    endif;
                endif;
                ?>
                
                <?php
                if($ts_show_title_bar == 'yes' || $ts_show_title_bar == '1' || $ts_show_title_bar_override == 'yes') :
                ?>
                <div id="title-bar">                    
                    <div id="title-bar-text" class="container">
                        <?php
                        if(is_single()) :
                            $posttype = get_post_type($ts_page_id);
                            if($posttype == 'portfolio') :
                        ?>
                        <h1><?php
                                echo '<a href="'.get_permalink().'">';
                                echo (trim($ts_page_title)) ? esc_attr($ts_page_title) : get_the_title();
                                echo '</a>';
                        ?></h1>
                        <?php echo (trim($ts_caption)) ? '<p class="title-bar-caption">'.$ts_caption.'</p>' : ''; ?>
                        <div class="meta small"><?php echo ts_get_the_category('portfolio-category','text');?></div>
                        <?php
                            else :
                        ?>
                        <h1><?php 
                                if(function_exists('is_woocommerce') && is_woocommerce()) :
                                    $shop_page = get_post(woocommerce_get_page_id('shop'));
                                    echo '<a href="'.get_permalink($shop_page->ID).'">';
                                    echo $shop_page->post_title;
                                    echo '</a>';
                                else :
                                    echo '<a href="'.get_permalink().'">';
                                    echo (trim($ts_page_title)) ? esc_attr($ts_page_title) : get_the_title();
                                    echo '</a>';
                                endif;
                        ?></h1>
                        <?php echo (trim($ts_caption)) ? '<p class="title-bar-caption">'.$ts_caption.'</p>' : ''; ?>

                        <!-- title 하단 메뉴 hidden -->
                        <!--
                        <div class="meta small"><?php 
                        /*
                            if(function_exists('is_woocommerce') && is_woocommerce()) : 
                                global $product;
                                echo '&#8220;'.get_the_title().'&#8221;';
                                
                                $show_shop_prices_on_single = ts_option_vs_default('show_shop_prices_on_single', 1);
                                if($show_shop_prices_on_single == 1) :
                                    $sale  = get_post_meta( get_the_ID(), '_sale_price', true);
                                    $price = get_post_meta( get_the_ID(), '_regular_price', true);
                                    $price = (trim($sale)) ? $sale : $price;
                                    echo (preg_replace("/[^0-9]/", "", $price) > 0) ? ' &nbsp;&bull;&nbsp; '.woocommerce_price( $price ) : '';
                                endif;
                            else :
                                echo the_category();
                                echo get_the_date() .' '. __('at', 'ThemeStockyard') .' '. get_the_time();
                            endif; 
                            
                            if(comments_open()) :
                                $comment_number = get_comments_number();
                                if(function_exists('is_woocommerce') && is_woocommerce()) :
                                    $show_shop_reviews_on_single = ts_option_vs_default('show_shop_reviews_on_single', 1);
                                    if($show_shop_reviews_on_single == 1) :
                                        echo ' &nbsp;&bull;&nbsp; ';
                                        echo '<a href="'.get_permalink().'#reviews" class="to-comments-link reviews-smoothscroll">'.$comment_number.' ';
                                        echo ($comment_number == 1) ? __('Review', 'ThemeStockyard') : __('Reviews', 'ThemeStockyard');
                                        echo '</a>'."\n";
                                    endif;
                                else :
                                    echo ' &nbsp;&bull;&nbsp; ';
                                    echo '<a href="'.esc_url(get_permalink().ts_link2comments()).'" class="to-comments-link smoothscroll">';
                                    echo '<i class="fa fa-comments"></i>'.$comment_number.' ';
                                    echo ($comment_number == 1) ? __('Comment', 'ThemeStockyard') : __('Comments', 'ThemeStockyard');
                                    echo '</a>'."\n";
                                    if(ts_option_vs_default('show_titlebar_post_view_count', 0) == 1) :
                                        $ts_postview_nonce = wp_create_nonce('ts_update_postviews_nonce');
                                        $post_view_count = ts_postmeta_vs_default($ts_page_id, '_p_ts_postviews', 0);
                                        $post_view_count = (!$post_view_count) ? '0' : $post_view_count;
                                        $post_view_count_text = sprintf(_n( '1 view', '%s views', $post_view_count, 'ThemeStockyard'), $post_view_count);
                                        echo ' &nbsp;&bull;&nbsp; ';
                                        echo '<span id="ts-postviews" data-pid="'.esc_attr($ts_page_id).'" data-nonce="'.esc_attr($ts_postview_nonce).'">';
                                        echo '<i class="fa fa-eye"></i>'.$post_view_count_text;
                                        echo '</span>';
                                    endif;
                                endif;
                            else :
                                echo '<!-- comments closed -->'."\n";
                            endif;
                            */
                            ?></div>
                        -->
                        <?php
                            endif;
                        else :
                        ?>
                        <h1><?php 
                            if(function_exists('is_woocommerce') && is_woocommerce()) :
                                $shop_page = get_post(woocommerce_get_page_id('shop'));
                                echo $shop_page->post_title;
                                if ( is_tax( 'product_cat' ) || is_tax( 'product_tag' ) ) :
                                    $term = get_queried_object();
                                    echo (is_object($term) && isset($term->name)) ? ' &rsaquo; '.$term->name : '';
                                endif;
                            else :
                                echo (trim($ts_page_title)) ? esc_attr($ts_page_title) : get_the_title();
                            endif;
                        ?></h1>
                        <?php
                            echo (trim($ts_caption)) ? '<p class="title-bar-caption">'.$ts_caption.'</p>' : '';
                        endif;
                        ?>
                    </div>
                </div>
                <?php
                endif;
                ?>
                
            </div>
<?php
endif;
?>