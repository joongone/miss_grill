<?php
/*---------------------------------------------------------------------------------*/
/* Follow RSS Widget */
/*---------------------------------------------------------------------------------*/

class ts_facebook_like_button_widget extends WP_Widget {

	function ts_facebook_like_button_widget() {
		$widget_ops = array(
            'classname' => 'facebook-like-button-widget',
            'description' => __('This widget shows a Facebook &#8220;Like Button&#8221;.', 'ThemeStockyard') 
        );
		parent::WP_Widget(false, '(TS) '.__('Facebook Like Button', 'ThemeStockyard'),$widget_ops);      
	}

	function widget($args, $instance) 
	{
        extract($args);
		$url            = (isset($instance['url']) && trim($instance['url'])) ? $instance['url'] : ts_full_url();
		$label          = $instance['label'];
		$description    = $instance['description'];

        echo $before_widget;
        
        echo '<div class="inner">';

		if(trim($label)) :
			echo $before_title.$label.$after_title;
        endif;
                
        $output  = '<div><iframe src="//www.facebook.com/plugins/like.php?href='.urlencode($url);
        $output .='&amp;send=false&amp;layout=standard&amp;width=300&amp;show_faces=false';
        $output .= '&amp;font&amp;colorscheme=light&amp;action=like&amp;height=35" scrolling="no"';
        $output .= ' frameborder="0" style="border:none; overflow:hidden; width:300px; height:35px;"';
        $output .= ' allowTransparency="true"></iframe></div>';
        
        echo $output;
        
        echo (isset($description) && trim($description)) ? '<p class="description">'.$description.'</p>' : '';
		
		echo '</div>';
		
		echo $after_widget;

	}

	function update($new_instance, $old_instance) {                
		$new_instance = (array) $new_instance;

        $instance['url'] = strip_tags( $new_instance['url']);
        $instance['label']   = strip_tags( $new_instance['label']);
        $instance['description'] = strip_tags($new_instance['description']);

        return $instance;
	}

	function form($instance) {        
		
		$defaults = array( 
            'label'    => __("Like us on Facebook!", 'ThemeStockyard'),
			'url'      => '', 
			'description' => __("Join us on Facebook! We don't bite... much.", 'ThemeStockyard'),
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		?>
        <p>
            <label for="<?php echo $this->get_field_id('label'); ?>"><?php _e('Label (optional):', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('label'); ?>" value="<?php echo esc_attr($instance['label']); ?>" class="widefat" id="<?php echo $this->get_field_id('label'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('URL (optional):', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('url'); ?>" value="<?php echo esc_url($instance['url']); ?>" class="widefat" id="<?php echo $this->get_field_id('url'); ?>" />
            <span style="font-size:11px;color:#808080;">Leave blank to have the like button default to the current page. Alernatively, you can put your Facebook page URL here.</span>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description (optional):', 'ThemeStockyard'); ?></label>
            <textarea name="<?php echo $this->get_field_name('description'); ?>" class="widefat" id="<?php echo $this->get_field_id('description'); ?>"><?php echo esc_textarea($instance['description']); ?></textarea>
        </p>
        <?php
	}
} 

register_widget('ts_facebook_like_button_widget');