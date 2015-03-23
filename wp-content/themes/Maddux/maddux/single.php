<?php
global $smof_data, $ts_page_id, $ts_comments_top_padding, $ts_within_blog_loop, $ts_sidebar_position, $ts_show_sidebar, $ts_show_top_ticker;
global $ts_previous_posts;

$ts_page_object = get_queried_object();
$ts_page_id     = (is_single()) ? $post->ID : get_queried_object_id();
$ts_custom_css  = get_post_meta($ts_page_id, '_p_css', true);

$ts_previous_posts[] = $ts_page_id;

$ts_sharing_options = ts_sharing_options_on_posts();
$ts_show_top_ticker_option = (ts_option_vs_default('show_post_top_ticker', 0) == 1) ? 'yes' : 'no';
$ts_show_top_ticker = ts_postmeta_vs_default($ts_page_id, '_post_top_ticker', $ts_show_top_ticker_option);
$ts_show_sidebar_option = (ts_option_vs_default('show_post_sidebar', 1) != 1) ? 'no' : 'yes';
$ts_show_sidebar = ts_postmeta_vs_default($post->ID, '_p_sidebar', $ts_show_sidebar_option);
$ts_sidebar_position_option = ts_option_vs_default('post_sidebar_position', 'right');
$ts_sidebar_position = ts_postmeta_vs_default($post->ID, '_p_sidebar_position', $ts_sidebar_position_option);
$ts_direction_links_option = ts_option_vs_default('post_show_direction_links', 'yes');
$ts_direction_links = ts_postmeta_vs_default($post->ID, '_p_show_direction_links', $ts_direction_links_option);
$crop_images_option = (ts_option_vs_default('crop_images_on_post', 1)) ? 'yes' : 'no';
$crop_images = ts_postmeta_vs_default($post->ID, '_p_crop_images', $crop_images_option);

if($ts_show_sidebar == 'yes' && (in_array($ts_sidebar_position, array('left','right')))) :
    if(in_array($crop_images, array('1','yes','true'))) :
        $crop_width = ts_option_vs_default('cropped_featured_image_width', 720, true);
        $crop_height = ts_option_vs_default('cropped_featured_image_height', 405, true);
    else :
        $crop_width = ts_option_vs_default('cropped_featured_image_width', 720, true);
        $crop_height = 0;
    endif;
else : 
    if(in_array($crop_images, array('1','yes','true'))) :
        $crop_width = ts_option_vs_default('cropped_featured_image_width_full', 1040, true);
        $crop_height = ts_option_vs_default('cropped_featured_image_height_full', 585, true);
    else :
        $crop_width = ts_option_vs_default('cropped_featured_image_width_full', 1040, true);
        $crop_height = 0;
    endif;
endif;

