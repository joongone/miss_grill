<?php
/*---------------------------------------------------------------------------------*/
/* Blog Mini Widget */
/*---------------------------------------------------------------------------------*/
class ts_blog_mini_widget extends WP_Widget {

    function ts_blog_mini_widget() {
        $widget_ops = array(
            'classname' => 'blog-mini-widget',
            'description' => __('Display blog posts in widget form.', 'ThemeStockyard') 
        );
        parent::WP_Widget(false, '(TS) '.__('Blog Mini', 'ThemeStockyard'),$widget_ops);      
    }
    
    function widget($args, $instance) 
    {  
        extract( $args );
        
        $title = $instance['title'];
        $widget_layout = $instance['widget_layout'];
        $limit   = $instance['limit'];
        $category_name   = $instance['category_name'];
        $exclude_previous_posts   = $instance['exclude_previous_posts'];
        $exclude_these_later   = $instance['exclude_these_later'];
        $show_excerpt   = $instance['show_excerpt'];
        $show_meta   = $instance['show_meta'];
        $show_media   = $instance['show_media'];
        $allow_videos   = $instance['allow_videos'];
        $allow_galleries   = $instance['allow_galleries'];
        
        
        echo $before_widget;
        if ($title) echo $before_title . $title . $after_title;
        echo '<div class="blog-mini-widget-inner clearfix">';
        echo do_shortcode('[blog_widget widget_layout="'.esc_attr($widget_layout).'" limit="'.esc_attr($limit).'" category_name="'.esc_attr($category_name).'" override_widget_heading="no" exclude_previous_posts="'.esc_attr($exclude_previous_posts).'" exclude_these_later="'.esc_attr($exclude_these_later).'" show_excerpt="'.esc_attr($show_excerpt).'" show_meta="'.esc_attr($show_meta).'" show_media="'.esc_attr($show_media).'" allow_videos="'.esc_attr($allow_videos).'" allow_galleries="'.esc_attr($allow_galleries).'" called_via="widget"][/blog_widget]');
        echo '</div>';
        echo $after_widget;
   }

    function update($new_instance, $old_instance) {                
        
        $new_instance = (array) $new_instance;
        
        $instance['title'] = $new_instance['title'];
        $instance['widget_layout'] = $new_instance['widget_layout'];
        $instance['limit']   = $new_instance['limit'];
        $instance['category_name']   = $new_instance['category_name'];
        $instance['exclude_previous_posts']   = $new_instance['exclude_previous_posts'];
        $instance['exclude_these_later']   = $new_instance['exclude_these_later'];
        $instance['show_excerpt']   = $new_instance['show_excerpt'];
        $instance['show_meta']   = $new_instance['show_meta'];
        $instance['show_media']   = $new_instance['show_media'];
        $instance['allow_videos']   = $new_instance['allow_videos'];
        $instance['allow_galleries']   = $new_instance['allow_galleries'];

        return $instance;
    }


    function form($instance) {

        $defaults = array(            
            'title' => '',
            'widget_layout' => '',
            'limit' => '5',
            'category_name' => '',
            'exclude_previous_posts' => 'no',
            'exclude_these_later' => 'no',
            'show_excerpt' => 'no',
            'show_meta' => 'yes',
            'show_media' => 'yes',
            'allow_videos' => 'yes',
            'allow_galleries' => 'no'
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
			<label for="<?php echo $this->get_field_id('widget_layout'); ?>"><?php _e('Layout:', 'ThemeStockyard'); ?></label>
			<select name="<?php echo $this->get_field_name('widget_layout'); ?>" class="widefat" id="<?php echo $this->get_field_id('widget_layout'); ?>">
				<option value="vertical" <?php selected($instance['widget_layout'], "vertical");?>><?php _e('Vertical', 'ThemeStockyard'); ?></option>
				<option value="horizontal" <?php selected($instance['widget_layout'], "horizontal");?>><?php _e('Horizontal', 'ThemeStockyard'); ?></option>           
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
			<label for="<?php echo $this->get_field_id('show_excerpt'); ?>"><?php _e('Show Excerpt?', 'ThemeStockyard'); ?></label>
			<select name="<?php echo $this->get_field_name('show_excerpt'); ?>" class="widefat" id="<?php echo $this->get_field_id('show_excerpt'); ?>">
				<option value="no" <?php selected($instance['show_excerpt'], "no");?>><?php _e('No', 'ThemeStockyard'); ?></option>
				<option value="yes" <?php selected($instance['show_excerpt'], "yes");?>><?php _e('Yes', 'ThemeStockyard'); ?></option>      
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('show_meta'); ?>"><?php _e('Show Meta?', 'ThemeStockyard'); ?></label>
			<select name="<?php echo $this->get_field_name('show_meta'); ?>" class="widefat" id="<?php echo $this->get_field_id('show_meta'); ?>">
				<option value="yes" <?php selected($instance['show_meta'], "yes");?>><?php _e('Yes', 'ThemeStockyard'); ?></option> 
				<option value="no" <?php selected($instance['show_meta'], "no");?>><?php _e('No', 'ThemeStockyard'); ?></option>     
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('show_media'); ?>"><?php _e('Show Media (images, videos, etc)?', 'ThemeStockyard'); ?></label>
			<select name="<?php echo $this->get_field_name('show_media'); ?>" class="widefat" id="<?php echo $this->get_field_id('show_media'); ?>">
				<option value="yes" <?php selected($instance['show_media'], "yes");?>><?php _e('Yes', 'ThemeStockyard'); ?></option> 
				<option value="first" <?php selected($instance['show_media'], "first");?>><?php _e('Only for the first post', 'ThemeStockyard'); ?></option> 
				<option value="no" <?php selected($instance['show_media'], "no");?>><?php _e('No', 'ThemeStockyard'); ?></option>     
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('allow_videos'); ?>"><?php _e('Allow videos?', 'ThemeStockyard'); ?></label>
			<select name="<?php echo $this->get_field_name('allow_videos'); ?>" class="widefat" id="<?php echo $this->get_field_id('allow_videos'); ?>">
				<option value="yes" <?php selected($instance['allow_videos'], "yes");?>><?php _e('Yes', 'ThemeStockyard'); ?></option>
				<option value="no" <?php selected($instance['allow_videos'], "no");?>><?php _e('No', 'ThemeStockyard'); ?></option>      
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('allow_galleries'); ?>"><?php _e('Allow Image Galleries?', 'ThemeStockyard'); ?></label>
			<select name="<?php echo $this->get_field_name('allow_galleries'); ?>" class="widefat" id="<?php echo $this->get_field_id('allow_galleries'); ?>">
				<option value="no" <?php selected($instance['allow_galleries'], "no");?>><?php _e('No', 'ThemeStockyard'); ?></option>
				<option value="yes" <?php selected($instance['allow_galleries'], "yes");?>><?php _e('Yes', 'ThemeStockyard'); ?></option>      
			</select>
		</p>
    <?php 
    }
}

register_widget('ts_blog_mini_widget');