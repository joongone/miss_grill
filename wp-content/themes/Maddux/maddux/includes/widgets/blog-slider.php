<?php
/*---------------------------------------------------------------------------------*/
/* Blog Slider Widget */
/*---------------------------------------------------------------------------------*/
class ts_blog_slider_widget extends WP_Widget {

    function ts_blog_slider_widget() {
        $widget_ops = array(
            'classname' => 'blog-slider-widget',
            'description' => __('Display blog posts as a slider.', 'ThemeStockyard') 
        );
        parent::WP_Widget(false, '(TS) '.__('Blog Slider', 'ThemeStockyard'),$widget_ops);      
    }
    
    function widget($args, $instance) 
    {  
        extract( $args );
        
        $title = $instance['title'];
        $slider_type = $instance['slider_type'];
        $limit   = $instance['limit'];
        $category_name   = $instance['category_name'];
        $exclude_previous_posts   = $instance['exclude_previous_posts'];
        $exclude_these_later   = $instance['exclude_these_later'];
        $text_align   = $instance['text_align'];
        $show_meta   = $instance['show_meta'];
        $allow_videos   = $instance['allow_videos'];
        $image_size   = $instance['image_size'];
        $title_size   = $instance['title_size'];
        
        
        echo $before_widget;
        if ($title) echo $before_title . $title . $after_title;
        echo '<div class="blog-slider-widget-inner clearfix">';
        echo do_shortcode('[blog_slider slider_type="'.esc_attr($slider_type).'" limit="'.esc_attr($limit).'" category_name="'.esc_attr($category_name).'" exclude_previous_posts="'.esc_attr($exclude_previous_posts).'" exclude_these_later="'.esc_attr($exclude_these_later).'" text_align="'.esc_attr($text_align).'" allow_videos="'.esc_attr($allow_videos).'" show_excerpt="no" show_meta="'.esc_attr($show_meta).'" title_size="'.esc_attr($title_size).'" image_size="'.esc_attr($image_size).'"][/blog_slider]');
        echo '</div>';
        echo $after_widget;
   }

    function update($new_instance, $old_instance) {                
        
        $new_instance = (array) $new_instance;
        
        $instance['title'] = $new_instance['title'];
        $instance['slider_type'] = $new_instance['slider_type'];
        $instance['limit']   = $new_instance['limit'];
        $instance['category_name']   = $new_instance['category_name'];
        $instance['exclude_previous_posts']   = $new_instance['exclude_previous_posts'];
        $instance['exclude_these_later']   = $new_instance['exclude_these_later'];
        $instance['text_align']   = $new_instance['text_align'];
        $instance['show_meta']   = $new_instance['show_meta'];
        $instance['allow_videos']   = $new_instance['allow_videos'];
        $instance['image_size']   = $new_instance['image_size'];
        $instance['title_size'] = $new_instance['title_size'];

        return $instance;
    }


