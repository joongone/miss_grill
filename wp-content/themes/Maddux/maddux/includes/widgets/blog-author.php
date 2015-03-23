<?php
/*---------------------------------------------------------------------------------*/
/* Blog Author Info */
/*---------------------------------------------------------------------------------*/
class ts_blog_author extends WP_Widget {

    function ts_blog_author() {
        $widget_ops = array(
            'classname' => 'blog-author-widget',
            'description' => __('Display info about the blog author.', 'ThemeStockyard') 
        );
        parent::WP_Widget(false, '(TS) '.__('Blog Author', 'ThemeStockyard'),$widget_ops);      
    }

    function widget($args, $instance) 
    {  
        extract( $args );
        $title          = $instance['title'];
        $bio            = $instance['bio'];
        $custom_email   = $instance['custom_email'];
        $avatar_size    = preg_replace("/[^0-9]/","",$instance['avatar_size']); if ( !$avatar_size ) $avatar_size = 48;
        $avatar_align   = $instance['avatar_align']; if ( !$avatar_align ) $avatar_align = 'left';
        $read_more_text = ($instance['read_more_text']) ? $instance['read_more_text'] : 'Read more';
        $read_more_url  = $instance['read_more_url'];
        
        
        echo $before_widget;
        if ($title) echo $before_title . $title . $after_title;
        echo '<div class="blog-author clearfix">';
        $avatar = ($custom_email) ? '<span class="align'.esc_attr($avatar_align).'">'.get_avatar($custom_email, $avatar_size ).'</span>' : '';
        ?>
        <p><?php echo $avatar . $bio; ?></p>
		<?php 
        if($read_more_url) echo '<div class="smaller"><p class="uppercase"><a href="'.esc_url($read_more_url).'">'.$read_more_text.'</a></p></div>';
        echo '</div>';
        echo $after_widget;
   }

   function update($new_instance, $old_instance) {                
        
        $new_instance = (array) $new_instance;

        $instance['title'] = strip_tags( $new_instance['title']);
        $instance['bio']   = strip_tags( $new_instance['bio']);
        if (current_user_can('unfiltered_html')) {
			$instance['bio'] =  $new_instance['bio'];
		} else {
			$instance['bio'] = strip_tags($new_instance['bio']);
		}
        $instance['custom_email'] = (is_email($new_instance['custom_email'])) ? strip_tags($new_instance['custom_email']) : '';
        $instance['avatar_size']   = strip_tags( $new_instance['avatar_size']);
        $instance['avatar_align'] = strip_tags( $new_instance['avatar_align']);
        $instance['read_more_text']   = strip_tags( $new_instance['read_more_text']);
        $instance['read_more_url'] = strip_tags( $new_instance['read_more_url']);

        return $instance;
   }

   function form($instance) {      
		$defaults = array( 
			'title'             => __('About the author', 'ThemeStockyard'), 
			'bio'               => '',
			'avatar_size'       => '60',
			'avatar_align'      => '',
			'read_more_text'    => __('Read more', 'ThemeStockyard'),
			'read_more_url'     => '',
			'custom_email'      => '',
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		?>
		<p>
		   <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ThemeStockyard'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('title'); ?>"  value="<?php echo esc_attr($instance['title']); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('bio'); ?>"><?php _e('Bio:', 'ThemeStockyard'); ?></label>
			<textarea name="<?php echo $this->get_field_name('bio'); ?>" class="widefat" id="<?php echo $this->get_field_id('bio'); ?>"><?php echo esc_textarea($instance['bio']); ?></textarea>
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('custom_email'); ?>"><?php _e('<a href="http://www.gravatar.com/">Gravatar</a> E-mail:', 'ThemeStockyard'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('custom_email'); ?>"  value="<?php echo esc_attr($instance['custom_email']); ?>" class="widefat" id="<?php echo $this->get_field_id('custom_email'); ?>" />
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('avatar_size'); ?>"><?php _e('Gravatar Size: (in pixels - eg. <strong>60</strong>)', 'ThemeStockyard'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('avatar_size'); ?>"  value="<?php echo esc_attr($instance['avatar_size']); ?>" class="widefat" id="<?php echo $this->get_field_id('avatar_size'); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('avatar_align'); ?>"><?php _e('Gravatar Alignment:', 'ThemeStockyard'); ?></label>
			<select name="<?php echo $this->get_field_name('avatar_align'); ?>" class="widefat" id="<?php echo $this->get_field_id('avatar_align'); ?>">
				<option value="left" <?php if($instance['avatar_align'] == "left"){ echo "selected='selected'";} ?>><?php _e('Left', 'ThemeStockyard'); ?></option>
				<option value="right" <?php if($instance['avatar_align'] == "right"){ echo "selected='selected'";} ?>><?php _e('Right', 'ThemeStockyard'); ?></option>            
			</select>
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('read_more_text'); ?>"><?php _e('Read More Text (optional):', 'ThemeStockyard'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('read_more_text'); ?>"  value="<?php echo esc_attr($instance['read_more_text']); ?>" class="widefat" id="<?php echo $this->get_field_id('read_more_text'); ?>" />
		</p>
		<p>
		   <label for="<?php echo $this->get_field_id('read_more_url'); ?>"><?php _e('Read More URL (optional):', 'ThemeStockyard'); ?></label>
		   <input type="text" name="<?php echo $this->get_field_name('read_more_url'); ?>"  value="<?php echo esc_url($instance['read_more_url']); ?>" class="widefat" id="<?php echo $this->get_field_id('read_more_url'); ?>" />
		</p>
		<?php
	}
} 

register_widget('ts_blog_author');