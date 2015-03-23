<?php
/*---------------------------------------------------------------------------------*/
/* Social Icons Widget */
/*---------------------------------------------------------------------------------*/

class ts_social_icons_widget extends WP_Widget {

	function ts_social_icons_widget() {
		$widget_ops = array(
            'classname' => 'ts-social-icons-widget',
            'description' => __('This widget shows linked social icons.', 'ThemeStockyard') 
        );
		parent::WP_Widget(false, '(TS) '.__('Social Icons', 'ThemeStockyard'),$widget_ops);      
	}

	function widget($args, $instance) 
	{
        extract($args);
		$label          = $instance['label'];
		$facebook       = $instance['facebook'];
		$twitter        = $instance['twitter'];	
		$pinterest      = $instance['pinterest'];
		$google_plus      = $instance['google_plus'];
		$instagram      = $instance['instagram'];
		$flickr      = $instance['flickr'];
		$youtube      = $instance['youtube'];
		$vimeo      = $instance['vimeo'];
		$tumblr      = $instance['tumblr'];
		$vk      = (isset($instance['vk'])) ? $instance['vk'] : '';
		$behance      = $instance['behance'];
		$dribbble      = $instance['dribbble'];
		$soundcloud      = $instance['soundcloud'];
		$rss      = $instance['rss'];

        echo $before_widget;
        
        echo '<div class="inner social-icons-widget-style">';

		if(trim($label)) {
			echo $before_title.$label.$after_title;
        }
        
        $output  = '<div class="social social-fa-icons">';
        $output .= ts_output_social_icon('facebook', '', $facebook);
        $output .= ts_output_social_icon('twitter', '', $twitter);
        $output .= ts_output_social_icon('pinterest', '', $pinterest);
        $output .= ts_output_social_icon('google_plus', '', $google_plus);
        $output .= ts_output_social_icon('instagram', '', $instagram);
        $output .= ts_output_social_icon('flickr', '', $flickr);
        $output .= ts_output_social_icon('youtube', '', $youtube);
        $output .= ts_output_social_icon('vimeo', '', $vimeo);
        $output .= ts_output_social_icon('vk', '', $vk);
        $output .= ts_output_social_icon('tumblr', '', $tumblr);
        $output .= ts_output_social_icon('behance', '', $behance);
        $output .= ts_output_social_icon('dribbble', '', $dribbble);
        $output .= ts_output_social_icon('soundcloud', '', $soundcloud);
        $output .= ts_output_social_icon('rss', '', $rss);
        $output .= '</div>';
        
        echo $output;        
		
		echo '</div>';
		
		echo $after_widget;

	}

	function update($new_instance, $old_instance) {                
		$new_instance = (array) $new_instance;

        $instance['label']   = $new_instance['label'];
        $instance['facebook'] = $new_instance['facebook'];
        $instance['twitter'] = $new_instance['twitter'];
		$instance['pinterest'] = $new_instance['pinterest'];
		$instance['google_plus'] = $new_instance['google_plus'];
		$instance['instagram'] = $new_instance['instagram'];
		$instance['flickr'] = $new_instance['flickr'];
		$instance['youtube'] = $new_instance['youtube'];
		$instance['vimeo'] = $new_instance['vimeo'];
		$instance['vk'] = (isset($new_instance['vk'])) ? $new_instance['vk'] : '';
		$instance['tumblr'] = $new_instance['tumblr'];
		$instance['behance'] = $new_instance['behance'];
		$instance['dribbble'] = $new_instance['dribbble'];
		$instance['soundcloud'] = $new_instance['soundcloud'];
		$instance['rss'] = $new_instance['rss'];

        return $instance;
	}

