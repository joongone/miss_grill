<?php
/*---------------------------------------------------------------------------------*/
/* Follow RSS Widget */
/*---------------------------------------------------------------------------------*/

class ts_infobox_widget extends WP_Widget {

	function ts_infobox_widget() {
		$widget_ops = array(
            'classname' => 'ts-infobox-widget',
            'description' => __('This widget is essentially a text widget with an optional icon attached.', 'ThemeStockyard') 
        );
		parent::WP_Widget(false, '(TS) '.__('Info Box', 'ThemeStockyard'),$widget_ops);      
	}

	function widget($args, $instance) { 
        extract($args);
		$icon           = (isset($instance['icon'])) ? $instance['icon'] : '';
		$icon_color     = (isset($instance['icon_color'])) ? $instance['icon_color'] : '';
		$label          = (isset($instance['label'])) ? $instance['label'] : '';
		$title          = (isset($instance['title'])) ? $instance['title'] : '';
		$description    = (isset($instance['description'])) ? $instance['description'] : '';
		$url            = (isset($instance['url'])) ? $instance['url'] : '';    

        echo $before_widget;

		if(trim($label))
			echo $before_title.$label.$after_title;
        
        $infobox_class = ($url) ? 'has-url' : 'has-no-url';
        $infobox_class .= ($icon) ? ' has-icon' : ' has-icon';
        
        echo '<div class="infobox '.$infobox_class.'">';
        echo (trim($url)) ? '<a href="'.esc_url($url).'" class="link">' : '<div class="link">';
        echo (trim($icon)) ? '<i class="'.ts_fontawesome_class($icon).'" style="background:'.esc_attr($icon_color).'"></i>' : '';
        echo (trim($title)) ? '<h4 class="sp1">'.$title.'</h4>' : '';
        echo (trim($description)) ? '<span class="sp2 small">'.$description.'</span>' : '';
        echo (trim($url)) ? '</a>' : '</div>';
        echo '</div>';
		
		echo $after_widget;

	}

	function update($new_instance, $old_instance) {                
		$new_instance = (array) $new_instance;

        $instance['label'] = strip_tags( $new_instance['label']);
        $instance['icon']   = strip_tags( $new_instance['icon']);
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['description'] = strip_tags( $new_instance['description']);
        $instance['url']   = strip_tags( $new_instance['url']);
        $instance['icon_color'] = strip_tags($new_instance['icon_color']);

        return $instance;
	}

	function form($instance) {  
        global $smof_data;
        
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        
        $icon_bg_color = ts_option_vs_default('primary_color', '#000000');
		
		$defaults = array( 
            'label'         => '',
			'icon'          => '', 
			'title'         => '',
			'description'   => '', 
			'url'           => '',
			'icon_color'    => $icon_bg_color,
		);
		$instance = wp_parse_args((array) $instance, $defaults);
		?>
		<script type="text/javascript">
		jQuery(document).ready(function($){
            $('.color-picker-field').not('.wp-color-picker').wpColorPicker();
        });
		</script>
        <p>
            <label for="<?php echo $this->get_field_id('icon'); ?>"><?php _e('Icon (optional):', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('icon'); ?>" value="<?php echo esc_attr($instance['icon']); ?>" class="widefat" id="<?php echo $this->get_field_id('icon'); ?>" />
            <span style="font-size:11px;color:#808080;">Use a Font Awesome icon code if you wish. <a href="http://fortawesome.github.io/Font-Awesome/" target="_blank">Refer here</a> (scroll down) for a list of available options.</span>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('icon_color'); ?>"><?php _e('Icon Background Color (optional):', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('icon_color'); ?>" value="<?php echo esc_attr($instance['icon_color']); ?>" class="ts-color-picker-field color-picker-field" id="<?php echo $this->get_field_id('icon_color'); ?>" />
            <span style="font-size:11px;color:#808080;display:block;"><strong>Note:</strong> The foreground color is always white</span>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('label'); ?>"><?php _e('Label (optional):', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('label'); ?>" value="<?php echo esc_attr($instance['label']); ?>" class="widefat" id="<?php echo $this->get_field_id('label'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title (optional):', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('description'); ?>"><?php _e('Description:', 'ThemeStockyard'); ?></label>
            <textarea name="<?php echo $this->get_field_name('description'); ?>" class="widefat" id="<?php echo $this->get_field_id('description'); ?>"><?php echo esc_attr($instance['description']); ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('url'); ?>"><?php _e('Link URL (optional):', 'ThemeStockyard'); ?></label>
            <input type="text" name="<?php echo $this->get_field_name('url'); ?>" value="<?php echo esc_url($instance['url']); ?>" class="widefat" id="<?php echo $this->get_field_id('url'); ?>" />
        </p>
        <?php
	}
} 

register_widget('ts_infobox_widget');