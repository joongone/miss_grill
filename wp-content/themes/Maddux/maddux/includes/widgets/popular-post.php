<?php
add_action('widgets_init', 'ts_popular_widget');
function ts_popular_widget(){
	register_widget('ts_popular_post');
}

class ts_popular_post extends WP_Widget {

	/* Widget setup */
	function  ts_popular_post() {

		/* Widget settings */
		$widget_ops = array( 
			'classname'   => 'popular-posts-widget', 
			'description' => __('A widget that show popular posts', 'ThemeStockyard') 
		);

		/* Widget control settings */
		$control_ops = array( 
			'width'   => 250, 
			'height'  => 350, 
			'id_base' => 'post-popular' 
		);

		/* Create the widget */
		$this->WP_Widget('post-popular', '(TS) '.__('Popular Posts', 'ThemeStockyard'), $widget_ops, $control_ops);
	}


	/* Display the widget on the screen */
	function widget($args, $instance) {
		extract($args);

		$title = apply_filters('Popular Posts', $instance['title'] );
		$num   = $instance['num'];
		$crop_thumbs   = (isset($instance['crop_thumbs'])) ? $instance['crop_thumbs'] : 1;

		echo $before_widget;
		 
		echo (trim($title)) ? $before_title . $title . $after_title : '';
		echo '<ul>';

		$custom_posts = get_posts('showposts='.$num.'&orderby=comment_count'); 

		if (!empty($custom_posts)) { 
			foreach ($custom_posts as $custom_post) { 
			?>
				<li class="post-widget clearfix">
                    <?php
                    $img_url = false;
                    $preview = get_post_meta($custom_post->ID, '_p_preview_image', true);
                    $preview_id = get_post_meta($custom_post->ID, '_p_preview_image_id', true);
                    if($preview && trim($preview)) :
                        $img_id = $preview_id;
                        $img_url = $preview;
                    else :
                        $size = ($crop_thumbs != 1) ? 'large' : 'thumbnail';
                        $img_id = get_post_thumbnail_id($custom_post->ID);
                        $photo = wp_get_attachment_image_src($img_id, $size);
                        $img_url = (isset($photo[0])) ? $photo[0] : '';
                    endif;
                    
                    if($img_url) :
                        $height  = ($crop_thumbs != 1) ? 0 : 60;
                        $img_url = aq_resize($img_url, 80, $height, true, true, true, $img_id);
                    endif;
                    
                    $has_img = ($img_url) ? 'has-img' : '';
                    if($img_url) :
                    ?>
					<div class="widget-thumbnail">
						<a href="<?php echo get_permalink($custom_post->ID); ?>" class="thumb-link">
                            <img width="60" src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($custom_post->post_title); ?>"/>
						</a>
					</div><!-- / div.widget-thumbnail -->
					<?php
					endif;
					?>

					<div class="widget-context <?php echo esc_attr($has_img);?>">
						<h4><a href="<?php echo get_permalink($custom_post->ID); ?>"><?php echo $custom_post->post_title; ?></a></h4>
						<small><?php echo get_the_time('F j, Y', $custom_post->ID); ?></small>
					</div><!-- / div.widget-context -->

				</li><!-- / div.post-widget -->
			<?php 
			}
		}
        wp_reset_query();
        echo '</ul>';
		echo $after_widget;
	}


	/* Update the widget settings */
	function update($new_instance, $old_instance) {

		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['num']   = strip_tags($new_instance['num']);
		$instance['crop_thumbs']   = strip_tags( $new_instance['crop_thumbs']);

		return $instance;
	}


	/* Displays the widget settings controls on the widget panel */
	function form($instance) {

		$defaults = array( 
			'title' => __('Popular Posts', 'ThemeStockyard'), 
			'num'   => '5',
			'crop_thumbs' => '1',
		);
		$instance = wp_parse_args((array) $instance, $defaults); ?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('num'); ?>"><?php _e('Show Count', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('num'); ?>" name="<?php echo $this->get_field_name('num'); ?>" value="<?php echo esc_attr($instance['num']); ?>" />
		</p>
		
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id('crop_thumbs'); ?>" name="<?php echo $this->get_field_name('crop_thumbs'); ?>" <?php echo ($instance['crop_thumbs'] == 1) ? 'checked="checked"' : ''; ?> value="1" />
			<label for="<?php echo $this->get_field_id('crop_thumbs'); ?>"><?php _e('Uniformly crop "Featured Image" thumbnails', 'ThemeStockyard'); ?></label>
		</p>
	<?php
	}
}