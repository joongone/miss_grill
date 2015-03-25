<?php
if($ts_show_sidebar == 'yes') :
    $entries_class = 'has-sidebar';
else :
    $entries_class = 'no-sidebar';
endif;

$ts_query = (isset($atts) && ($atts['default_query'] === false)) ? new WP_Query($atts) : $wp_query;
$atts = (isset($atts)) ? $atts : array();
?>
                <div class="loop-wrap loop-3-column-wrap">
                    <div class="entries blog-entries loop loop-3-column <?php echo esc_attr($entries_class);?> clearfix">
                        <?php
                        $exc_lnth = ts_option_vs_default('excerpt_length_2col_3col_medium', 160);
                        $excerpt_length = (isset($atts['excerpt_length']) && $atts['excerpt_length'] != '') ? $atts['excerpt_length'] : $exc_lnth;
                        
                        $ts_show = ts_maybe_show_blog_elements($atts);
                        
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
                        
                        <div id="post-<?php echo esc_attr($ts_query->post->ID);?>" class="entry span4">
                            <div class="entry-content">
                                <?php
                                if($ts_show->media) :
                                    $allow_vids = (isset($atts['allow_videos'])) ? $atts['allow_videos'] : '';
                                    $allow_gals = (isset($atts['allow_galleries'])) ? $atts['allow_galleries'] : '';
                                    echo ts_get_featured_media(array('media_width'=>480,'media_height'=>270,'allow_videos'=>$allow_vids,'allow_galleries'=>$allow_gals));
                                endif;
                                ?>   
                                <div class="title-date clearfix">
                                    <div class="title-info">   
                                    <!-- SJ_ -->                                 
                                        <h<?php echo absint($title_size->h).' '.$title_size->style;?> class="title-h <?php echo esc_attr($text_align);?>"><?php echo ts_sticky_badge();?><a href="<?php the_permalink();?>"><?php the_title();?></a></h<?php echo absint($title_size->h);?>>
                                        <?php 
                                        if($ts_show->meta) :
                                            if($post_type == 'portfolio') :
                                        ?>
                                        <div class="entry-info portfolio-entry-info"><p class="smaller uppercase <?php echo esc_attr($text_align);?>"><?php echo ts_get_the_category('portfolio-category','text');?></p></div>
                                        <?php
                                            elseif($post_type == 'page') :
                                        ?>
                                        <div class="entry-info page-entry-info"><p class="smaller uppercase <?php echo esc_attr($text_align);?>"><?php _e('Page last modified:', 'ThemeStockyard');?> <?php the_modified_date();?></p></div>
                                        <?php
                                            elseif($post_type == 'post') :
                                                $author_avatar = '';
                                                if(isset($atts['show_author_avatar']) && $atts['show_author_avatar']) :
                                                    $author_avatar = get_avatar(get_the_author_meta('user_email'), 20);
                                                endif;
                                                $author_posts_link  = '<span class="meta-item meta-item-author">';
                                                $author_posts_link .= '<a href="'.get_author_posts_url(get_the_author_meta('ID')).'">';
                                                $author_posts_link .= $author_avatar.get_the_author_meta('display_name').'</a></span>';
                                        ?>
                                        <div class="entry-info post-entry-info"><p class="smaller uppercase <?php echo esc_attr($text_align);?>"><?php echo $author_posts_link;?><?php 
                                                echo '<span class="meta-item meta-item-date">'.get_the_date('F j').'</span>';
                                                if(comments_open()) :
                                                    $comment_number = get_comments_number();
                                                    echo '<span class="meta-item meta-item-comments">';
                                                    echo '<a href="'.esc_url(ts_link2comments(get_permalink())).'">';
                                                    echo '<i class="fa fa-comments"></i>'.$comment_number;
                                                    echo '</a>';
                                                    echo '</span>';
                                                endif;
                                        ?></p></div>
                                        <?php
                                            endif;
                                        endif;
                                        ?>
                                    </div>
                                </div>    
                                                         
                                <?php
                                if($show_excerpt || $ts_show->read_more) :
                                ?>                   
                                <div class="post">
                                    <?php
                                    if($show_excerpt) :
                                    ?>
                                    
                                    <p class="<?php echo esc_attr($text_align);?>"><?php 
                                    $content = (has_excerpt()) ? get_the_excerpt() : apply_filters('the_content', $ts_query->post->post_content);
                                    echo ts_trim_text($content, $excerpt_length);
                                    ?></p>
                                    
                                    <?php
                                    endif;
                                    
                                    if($ts_show->read_more) :
                                    ?>
                                    <div class="read-more-wrap <?php echo esc_attr($text_align);?>">
                                        <div class="read-more mimic-smaller uppercase"><div class="wpautop-fix"><a href="<?php the_permalink();?>"><?php echo __('Read more', 'ThemeStockyard');?></a></div></div>
                                    </div>
                                    
                                    <?php
                                    endif;
                                    ?>
                                </div>
                                <?php
                                endif;
                                ?>
                                
                            </div>
                        </div>
                        
                        <?php
                                echo ($i == 3) ? '<div class="clear"></div>' : '';
                                $i++;
                                $i = ($i == 4) ? 1 : $i;
                            endwhile;
                            
                            $pagination = (isset($atts['show_pagination']) && $atts['show_pagination'] === false) ? '' : ts_paginator($atts);
                        else :
                            $pagination = '';
                            echo '<p class="no-results">'.__('Sorry, nothing here!', 'ThemeStockyard').'</p>';
                        endif;
                        ?>
                        
                    </div>
                    <?php echo $pagination; ?>
                </div>
