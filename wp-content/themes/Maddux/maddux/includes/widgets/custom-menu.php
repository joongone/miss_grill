<?php
add_action('widgets_init', 'ts_custom_menu');
function ts_custom_menu(){
	register_widget('ts_custom_menu');
}

class ts_custom_menu extends WP_Widget {

	/* Widget setup */
	function  ts_custom_menu() {

		/* Widget settings */
		$widget_ops = array( 
			'classname'   => 'ts-custom-menu-widget', 
			'description' => __('Display a custom menu with style(s)', 'ThemeStockyard') 
		);

		/* Widget control settings */
		$control_ops = array( 
			'width'   => 250, 
			'height'  => 350, 
			'id_base' => 'ts-custom-menu' 
		);

		/* Create the widget */
		$this->WP_Widget('ts-custom-menu', '(TS) '.__('Custom Menu', 'ThemeStockyard'), $widget_ops, $control_ops);
	}


	/* Display the widget on the screen */
	function widget($args, $instance) {
		extract($args);

		$title = apply_filters('Custom Menu', $instance['title'] );
		$style   = $instance['style'];
		$menu   = $instance['menu'];
        
        if($menu)
        {
            echo $before_widget;
             
            echo (trim($title)) ? $before_title . $title . $after_title : '';
            echo '<div class="ts-custom-menu-wrap ts-menu-style-'.esc_attr($style).'">';

            $nav_menu_options = array(
                'menu'              => $menu
            );
            
            wp_nav_menu($nav_menu_options);
            
            echo '</div>';
            echo $after_widget;
		}
	}


	/* Update the widget settings */
	function update($new_instance, $old_instance) {

		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['style']   = strip_tags($new_instance['style']);
		$instance['menu']   = strip_tags( $new_instance['menu']);

		return $instance;
	}


	/* Displays the widget settings controls on the widget panel */
	function form($instance) {

		$defaults = array( 
			'title' => __('Custom Menu', 'ThemeStockyard'), 
			'style'   => '',
			'menu' => '',
		);
		$instance = wp_parse_args((array) $instance, $defaults); 
		
		$menus = wp_get_nav_menus();
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('style'); ?>"><?php _e('Style:', 'ThemeStockyard'); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('style'); ?>" name="<?php echo $this->get_field_name('style'); ?>">
                <option value="plain" <?php echo selected($instance['style'], 'plain', false);?>>Plain</option>
                <option value="carets" <?php echo selected($instance['style'], 'carets', false);?>>Carets</option>
                <option value="borders" <?php echo selected($instance['style'], 'borders', false);?>>Borders</option>
			</select>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('menu'); ?>"><?php _e('Chose a menu:', 'ThemeStockyard'); ?></label>
			<select class="widefat" id="<?php echo $this->get_field_id('menu'); ?>" name="<?php echo $this->get_field_name('menu'); ?>">
                <option value="">— <?php _e('Select', 'ThemeStockyard');?> —</option>
				<?php
				foreach ($menus as $menu) {
					echo '<option value="' . esc_attr($menu->term_id) . '"' . selected($instance['menu'], $menu->term_id, false) . '>' . $menu->name . "</option>\n";
				} 
				?>
			</select>
		</p>
	<?php
	}
}