<?php
global $smof_data, $ts_slider_post_ids, $ts_page_id, $ts_previous_posts;

$slider_margin_class = (ts_postmeta_vs_default($ts_page_id, '_page_slider_bottom_margin', 'yes') == 'no') ? 'has-no-bottom-margin' : 'has-bottom-margin';
$slider_width       = ts_postmeta_vs_default($ts_page_id, '_page_slider_width', 'content');
$slider_width_class = ($slider_width == 'content') ? 'container' : 'full';
$slider_height      = preg_replace("/[^0-9]*/","", ts_postmeta_vs_default($ts_page_id, '_page_slider_height', 420));
$slider_height      = (ctype_digit($slider_height) && $slider_height > 100) ? $slider_height : 420;
$slider_carousel_height  = preg_replace("/[^0-9]*/","", ts_postmeta_vs_default($ts_page_id, '_page_slider_carousel_height', 420));
$slider_carousel_height  = (ts_number_within_range($slider_carousel_height, 300, 600)) ? $slider_carousel_height : 420;
$slider_text_align  = ts_postmeta_vs_default($ts_page_id, '_page_slider_text_align', 'left');
$slider_text_align  = (in_array($slider_text_align, array('left','center','right'))) ? $slider_text_align : 'left';
$slider_allow_vids  = ts_postmeta_vs_default($ts_page_id, '_page_slider_allow_videos', 'no');
$slider_allow_vids  = ($slider_allow_vids == 'yes') ? true : false;

$ts_slider_type             = get_post_meta($ts_page_id, '_page_slider_type', true);
$ts_slider_source           = get_post_meta($ts_page_id, '_page_slider_source', true);
$ts_slider_blog_post_ids    = get_post_meta($ts_page_id, '_page_slider_blog_post_ids', true);
$ts_slider_category         = get_post_meta($ts_page_id, '_page_slider_category', true);
$ts_slider_blog_cats        = get_post_meta($ts_page_id, '_page_slider_blog_cats'); // array
$ts_slider_portfolio_cats   = get_post_meta($ts_page_id, '_page_slider_portfolio_cats', true);
$ts_slider_count            = get_post_meta($ts_page_id, '_page_slider_count', true);
$ts_slider_count            = ($ts_slider_count) ? $ts_slider_count : 10;

$slider_button_color = ts_option_vs_default('flexslider_button_color', 'white');

