<?php
/**
 * The search template file.
 */
global $smof_data;

$ts_search_term = (isset($_GET['s'])) ? ts_trim_text($_GET['s'], 20) : __('undefined', 'ThemeStockyard');
$ts_page_title = __('Search results...', 'ThemeStockyard');

$ts_page_id        = get_option('page_for_posts');

$ts_show_sidebar_option = (ts_option_vs_default('show_page_sidebar', 1) != 1) ? 'no' : 'yes';
$ts_show_sidebar = ts_postmeta_vs_default($ts_page_id, '_page_sidebar', $ts_show_sidebar_option);

$ts_sidebar_position_option = ts_option_vs_default('page_sidebar_position', 'right');
$ts_sidebar_position = ts_postmeta_vs_default($ts_page_id, '_page_sidebar_position', $ts_sidebar_position_option);

$ts_caption = '&nbsp;';
get_header(); 
get_template_part('top');
get_template_part('title-bar');
?>
            <div id="main-container-wrap">
                <div id="main-container" class="container clearfix">                
                    <div id="main" class="clearfix <?php echo ($ts_show_sidebar == 'yes') ? 'has-sidebar' : 'no-sidebar';?>">
                        <div class="search-result-caption">
                            <p><?php _e('Showing search results for:', 'ThemeStockyard');?> <span class="ts-highlight highlight"><?php echo esc_attr($_GET['s']);?></span></p>
                        </div>
                        <?php
                        /* 
                         * Run the loop to output the posts.
                         */
                        if(get_query_var('post_type') == 'portfolio') :
                            $ts_loop = (isset($smof_data['portfolio_layout'])) ? $smof_data['portfolio_layout'] : '';
                            ts_portfolio($ts_loop, array('default_query'=>true,'is_search'=>true));
                        else :
                            $ts_loop = (isset($smof_data['search_layout'])) ? $smof_data['search_layout'] : '';
                            ts_blog($ts_loop, array('default_query'=>true,'is_search'=>true));
                        endif;
                        ?>
                        
                    </div>

<?php ts_get_sidebar(); ?>

                </div><!-- #main-container -->
            </div><!-- #main-container-wrap -->
            
<?php get_footer(); ?>
