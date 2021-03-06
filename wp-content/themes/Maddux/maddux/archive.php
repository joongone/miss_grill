<?php
global $smof_data, $ts_page_id, $ts_page_title;

$ts_page_id        = get_option('page_for_posts');

$ts_show_sidebar_option = (ts_option_vs_default('show_page_sidebar', 1) != 1) ? 'no' : 'yes';
$ts_show_sidebar = ts_postmeta_vs_default($ts_page_id, '_page_sidebar', $ts_show_sidebar_option);

$ts_show_top_ticker_option = (ts_option_vs_default('show_page_top_ticker', 0) == 1) ? 'yes' : 'no';
$ts_show_top_ticker = ts_postmeta_vs_default($ts_page_id, '_page_top_ticker', $ts_show_top_ticker_option);

$ts_sidebar_position_option = ts_option_vs_default('page_sidebar_position', 'right');
$ts_sidebar_position = ts_postmeta_vs_default($ts_page_id, '_page_sidebar_position', $ts_sidebar_position_option);

$post = $posts[0];
$ts_queried_object = get_query_var('author');

if (is_category()) { 
    $ts_page_title = single_cat_title('', false);
    $ts_caption = strip_tags(category_description());
} elseif( is_tag() ) {
    $ts_page_title = __('Posts Tagged', 'ThemeStockyard').' &#8216;'.single_tag_title('', false).'&#8217;';
} elseif (is_day()) { 
    $ts_page_title = __('Archive for:', 'ThemeStockyard').' '.get_the_time('F jS, Y');
} elseif (is_month()) { 
    $ts_page_title = __('Archive for:', 'ThemeStockyard').' '.get_the_time('F, Y');
} elseif (is_year()) {
    $ts_page_title = __('Archive for:', 'ThemeStockyard').' '.get_the_time('Y');
} elseif (is_author()) { 
    $ts_page_title = __('Posts by:', 'ThemeStockyard').' '.get_the_author_meta('display_name', get_query_var('author'));
} elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
    $ts_page_title = __('Archives', 'ThemeStockyard');
} elseif(is_tax()) {
    $ts_page_title = get_the_archive_title();
    $ts_caption = get_the_archive_description();
}
$ts_caption = (trim($ts_caption)) ? $ts_caption : '';
get_header(); 
get_template_part('top');
get_template_part('title-bar');
?>
            <div id="main-container-wrap" class="<?php echo esc_attr(ts_main_container_wrap_class('page'));?>">
                <div id="main-container" class="container clearfix" data-wut="archive">
                    <div id="main" class="clearfix <?php echo ($ts_show_sidebar == 'yes') ? 'has-sidebar' : 'no-sidebar';?>">
                        <div class="entry single-entry clearfix">
                            <div class="post">
                                <?php
                                /* 
                                 * Run the loop to output the posts.
                                 */
                                $ts_loop = (isset($smof_data['archive_layout'])) ? $smof_data['archive_layout'] : '';
                                ts_blog($ts_loop, array('default_query' => true));
                                wp_reset_query();
                                ?>
                            </div>
                        </div>
                    </div>

    <?php ts_get_sidebar(); ?>

                </div><!-- #main-container -->
            </div><!-- #main-container-wrap -->
            
<?php get_footer(); ?>