get_header(); 
get_template_part('top');
get_template_part('title-bar');
?>   
            <div id="main-container-wrap" class="<?php echo esc_attr(ts_main_container_wrap_class());?>">                     
            <?php                                       
            if (have_posts()) : 
                while (have_posts()) : the_post(); 
            ?>
                <div id="main-container" class="container clearfix">
                    <div id="main" class="<?php echo esc_attr(ts_main_div_class());?> clearfix">
                        <div class="entry single-entry clearfix">
                            <?php
                            if(ts_option_vs_default('show_images_on_post', 1) == 1) :
                                $featured_media_vars = array('media_width'=>$crop_width,'media_height'=>$crop_height,'allow_audio'=>1,'allow_self_hosted_video'=>1);
                                $featured_media = ts_get_featured_media($featured_media_vars);
                                echo '<div id="ts-post-featured-media-wrap">'.$featured_media.'</div>';
                            endif;
                            ?>
                            
                            <div id="ts-post-content-sidebar-wrap" class="clearfix">
                                <div id="ts-post-wrap">
                                    
                                    <div id="ts-post" <?php post_class('post clearfix'); ?>>
                                        
                                        <?php
                                        if($ts_sharing_options->show) :
                                        ?>            
                                        <div id="page-share" class="<?php echo esc_attr($ts_sharing_options->position_class);?> small">
                                            <?php echo ts_social_sharing(true); ?>
                                        </div>
                                        <?php
                                        endif;
                                        ?>
                                        
                                        <div id="ts-post-the-content-wrap">
                                    
                                            <div id="ts-post-author">
                                                <p class="smaller uppercase"><?php
                                                if(ts_option_vs_default('show_author_avatar', 0) == 1) :
                                                    echo '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'" class="author-avatar">';
                                                    echo get_avatar(get_the_author_meta('user_email'), 24);
                                                    echo '</a>';
                                                endif;
                                                
                                                echo __('By', 'ThemeStockyard').' ';
                                                
                                                the_author_posts_link();
                                                ?></p>
                                            </div>
                                            
                                            <div id="ts-post-the-content">
                                                <?php
                                                the_content();
                                                
                                                wp_link_pages('before=<div class="page-links">'.__('Pages: ', 'ThemeStockyard').'<span class="wp-link-pages">&after=</span></div>&link_before=<span>&link_after=</span>'); 
                                                ?>
                                                <?php 
                                                $tags_intro = '<span class="tags-label">'.__('Tags:','ThemeStockyard').' </span>';
                                                $tags_sep = '&bull;';
                                                if(has_tag()) :
                                                ?>
                                                <div class="dem-tags uppercase smaller"><?php the_tags($tags_intro, $tags_sep, '');?></div>
                                                <?php
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <?php
                                    if($ts_direction_links == 'yes') ts_post_direction_nav();
                                    ?>
                                    
                                    <!-- Author -->
                                    <?//php if(ts_option_vs_default('author_info_on_post', 1) == 1) : ?>
                                    <!--
                                    <div class="ts-about-author clearfix">
                                        <div class="avatar-img">
                                            <a href="<?//php echo get_author_posts_url(get_the_author_meta('ID'));?>"><?php echo get_avatar(get_the_author_meta('email'), '80'); ?></a>
                                        </div>
                                        <div class="content">
                                            <h6 class="smaller"><?//php echo __('About the Author', 'ThemeStockyard'); ?></h6>
                                            <h4><?php the_author_posts_link(); ?></h4>
                                            <?php 
                                            //echo wpautop(do_shortcode(get_the_author_meta('description'))); 
                                            ?>
                                        </div>
                                    </div>
                                    -->
                                    <?//php endif; ?>
                                    
                                    <!-- Relate Posts -->
                                    <?php 
                                    $show_related_option = (ts_option_vs_default('show_related_blog_posts', 1) == 1) ? 'yes' : 'no';
                                    $show_related = ts_postmeta_vs_default($post->ID, '_p_related_posts', $show_related_option);
                                    if($show_related == '1' || $show_related == 'yes') : 
                                        $ts_related_portfolio_posts_title_text = ts_option_vs_default('related_blog_posts_title_text', 'Related Posts');
                                        $ts_related_portfolio_posts_title_align = ts_option_vs_default('related_blog_posts_title_alignment', 'left');
                                    ?>
                                    <div class="ts-related-posts-on-single">
                                        <h5 class="smaller uppercase <?php echo esc_attr('text-'.$ts_related_portfolio_posts_title_align);?>"><?php echo $ts_related_portfolio_posts_title_text;?></h4>
                                        <?php 
                                        $args = array('include'=>'related','limit'=>3,'show_pagination'=>'no','media_width'=>480,'media_height'=>270, 'title_size'=>4);
                                        echo ts_blog('3columns', $args);
                                        ?>
                                    </div>
                                    <?php endif;?>
                                    
                                    <!-- Comment -->
                                    <!--
                                    <div id="ts-comments-wrap-wrap" class="clearfix">
                                        <?php
                                        /*
                                        if(get_comments_number() < 1) :
                                            echo '<div id="comments">';
                                            echo do_shortcode('[divider height="0"]');
                                            echo '</div>';
                                        endif;
                                        */
                                        ?>
                                        <div id="ts-comments-wrap">
                                            <?//php comments_template(); ?>
                                        </div>
                                        <?//php ts_get_comments_sidebar(); ?>
                                    </div>
                                    -->
                                </div>
                                <?php ts_get_content_sidebar(); ?>
                            </div>
                            
                        </div>
                    </div>

<?php ts_get_sidebar(); ?>

                </div><!-- #main-container -->
                        
            <?php                        
                endwhile; 
            else :
            ?>
                <div id="main-container" class="container clearfix">
                    <div id="main" class="<?php echo ($ts_show_sidebar == 'yes') ? '' : 'fullwidth';?> clearfix">
                        <div class="entry single-entry clearfix">
                            <div class="post"><p><?php _e('Sorry, the post you are looking for does not exist.', 'ThemeStockyard');?></p></div>
                        </div>
                    </div>
                </div>
            <?php
            endif;
            ?>
            </div><!-- #main-container-wrap -->
            
<?php get_footer(); ?>
