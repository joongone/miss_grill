<?php
add_action('widgets_init', 'ts_google_map_widget');
function ts_google_map_widget(){
	register_widget('ts_google_map');
}

class ts_google_map extends WP_Widget {

	/* Widget setup */
	function ts_google_map() {

		/* Widget settings */
		$widget_ops = array( 
			'classname'   => 'google-map-widget', 
			'description' => __('Google Map', 'ThemeStockyard') 
		);

		/* Widget control settings */
		$control_ops = array( 
			'width'   => 250, 
			'height'  => 350, 
			'id_base' => 'google-map-widget' 
		);

		/* Create the widget */
		$this->WP_Widget('google-map-widget', '(TS) '.__('Google Map Widget', 'ThemeStockyard'), $widget_ops, $control_ops);
	}


	/* Display the widget on the screen */
	function widget($args, $instance) {
 		extract($args);
 		
 		$map_ok = true;
        
        wp_enqueue_script('googlemaps');

		$title       = apply_filters('widget_title', $instance['title']);
		$address     = $instance['address'];
		$coordinates = $instance['coordinates'];
		$zoom        = $instance['zoom'];
		$height      = preg_replace("/[^0-9]/","",$instance['height']); if ( !$height ) $height = 250;

        if(trim($address) || trim($coordinates))
        {
            echo $before_widget;

            if ($title) echo $before_title . $title . $after_title;  
            

            if (!$address) {
                _e('Address was not specified', 'ThemeStockyard');
                return false;
            }
            
            if (!$coordinates) {
                $coordinates = aq_get_map_coordinates($address);
                if (is_array($coordinates)) {
                    $coordinates = $coordinates['lat'] . ',' . $coordinates['lng'];
                } else {
                    $map_ok = false;
                    echo $coordinates;
                    //return false;
                }
            }
            
            if($map_ok)
            {
                $map_id_num = rand(1,100);
                echo '<div id="map_canvas_' . esc_attr($map_id_num) . '_wrap" class="flexible-map" style="width:100%;height:' . esc_attr($height) . 'px" data-height="'.$height.'px">';
                    echo '<input class="location" type="hidden" value="' . esc_attr($address) . '" />';
                    echo '<input class="coordinates" type="hidden" value="' . esc_attr($coordinates) . '" />';
                    echo '<input class="zoom" type="hidden" value="' . esc_attr($zoom) . '" />';
                    echo '<div id="map_canvas_' . esc_attr($map_id_num) . '" class="map_canvas" style="width:100%;height:' . esc_attr($height) . 'px">&nbsp;</div>';
                echo '</div>';
            }


            echo $after_widget;
        }
	}


	/* Update the widget settings */
	function update($new_instance, $old_instance) {

		$instance = $old_instance;
		
		$instance['title']       = strip_tags( $new_instance['title']);
		$instance['address']     = strip_tags( $new_instance['address']);;
		$instance['coordinates'] = strip_tags( $new_instance['coordinates']);;
		$instance['zoom']        = strip_tags( $new_instance['zoom']);;
		$instance['height']      = strip_tags( $new_instance['height']);;

		return $instance;
	}


	/* Displays the widget settings controls on the widget panel */
	function form($instance) {

		$defaults = array( 
			'title'    => __('Google Map', 'ThemeStockyard'), 
			'address'     => '',
            'coordinates' => '',
            'zoom'        => '15',
            'height'      => '250px',
		);
		
		$instance = wp_parse_args((array) $instance, $defaults); 
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>

	 	<p>
			<label for="<?php echo $this->get_field_id('address'); ?>"><?php _e('Address:', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('address'); ?>" name="<?php echo $this->get_field_name('address'); ?>" value="<?php echo esc_attr($instance['address']); ?>" />
	 	</p>
     
     	<p>
     		<label for="<?php echo $this->get_field_id('coordinates'); ?>"><?php _e('Coordinates (optional):', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('coordinates'); ?>" name="<?php echo $this->get_field_name('coordinates'); ?>" value="<?php echo esc_attr($instance['coordinates']); ?>" />
     	</p>

     	<p>
     		<label for="<?php echo $this->get_field_id('zoom'); ?>"><?php _e('Zoom Level:', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('zoom'); ?>" name="<?php echo $this->get_field_name('zoom'); ?>" value="<?php echo esc_attr($instance['zoom']); ?>" />
     	</p>

     	<p>
     		<label for="<?php echo $this->get_field_id('height'); ?>"><?php _e('Map Height (in pixels):', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" value="<?php echo esc_attr($instance['height']); ?>" />
     	</p>
		<?php
	}

}