if(in_array($ts_slider_type, array('carousel','flex')) && $ts_slider_source) :
    
    if($ts_slider_source == 'blog' || $ts_slider_source == 'specific_blog_posts') :
    
        $meta_query = array(
            'relation'=>'OR', 
            array('key'=>'_thumbnail_id'),
            array('key'=>'_p_preview_image_id')
        );
        
        if($slider_allow_vids) :
            $meta_query[] = array('key'=>'_p_vimeo_id');
            $meta_query[] = array('key'=>'_p_youtube_id');
        endif;
        
        $slider_query_params = array(
            'meta_query'        => $meta_query, 
            'posts_per_page'    => $ts_slider_count
        );
        
        // if user wants to show specific posts
        if($ts_slider_source == 'specific_blog_posts' && trim($ts_slider_blog_post_ids)) :
            $ts_slider_blog_post_ids = str_replace(' ', '', $ts_slider_blog_post_ids);
            $ts_slider_blog_post_ids_array = explode(',', $ts_slider_blog_post_ids);
            if(count($ts_slider_blog_post_ids_array) > 0) :
                $slider_query_params['post__in'] = $ts_slider_blog_post_ids_array;
            else :
                $slider_query_params['post__in'] = array();
            endif;
        endif;
        
        // if user wants to show specific categories
        if($ts_slider_source == 'blog' && is_array($ts_slider_blog_cats) && count($ts_slider_blog_cats) > 0 && !isset($ts_slider_blog_cats['error'])) :
            if(isset($ts_slider_blog_cats[0]) && is_array($ts_slider_blog_cats[0])) :
                // do nothing
            else :
                $slider_query_params['cat'] = implode(',', $ts_slider_blog_cats);
            endif;
        endif;
        
        // do the query
        $slider = new WP_Query($slider_query_params);
        
        // set $ts_slider_source as "blog"
        $ts_slider_source = 'blog';
        
    elseif($ts_slider_source == 'portfolio') :
    
        $meta_query = array(
            'relation'=>'OR', 
            array('key'=>'_thumbnail_id'),
            array('key'=>'_portfolio_preview_image_id')
        );
        
        if($slider_allow_vids) :
            $meta_query[] = array('key'=>'_portfolio_vimeo_id');
            $meta_query[] = array('key'=>'_portfolio_youtube_id');
        endif;
        
        $tax_query = '';
        if(is_array($ts_slider_portfolio_cats) && count($ts_slider_portfolio_cats) && !isset($ts_slider_portfolio_cats['error'])) :
            $tax_query = array(
                array(
                    'taxonomy' => 'portfolio-category',
                    'field' => 'term_id',
                    'terms' => $ts_slider_portfolio_cats
                )
            );
        endif;
        
        $slider = new WP_Query(array('post_type'=>'portfolio','meta_query' => $meta_query, 'tax_query' => $tax_query,'posts_per_page'=>$ts_slider_count));
        
    endif;
    
    $output = '';

    if(is_object($slider) && $slider->have_posts()) : 
        
        while ($slider->have_posts()) : 
            $slider->the_post();
            
            $ts_previous_posts[] = $slider->post->ID;
            $ts_slider_post_ids[] = $slider->post->ID;
            
            $post_type = get_post_type();
            if($post_type == 'post') :
                $prefix = 'p';
            elseif($post_type == 'portfolio') :
                $prefix = 'portfolio';
            endif;
            
            $slider_photo_id = get_post_thumbnail_id($slider->post->ID);
            $slider_preview_id = ($post_type == 'post') ? get_post_meta($slider->post->ID, '_p_preview_image_id', true) : '';
            $slider_preview_exists = ($slider_preview_id) ? true : false;
            $slider_photo_id = ($slider_preview_id) ? $slider_preview_id : $slider_photo_id;
            
            /* what's the post format? */
            if($post_type == 'post') :
                $content_type = get_post_format();
            elseif($post_type == 'portfolio') :
                $content_type = get_post_meta($slider->post->ID, '_portfolio_project_type', true);
            endif;
            
            $item_el = ($ts_slider_type == 'carousel') ? 'div' : 'li';
            $video = '';
            $video_src = '';
            $video_id = '';
            $vdata = '';
            $vimeo = $youtube = $video_service = '';
            $img = '';
            $img_blank = get_template_directory_uri().'/images/blank.gif';
            $w = '';
            $h = '';
            $w_mobile = '';
            $h_mobile = '';
            $hide_text = '';
            if($ts_slider_type == 'carousel') :
                $w = 630; // this is just a good starting point
                $h = 420; // this is just a good starting point
                $dims = ts_get_proportional_size($w, $h, null, $slider_carousel_height);  
                $w = $dims['width'];
                $h = $dims['height'];
            elseif($ts_slider_type == 'flex') :
                if($slider_width == 'content' || ts_option_vs_default('layout', 1) < 1) :
                    $w = 1040; // this is just a good starting point
                else :
                    $w = 1500;
                endif;
                $h = $slider_height;
            endif;
            $style = '';
            $title = '';
            $descr = '';
            $descr_limit = ($ts_slider_type == 'carousel') ? 150 : 200;
            $title_size = ($ts_slider_type == 'carousel') ? 2 : 1;
            $date = '';
            $category   = '';
            $cat_name   = '';
            $cat_color  = '';
            $author     = '';
            $comments   = '';
            $link_begin = '';
            $link_end = '';
            $url = '';
            $read_more = '';
            $readmore = '';
            $readmore_inline = '';
            $readmore_block = '';
            $meta = '';
            $categories = '';
            $dims = '';
            $info = '';
            $img_wrap_begin = '';
            $img_wrap_end = '';
            $target = '_self';
            
            if($slider_photo_id) :
                $slider_photo   = wp_get_attachment_image_src($slider_photo_id, 'full');
                $slider_photo   = (isset($slider_photo[0])) ? $slider_photo[0] : '';
                if($ts_slider_type == 'carousel') :
                    $slider_photo   = ($slider_photo) ? aq_resize($slider_photo, $w, $h, true, false, true, $slider_photo_id) : '';
                else :
                    $sh = ($w == 1500) ? 0 : $h;
                    $slider_photo   = ($slider_photo) ? aq_resize($slider_photo, $w, $sh, true, false, true, $slider_photo_id) : '';
                endif;
                $img            = (isset($slider_photo[0])) ? $slider_photo[0] : 'error';
                if($img == 'error') :
                    $output .= '<!-- error: aq_resize -->';
                    continue;
                endif;
                $w              = $slider_photo[1];
                $h              = ($w == 1500) ? $slider_height : $slider_photo[2];
                $style          = ($ts_slider_type == 'carousel') ? 'style="width:'.absint($w).'px;height:'.absint($h).'px;"' : '';
                $title          = get_the_title();
                
                if($ts_slider_source == 'blog') :
                    $descr      = (has_excerpt()) ? strip_tags(get_the_excerpt()) : ts_trim_text(apply_filters('the_content', get_the_content()), $descr_limit);
                    $url        = get_permalink();
                    $read_more  = __('Read More', 'ThemeStockyard');
                    $date       = get_the_date('M j, Y');
                    $category   = ts_get_the_category('category', 'big_array:1', '', $slider->post->ID);
                    
                    $cat_name   = $category[0]['name'];
                    $cat_color  = ($category[0]['color']) ? $category[0]['color'] : 'primary';
                    
                    $alt_cat_name = get_post_meta( $slider->post->ID, '_'.$prefix.'_alt_category_text', true );
                    
                    $cat_name   = (trim($alt_cat_name)) ? $alt_cat_name : $cat_name;
                    
                    $author     = get_the_author();
                    if(ts_disqus_active()) :
                        $comments   = '<span class="disqus-comment-count" data-disqus-url="'.get_permalink().'">0</span>';
                    else :
                        $comments   = get_comments_number();
                    endif;
                    
                    /* this will change per theme */
                    $meta .= '<span class="smaller uppercase bold">';
                    $meta .= do_shortcode('[highlight background_color="'.$cat_color.'" text_color="white"]'.$cat_name.'[/highlight]');
                    $meta .= '</span>';
                    $meta .= '<span class="smaller uppercase">';
                    $meta .= do_shortcode('[highlight background_color="#000" text_color="white" background_opacity=".5"]'.$date.'[/highlight]');
                    $meta .= '</span>';
                    
                    $readmore_block = '<span class="smaller uppercase">'.$author.'</span> ';
                    $readmore_block .= '<span class="comment-bubble border-primary bg-primary bg-primary-text">'.$comments.'</span>';
                elseif($ts_slider_source == 'portfolio') :
                    $descr      = (has_excerpt()) ? strip_tags(get_the_excerpt()) : ts_trim_text(apply_filters('the_content', get_the_content()), $descr_limit);
                    $url        = get_permalink();
                    $read_more  = __('Read More', 'ThemeStockyard');
                    $meta       = ts_get_the_category('portfolio-category');
                endif;
                
                $link_begin     = (trim($url)) ? '<a href="'.esc_url($url).'" class="ts-item-link" target="'.esc_attr($target).'">' : '';
                $link_begin2    = (trim($url)) ? '<a href="'.esc_url($url).'" class="ts-item-link ts-item-link-2" target="'.esc_attr($target).'">' : '';
                $link_end       = (trim($url)) ? '</a>' : '';
            endif;
            if($slider_allow_vids && (in_array($content_type, array('video','youtube','vimeo','self_hosted','self_hosted_video'))) && !$slider_preview_exists) :
                $vimeo          = get_post_meta( $slider->post->ID, '_'.$prefix.'_vimeo_id', true );
                $youtube        = get_post_meta( $slider->post->ID, '_'.$prefix.'_youtube_id', true );
                $content_type .= ($vimeo) ? $vimeo : $youtube;
                if($vimeo || $youtube) :
                    $video_service  = ($vimeo) ? 'vimeo' : (($youtube) ? 'youtube' : '');
                    $video_id       = ($vimeo) ? ts_get_video_id($vimeo) : (($youtube) ? ts_get_video_id($youtube) : '');
                    $vdata          = ts_get_and_save_video_data($video_id, $video_service);
                    //$info           = maybe_serialize(ts_get_saved_video_data($video_id, $video_service));    // for testing
                    if($ts_slider_type == 'carousel') :     
                        $style          = 'style="width:'.absint($w).'px;height:'.absint($h).'px;"';
                    endif;
                endif;
                if($video_id) :
                    $img = '';
                else :
                    $youtube = $vimeo = '';
                endif;
            endif;
            if(!$img && !$vimeo && !$youtube) :
                continue;
            endif;
            
            if($ts_slider_type == 'carousel') :
                if($slider_height > 202) :
                    $w_mobile = $w;
                    $h_mobile = $h;
                else :
                    $w_mobile = $w;
                    $h_mobile = $h; 
                endif;
            endif;
            
            if($ts_slider_type == 'flex' && $slider_width_class == 'full' && $img) :
                $style = 'style="background-image:url(\''.esc_url($img).'\');height:'.absint($h).'px"';
                $img = $img_blank;
                $img_wrap_begin = '';
                $img_wrap_end = '';
            endif;
            
            $output .= '<'.tag_escape($item_el).' class="'.esc_attr($ts_slider_type).'-item ts-slider-item" '.$style.' data-width="'.absint($w).'" data-height="'.absint($h).'">';
            $output .= ($ts_slider_type == 'flex') ? $link_begin2 : '';
            
            $img_height = ($ts_slider_type == 'carousel') ? 'height="'.absint($h).'"' : '';
            if($img) :
                $img_html = $img_wrap_begin.'<img src="'.esc_url($img).'" width="'.absint($w).'" '.$img_height.' alt=""/>'.$img_wrap_end;
            elseif($vimeo || $youtube) :
                if($vimeo) :
                    $color = str_replace('#', '', ts_option_vs_default('primary_color',''));
                    $video_src = 'https://player.vimeo.com/video/'.$video_id.'?title=0&amp;byline=0&amp;portrait=0&amp;color='.$color;
                else :
                    $video_src = 'https://www.youtube.com/embed/'.$video_id.'?rel=0&amp;version=3&amp;hd=1';
                endif;
                
                $output .= '<div class="fluid-width-video-wrapper"><div>';
                $output .= '<iframe id="'.esc_attr($video_service).'-'.$slider->post->ID.'" src="'.esc_url($video_src).'" width="'.absint($w).'" '.$img_height.' allowFullScreen webkitAllowFullScreen></iframe>';
                $output .= '</div></div>';
            endif;
            
            if($img) :
                $output .= $link_begin;
                $output .= ($ts_slider_type == 'flex' && $slider_width_class == 'full') ? '' : $img_html;
                
                if((trim($title) || trim($descr)) && $hide_text != '1') :
                    $_output = '';
                    
                    $_output .= '<div class="ts-item-details">';
                    $_output .= ($ts_slider_type == 'flex' && $w == 1500) ? '<div class="ts-item-details-inner container">' : '<div class="ts-item-details-inner">';
                    
                    if($ts_slider_source == 'portfolio') :
                        $_output .= '<h'.absint($title_size).' class="portfolio-title title text-'.esc_attr($slider_text_align).' color-white">'.$title.'</h'.absint($title_size).'>';
                        $_output .= (trim($meta)) ? '<p class="portfolio-meta text-'.esc_attr($slider_text_align).'">'.$meta.'</p>' : '';
                        $_output .= (trim($descr)) ? '<p class="portfolio-descr descr text-'.esc_attr($slider_text_align).'">'.$descr.$readmore_inline.'</p>' : '';
                    else :
                        $_output .= '<p class="blog-meta text-'.esc_attr($slider_text_align).'">'.$meta.'</p>';
                        $_output .= '<h'.absint($title_size).' class="blog-title title text-'.esc_attr($slider_text_align).' color-white">'.ts_sticky_badge().$title.'</h'.absint($title_size).'>';
                        $_output .= '<p class="blog-descr descr text-'.esc_attr($slider_text_align).'" style="display:none">'.$descr.'</p>';
                        $_output .= '<p class="blog-author-comments text-'.esc_attr($slider_text_align).'">'.$readmore_block.'</p>';
                    endif;
                    
                    
                    $_output .= '</div></div>';
                
                    $output .= $_output;
                endif;
                
                $output .= $link_end;
            endif;
            
            $output .= '</'.tag_escape($item_el).'>';
            
            
        endwhile;
        wp_reset_query();
    endif;
    
    $full_divider = do_shortcode('[divider style="line" padding_top="30" padding_bottom="0"]');
    
    if(trim($output)) :
        if($ts_slider_type == 'carousel') :
            echo '<div id="main-slider-wrap" class="ts-slider-wrap loop-slider-wrap clear ts-fade-in '.esc_attr($slider_margin_class).' '.esc_attr($slider_width_class).'">';
            echo '<div class="owl-carousel generic-carousel gallery" data-slide-width="'.absint($w).'" data-desired-slide-width="'.absint($w).'" data-desired-slide-height="'.absint($h).'">';
            echo $output;
            echo '</div>';
            echo ($slider_width_class == 'full') ? '<div class="container">'.$full_divider.'</div>' : '';
            echo '</div>';
        elseif($ts_slider_type == 'flex') :
            echo '<div id="main-slider-wrap" class="ts-slider-wrap loop-slider-wrap flexslider-wrap clear slider '.esc_attr($slider_margin_class).' '.esc_attr($slider_width_class).' ts-fade-in ts-item-details-'.esc_attr($slider_text_align).' ts-flex-nav-center">';
            echo '<div class="flexslider gallery" style="overflow:hidden;">';
            echo '<ul class="slides" style="overflow:hidden;">';
            echo $output;
            echo '</ul>';
            echo '</div>';
            echo '<div class="ts-main-flex-nav"></div>';            
            echo ($slider_width_class == 'full') ? '<div class="container">'.$full_divider.'</div>' : '';
            echo '</div>';
        endif;
    endif;
endif;