    function form($instance) {

        $defaults = array(
            'title' => '',
            'slider_type' => 'flexslider',
            'limit' => '5',
            'category_name' => '',
            'exclude_previous_posts' => 'no',
            'exclude_these_later' => 'no',
            'text_align' => '',
            'show_meta' => 'no',
            'allow_videos' => 'no',
            'image_size' => 'medium',
            'title_size' => 'H4',
        );

        $instance = wp_parse_args($instance, $defaults);

        $category_namess = get_terms('category');
        $category_names = array("" => "All");
        foreach ($category_namess as $cat) {
            $category_names[$cat->name] = $cat->name;
        }
        ?>
        <p>
		   <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ThemeStockyard'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($instance['title']); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('slider_type'); ?>"><?php _e('Slider Type:', 'ThemeStockyard'); ?></label>
			<select name="<?php echo $this->get_field_name('slider_type'); ?>" class="widefat" id="<?php echo $this->get_field_id('slider_type'); ?>">
				<option value="flexslider" <?php selected($instance['slider_type'], "flexslider");?>><?php _e('Flexslider', 'ThemeStockyard'); ?></option>
				<option value="carousel" <?php selected($instance['slider_type'], "carousel");?>><?php _e('Carousel', 'ThemeStockyard'); ?></option>           
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('limit'); ?>"><?php _e('Limit:', 'ThemeStockyard'); ?></label>
			<select name="<?php echo $this->get_field_name('limit'); ?>" class="widefat" id="<?php echo $this->get_field_id('limit'); ?>">
				<?php
				for($i = 1; $i <= 10; $i++)
				{
                    echo '<option value="'.$i.'" '.selected($instance['limit'], $i, false).'>'.$i.'</option>'."\n";
				}
				?>      
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('category_name'); ?>"><?php _e('Category:', 'ThemeStockyard'); ?></label>
			<select name="<?php echo $this->get_field_name('category_name'); ?>" class="widefat" id="<?php echo $this->get_field_id('category_name'); ?>">
				<?php
				foreach($category_names AS $key => $category_name)
				{
                    echo '<option value="'.$key.'" '.selected($instance['category_name'], $key, false).'>'.$category_name.'</option>'."\n";
				}
				?>      
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('exclude_previous_posts'); ?>"><?php _e('Exclude Previous Posts?', 'ThemeStockyard'); ?></label>
			<select name="<?php echo $this->get_field_name('exclude_previous_posts'); ?>" class="widefat" id="<?php echo $this->get_field_id('exclude_previous_posts'); ?>">
				<option value="no" <?php selected($instance['exclude_previous_posts'], "no");?>><?php _e('No', 'ThemeStockyard'); ?></option>
				<option value="yes" <?php selected($instance['exclude_previous_posts'], "yes");?>><?php _e('Yes', 'ThemeStockyard'); ?></option>      
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('exclude_these_later'); ?>"><?php _e('Exclude These Posts Later?', 'ThemeStockyard'); ?></label>
			<select name="<?php echo $this->get_field_name('exclude_these_later'); ?>" class="widefat" id="<?php echo $this->get_field_id('exclude_these_later'); ?>">
				<option value="no" <?php selected($instance['exclude_these_later'], "no");?>><?php _e('No', 'ThemeStockyard'); ?></option>
				<option value="yes" <?php selected($instance['exclude_these_later'], "yes");?>><?php _e('Yes', 'ThemeStockyard'); ?></option>      
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('text_align'); ?>"><?php _e('Text Alignment:', 'ThemeStockyard'); ?></label>
			<select name="<?php echo $this->get_field_name('text_align'); ?>" class="widefat" id="<?php echo $this->get_field_id('text_align'); ?>">
				<option value="left" <?php selected($instance['text_align'], "left");?>><?php _e('Left', 'ThemeStockyard'); ?></option>
				<option value="center" <?php selected($instance['text_align'], "center");?>><?php _e('Center', 'ThemeStockyard'); ?></option> 
				<option value="right" <?php selected($instance['text_align'], "right");?>><?php _e('Right', 'ThemeStockyard'); ?></option>      
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('show_meta'); ?>"><?php _e('Show Meta?', 'ThemeStockyard'); ?></label>
			<select name="<?php echo $this->get_field_name('show_meta'); ?>" class="widefat" id="<?php echo $this->get_field_id('show_meta'); ?>">  
				<option value="no" <?php selected($instance['show_meta'], "no");?>><?php _e('No', 'ThemeStockyard'); ?></option>  
				<option value="yes" <?php selected($instance['show_meta'], "yes");?>><?php _e('Yes', 'ThemeStockyard'); ?></option>  
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('allow_videos'); ?>"><?php _e('Allow videos in slider?', 'ThemeStockyard'); ?></label>
			<select name="<?php echo $this->get_field_name('allow_videos'); ?>" class="widefat" id="<?php echo $this->get_field_id('allow_videos'); ?>">
				<option value="no" <?php selected($instance['allow_videos'], "no");?>><?php _e('No', 'ThemeStockyard'); ?></option>
				<option value="yes" <?php selected($instance['allow_videos'], "yes");?>><?php _e('Yes', 'ThemeStockyard'); ?></option>      
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('image_size'); ?>"><?php _e('Image Size:', 'ThemeStockyard'); ?></label>
			<select name="<?php echo $this->get_field_name('image_size'); ?>" class="widefat" id="<?php echo $this->get_field_id('image_size'); ?>">
				<option value="small" <?php selected($instance['image_size'], "small");?>><?php _e('Small', 'ThemeStockyard'); ?></option>
				<option value="medium" <?php selected($instance['image_size'], "medium");?>><?php _e('Medium', 'ThemeStockyard'); ?></option> 
				<option value="large" <?php selected($instance['image_size'], "large");?>><?php _e('Large', 'ThemeStockyard'); ?></option>      
			</select>
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('title_size'); ?>"><?php _e('Post Title Size:', 'ThemeStockyard'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('title_size'); ?>"  value="<?php echo esc_attr($instance['title_size']); ?>" class="widefat" id="<?php echo $this->get_field_id('title_size'); ?>" />
		   <span style="display:block;color:#999"><?php _e('Examples: H1, H2, H3, H4, H5, H6... or enter any font size (ex: 16px)','ThemeStockyard');?></span>
		</p>
    <?php 
    }
}

register_widget('ts_blog_slider_widget');