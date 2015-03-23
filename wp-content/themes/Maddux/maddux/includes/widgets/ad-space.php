<?php
/*---------------------------------------------------------------------------------*/
/* Adspace Widget */
/*---------------------------------------------------------------------------------*/

class ts_ad_widget extends WP_Widget {

	function ts_ad_widget() {
		$widget_ops = array(
            'classname' => 'adspace-widget',
            'description' => __('Use this widget to add any type of ad.', 'ThemeStockyard') 
        );
		parent::WP_Widget(false, '(TS) '.__('Adspace', 'ThemeStockyard'),$widget_ops);      
	}

	function widget($args, $instance) { 
        extract($args);
		$title  = (isset($instance['title'])) ? $instance['title'] : '';
		$adcode = (isset($instance['adcode'])) ? $instance['adcode'] : '';
		$image  = (isset($instance['image'])) ? $instance['image'] : '';
		$href   = (isset($instance['href'])) ? $instance['href'] : '';
		$alt    = (isset($instance['alt'])) ? $instance['alt'] : '';

        echo $before_widget;

		if(trim($title))
			echo $before_title.$title.$after_title;

		if(trim($adcode)) :
            echo '<div class="adspace">'.$adcode.'</div>';
		else :
            $open = (trim($href)) ? '<a href="'.esc_url($href).'">' : '';
            $close = (trim($href)) ? '</a>' : '';
            echo '<div class="adspace">'.$open.'<img src="'.esc_url($image).'" alt="'.esc_attr($alt).'" />'.$close.'</div>';
        endif;
		
		echo $after_widget;

	}

	function update($new_instance, $old_instance) {                
		$new_instance = (array) $new_instance;

        $instance['title'] = strip_tags( $new_instance['title']);
        if (current_user_can('unfiltered_html')) {
			$instance['adcode'] =  $new_instance['adcode'];
		} else {
			$instance['adcode'] = stripslashes(wp_filter_post_kses( addslashes($new_instance['adcode'])));
		}
        $instance['image'] = strip_tags($new_instance['image']);
        $instance['href']   = strip_tags( $new_instance['href']);
        $instance['alt'] = strip_tags( $new_instance['alt']);

        return $instance;
	}

	function form($instance) {        
		$title  = (isset($instance['title'])) ? $instance['title'] : '';
		$adcode = (isset($instance['adcode'])) ? $instance['adcode'] : '';
		$image  = (isset($instance['image'])) ? $instance['image'] : '';
		$href   = (isset($instance['href'])) ? $instance['href'] : '';
		$alt    = (isset($instance['alt'])) ? $instance['alt'] : '';
		?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (optional):', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>
		<p>
            <label for="<?php echo $this->get_field_id('adcode'); ?>"><?php _e('Ad Code:', 'ThemeStockyard'); ?></label>
            <textarea name="<?php echo $this->get_field_name('adcode'); ?>" class="widefat" id="<?php echo $this->get_field_id('adcode'); ?>"><?php echo esc_textarea($adcode); ?></textarea>
        </p>
        <p><strong>or</strong></p>
        <p>
            <label for="<?php echo $this->get_field_id('image'); ?>"><?php _e('Image Url:', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('image'); ?>" value="<?php echo esc_url($image); ?>" class="widefat" id="<?php echo $this->get_field_id('image'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('href'); ?>"><?php _e('Link URL (optional):', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('href'); ?>" value="<?php echo esc_url($href); ?>" class="widefat" id="<?php echo $this->get_field_id('href'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('alt'); ?>"><?php _e('Alt text (optional):', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('alt'); ?>" value="<?php echo esc_attr($alt); ?>" class="widefat" id="<?php echo $this->get_field_id('alt'); ?>" />
        </p>
        <?php
	}
} 

register_widget('ts_ad_widget');