	function form($instance) {        
		
		$defaults = array( 
            'label'         => __("Social Links...", 'ThemeStockyard'),
			'facebook'      => '', 
			'twitter'       => '',
			'pinterest' => '',
			'google_plus' => '',
			'instagram' => '',
			'flickr' => '',
			'youtube' => '',
			'vimeo' => '',
			'vk' => '',
			'tumblr' => '',
			'behance' => '',
			'dribbble' => '',
			'soundcloud' => '',
			'rss' => '',
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		?>
        <p>
            <label for="<?php echo $this->get_field_id('label'); ?>"><?php _e('Label (optional):', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('label'); ?>" value="<?php echo esc_attr($instance['label']); ?>" class="widefat" id="<?php echo $this->get_field_id('label'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook URL:', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('facebook'); ?>" value="<?php echo esc_attr($instance['facebook']); ?>" class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter URL:', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('twitter'); ?>" value="<?php echo esc_attr($instance['twitter']); ?>" class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('pinterest'); ?>"><?php _e('Pinterest URL:', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('pinterest'); ?>" value="<?php echo esc_attr($instance['pinterest']); ?>" class="widefat" id="<?php echo $this->get_field_id('pinterest'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('google_plus'); ?>"><?php _e('Google+ URL:', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('google_plus'); ?>" value="<?php echo esc_attr($instance['google_plus']); ?>" class="widefat" id="<?php echo $this->get_field_id('google_plus'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('instagram'); ?>"><?php _e('Instagram URL:', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('instagram'); ?>" value="<?php echo esc_attr($instance['instagram']); ?>" class="widefat" id="<?php echo $this->get_field_id('instagram'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('flickr'); ?>"><?php _e('Flickr URL:', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('flickr'); ?>" value="<?php echo esc_attr($instance['flickr']); ?>" class="widefat" id="<?php echo $this->get_field_id('flickr'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('Youtube URL:', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('youtube'); ?>" value="<?php echo esc_attr($instance['youtube']); ?>" class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('vimeo'); ?>"><?php _e('Vimeo URL:', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('vimeo'); ?>" value="<?php echo esc_attr($instance['vimeo']); ?>" class="widefat" id="<?php echo $this->get_field_id('vimeo'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('vk'); ?>"><?php _e('VK URL:', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('vk'); ?>" value="<?php echo esc_attr($instance['vk']); ?>" class="widefat" id="<?php echo $this->get_field_id('vk'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('tumblr'); ?>"><?php _e('Tumblr URL:', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('tumblr'); ?>" value="<?php echo esc_attr($instance['tumblr']); ?>" class="widefat" id="<?php echo $this->get_field_id('tumblr'); ?>" />
        </p>
        <p>
			<label for="<?php echo $this->get_field_id('behance'); ?>"><?php _e('Behance URL:', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('behance'); ?>" name="<?php echo $this->get_field_name('behance'); ?>" value="<?php echo esc_attr($instance['behance']); ?>" />
		</p>
	     
	    <p>
	 		<label for="<?php echo $this->get_field_id('dribbble'); ?>"><?php  _e('Dribbble URL:', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('dribbble'); ?>" name="<?php echo $this->get_field_name('dribbble'); ?>" value="<?php echo esc_attr($instance['dribbble']); ?>" />
	    </p>

		<p>
			<label for="<?php echo $this->get_field_id('soundcloud'); ?>"><?php _e('SoundCloud URL:', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('soundcloud'); ?>" name="<?php echo $this->get_field_name('soundcloud'); ?>" value="<?php echo esc_attr($instance['soundcloud']); ?>" />
		</p>
	     
	    <p>
	 		<label for="<?php echo $this->get_field_id('rss'); ?>"><?php  _e('RSS URL:', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('rss'); ?>" name="<?php echo $this->get_field_name('rss'); ?>" value="<?php echo esc_attr($instance['rss']); ?>" />
	    </p>
	    <p><small><?php _e('(use the <strong>[rss_url]</strong> shortcode for the default RSS url)', 'ThemeStockyard');?></small></p>
        <?php
	}
} 

register_widget('ts_social_icons_widget');