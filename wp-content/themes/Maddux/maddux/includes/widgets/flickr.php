<?php
add_action('widgets_init', 'ts_flickr_widget');
function ts_flickr_widget(){
	register_widget('ts_flickr');
}

class ts_flickr extends WP_Widget {

	/* Widget setup */
	function ts_flickr() {

		/* Widget settings */
		$widget_ops = array( 
			'classname'   => 'flickr-widget', 
			'description' => __('A widget that displays your Flickr photos.', 'ThemeStockyard') 
		);

		/* Widget control settings */
		$control_ops = array( 
			'width'   => 250, 
			'height'  => 350, 
			'id_base' => 'flickr-widget' 
		);

		/* Create the widget */
		$this->WP_Widget('flickr-widget', '(TS) '.__('Flickr Widget', 'ThemeStockyard'), $widget_ops, $control_ops);
	}


	/* Display the widget on the screen */
	function widget($args, $instance) {
 		extract($args);

 		wp_enqueue_script('jflickrfeed');
 		wp_enqueue_script('prettyPhoto');

		$title    = apply_filters('widget_title', $instance['title']);
		$flickrid = $instance['flickrid'];
		$number   = $instance['number'];

		echo $before_widget;

		if ($title) echo $before_title . $title . $after_title; 
		?>
		<div class="flickr">
            <ul id="<?php echo esc_attr($args['widget_id']); ?>" class="flickr-widget"></ul>            
            <div><script type="text/javascript">jQuery(document).ready(function($){jQuery('#<?php echo esc_js($args['widget_id']); ?>').jflickrfeed({limit: <?php echo absint($number); ?>,qstrings: { id: '<?php echo esc_js($flickrid); ?>' }}, function(data){jQuery("a[class^='mfp']").magnificPopup()})});</script></div>
		</div>

		<?php
        echo $after_widget;
	}


	/* Update the widget settings */
	function update($new_instance, $old_instance) {

		$instance = $old_instance;
		
		$instance['title']    = strip_tags( $new_instance['title']);
		$instance['flickrid'] = strip_tags( $new_instance['flickrid']);
		$instance['number']   = strip_tags( $new_instance['number']);

		return $instance;
	}


	/* Displays the widget settings controls on the widget panel */
	function form($instance) {

		$defaults = array( 
			'title'    => __('Flickr', 'ThemeStockyard'), 
			'number'   => '6',
			'flickrid' => ''
		);
		
		$instance = wp_parse_args((array) $instance, $defaults); 
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>

	 	<p>
			<label for="<?php echo $this->get_field_id('flickrid'); ?>"><?php _e('Your Flickr User ID:', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('flickrid'); ?>" name="<?php echo $this->get_field_name('flickrid'); ?>" value="<?php echo esc_attr($instance['flickrid']); ?>" />
	 	</p>
     
     	<p>
     		<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of Photos:', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo esc_attr($instance['number']); ?>" />
     	</p>
     	<p><?php _e('<strong>Don\'t know your Flickr ID?</strong> <br/>Visit <a href="http://idgettr.com">idgettr</a> to find out what it is.', 'ThemeStockyard');?></p>
		<?php
	}

}