<?php
$ts_query = (isset($atts) && ($atts['default_query'] === false)) ? new WP_Query($atts) : $wp_query;
$atts = (isset($atts)) ? $atts : array();

$widget_layout = (isset($atts['widget_layout']) && in_array($atts['widget_layout'], array('vertical','horizontal'))) ? $atts['widget_layout'] : '';
if($widget_layout == 'horizontal') :
    $media_class = 'span4';
else : 
    $media_class = 'span12';
endif;

/* widget heading */
$widget_heading = (isset($atts['widget_heading'])) ? $atts['widget_heading'] : '';
$widget_heading_size = (isset($atts['widget_heading_size'])) ? $atts['widget_heading_size'] : '';
$widget_heading_size = ts_figure_h_size($widget_heading_size, 5);

if(isset($atts['override_widget_heading']) && ts_attr_is_true($atts['override_widget_heading'])) :
    $cat_name = (isset($atts['category_name']) && trim($atts['category_name'])) ? $atts['category_name'] : '';
    $cat_names = explode(',', $cat_name);
    if(count($cat_names) == 1) :
        $cat = get_category_by_slug($cat_name);
        if($cat !== false) :
            $widget_heading = '<a href="'.get_category_link( $cat->term_id ).'">'.$cat->name.'<i class="fa fa-angle-right"></i></a>';
        endif;
    endif;
endif;

$text_align = ts_get_blog_loop_text_align($atts);
?>
                
                <div class="loop-widget-wrap loop-widget-simple-wrap">
                    <?php
                    if(trim($widget_heading)) :
                    ?>
                    <h5 class="<?php echo esc_attr($text_align);?> uppercase mimic-small bold ts-widget-heading"><?php echo $widget_heading;?></h5>
                    <?php echo do_shortcode('[divider style="line" padding_bottom="15" padding_top="0"]');?>
                    <?php
                    endif
                    ?>
                
                    <div class="loop entries blog-entries loop-widget loop-widget-simple">
                        <?php                        
                        $exc_lnth = 80;
                        $excerpt_length = (isset($atts['excerpt_length']) && $atts['excerpt_length'] != '') ? $atts['excerpt_length'] : $exc_lnth;
                        
                        $ts_show = ts_maybe_show_blog_widget_elements($atts);
                        
                        $show_excerpt = ($excerpt_length == '0' || !$ts_show->excerpt) ? false : true;
                        
                        $title_size = ts_get_blog_loop_title_size($atts, 4);
                        
                        $text_align = ts_get_blog_loop_text_align($atts);
                        
                        if($ts_query->have_posts()) : 
                            $i = 1;
                            while($ts_query->have_posts()) : 
                                $ts_query->the_post();
                                $atts['exclude_these_later'] = (isset($atts['exclude_these_later'])) ? $atts['exclude_these_later'] : '';
                                if(!ts_attr_is_false($atts['exclude_these_later'])) $ts_previous_posts[] = $ts_query->post->ID;
                                $post_type = get_post_type();
                        ?>                        
                        <div id="post-<?php the_ID();?>" class="entry clearfix container">
                            <div class="entry-content ts-row">
                                <?php
                                if($ts_show->media) :
                                    $allow_vids = (isset($atts['allow_videos'])) ? $atts['allow_videos'] : '';
                                    $allow_gals = (isset($atts['allow_galleries'])) ? $atts['allow_galleries'] : '';
                                    $media = ts_get_featured_media(array('media_width'=>400,'media_height'=>225,'allow_videos'=>$allow_vids,'allow_galleries'=>$allow_gals, 'wrap_class'=>$media_class));
                                    if($ts_show->featured_first) :
                                        echo ($i == 1) ? $media : '';
                                    else :
                                        echo $media;
                                    endif;
                                endif;
                                ?>   
                                <div class="title-post-wrap <?php echo ($media_class == 'span4' && trim($media)) ? 'span8' : 'span12';?>">
                                    <div class="title-date clearfix">
                                        <div class="title-info">                                    
                                            <h<?php echo absint($title_size->h).' '.$title_size->style;?> class="title-h <?php echo esc_attr($text_align);?>"><?php echo ts_sticky_badge();?><a href="<?php the_permalink();?>"><?php the_title();?></a></h<?php echo absint($title_size->h);?>>
                                            <?php
                                            if($ts_show->meta) :
                                            ?>
                                            <div class="entry-info smaller uppercase <?php echo esc_attr($text_align);?>"><?php 
                                                    echo '<span class="meta-item meta-item-date">'.get_the_date('M j, Y').'</span>';
                                                    if(comments_open()) :
                                                        $comment_number = get_comments_number();
                                                        echo '<span class="meta-item meta-item-comments">';
                                                        echo '<a href="'.esc_url(ts_link2comments(get_permalink())).'">';
                                                        echo '<i class="fa fa-comments"></i>'.$comment_number.'</a>';
                                                        echo '</span>';
                                                    endif;
                                            ?></div>
                                            <?php
                                            endif;
                                            ?>
                                        </div>
                                    </div>
                                    
                                    <?php
                                    if($ts_show->first_excerpt) :
                                        $show_excerpt = ($i == 1) ? $show_excerpt : false;
                                    endif;
                                    
                                    if($show_excerpt) :
                                    ?>                   
                                    <div class="post">
                                        <p class="<?php echo esc_attr($text_align);?>"><?php 
                                        $content = (has_excerpt()) ? get_the_excerpt() : apply_filters('the_content', $ts_query->post->post_content);
                                        echo ts_truncate($content, $excerpt_length);
                                        ?></p>
                                    </div>
                                    <?php
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                        
                        <?php
                                $i++;
                            endwhile;
                        endif;
                        ?>                        
                    </div>
                </div>
