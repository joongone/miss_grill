<?php
add_action('widgets_init', 'ts_tab_widget');
function ts_tab_widget(){
	register_widget('ts_tab_widget');
}

class ts_tab_widget extends WP_Widget{

	/* Widget setup */
	function ts_tab_widget(){

		/* Widget settings */
		$widget_ops = array( 
			'classname'   => 'tabs-widget-wrapper', 
			'description' => __('A tabbed widget that displays popular posts, recent posts and comments.', 'ThemeStockyard') 
		);

		/* Widget control settings */
		$control_ops = array( 
			'width'   => 250, 
			'height'  => 350, 
			'id_base' => 'tab-widget' 
		);

		/* Create the widget */
		$this->WP_Widget( 'tab-widget', '(TS) '.__('Tabbed Widget', 'ThemeStockyard'), $widget_ops, $control_ops );
	}
	


	/* How to display the widget on the screen */
	function widget( $args, $instance ) {
		global $wpdb, $post, $wp_query;
		extract($args);

		$tab1  = $instance['tab1'];
		$tab2  = $instance['tab2'];
		$tab3  = $instance['tab3'];
		$crop_thumbs   = (isset($instance['crop_thumbs'])) ? $instance['crop_thumbs'] : 1;
		$count = (ctype_digit($instance['count']) && ts_number_within_range($instance['count'], 1, 20)) ? $instance['count'] : 5;
	
		echo $before_widget;
		echo '<div class="ts-tabs-widget tabs-widget shortcode-tabs simple-tabs horizontal-tabs">';

		$tab = array();
		?>	
		<div class="tab-widget">

			<ul class="tab-header clearfix">
				<li class="active"><?php echo $tab1 ?></li>
				<li><?php echo $tab2 ?></li>
				<li class="last"><?php echo $tab3 ?></li>
			</ul>

            <div class="tab-contents">
			<div  class="tab-context visible">
                <ul>
				<?php
				$temp = $wp_query;
	            $wp_query = new WP_Query();
	            $wp_query->query('showposts='.$count.'&orderby=comment_count');  
	            if($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post(); ?>
				
					<li class="post-widget clearfix">
                        <?php                        
                        $img_url = false;
                        $preview = get_post_meta($wp_query->post->ID, '_p_preview_image', true);
                        $preview_id = get_post_meta($wp_query->post->ID, '_p_preview_image_id', true);
                        if($preview && trim($preview)) :
                            $img_id = $preview_id;
                            $img_url = $preview;
                        else :
                            $size = ($crop_thumbs != 1) ? 'large' : 'thumbnail';
                            $img_id = get_post_thumbnail_id($wp_query->post->ID);
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
                            <a href="<?php echo get_permalink($wp_query->post->ID); ?>" class="thumb-link">
                                <img width="60" src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"/>
                            </a>
                        </div><!-- / div.widget-thumbnail -->
                        <?php
                        endif;
                        ?>

                        <div class="widget-context <?php echo $has_img;?>">
                            <h4><a href="<?php echo get_permalink($wp_query->post->ID); ?>"><?php the_title() ?></a></h4>
                            <small><?php the_time('F j, Y'); ?></small>
                        </div><!-- / div.widget-context -->

                    </li><!-- / div.post-widget -->

				<?php 
				endwhile; endif; $wp_query = $temp;	
			echo '</ul></div>';


			echo '<div  class="tab-context"><ul>';
				$temp = $wp_query;
	            $wp_query = new WP_Query();
	            $wp_query->query('showposts='.$count);  
	            if($wp_query->have_posts()) : while($wp_query->have_posts()) : $wp_query->the_post(); ?>
	            
					<li class="post-widget clearfix">
                        <?php                          
                        $img_url = false;
                        $preview = get_post_meta($wp_query->post->ID, '_p_preview_image', true);
                        $preview_id = get_post_meta($wp_query->post->ID, '_p_preview_image_id', true);
                        if($preview && trim($preview)) :
                            $img_id = $preview_id;
                            $img_url = $preview;
                        else :
                            $size = ($crop_thumbs != 1) ? 'large' : 'thumbnail';
                            $img_id = get_post_thumbnail_id($wp_query->post->ID);
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
                            <a href="<?php echo get_permalink($wp_query->post->ID); ?>" class="thumb-link">
                                <img width="60" src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>"/>
                            </a>
                        </div><!-- / div.widget-thumbnail -->
                        <?php
                        endif;
                        ?>

                        <div class="widget-context <?php echo $has_img;?>">
                            <h4><a href="<?php echo get_permalink($wp_query->post->ID); ?>"><?php the_title() ?></a></h4>
                            <small><?php the_time('F j, Y'); ?></small>
                        </div><!-- / div.widget-context -->

                    </li><!-- / div.post-widget -->

				<?php 
				endwhile; endif; $wp_query = $temp;		
			echo '</ul></div>';


			echo '<div class="tab-context"><ul>';
				$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved, comment_type, comment_author_url, SUBSTRING(comment_content,1,70) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $count";
				$comments = $wpdb->get_results($sql);
				foreach ($comments as $comment) { ?>

					<li class="post-widget post-widget-comment clearfix">
						<div class="widget-thumbnail">
							<a href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" title="<?php echo strip_tags($comment->comment_author); ?> <?php _e('on ', 'ThemeStockyard'); ?><?php echo esc_attr($comment->post_title); ?>" class="thumb-link"><?php echo get_avatar( $comment, '60' ); ?></a>
						</div>
						
						<div class="widget-context">
							<a href="<?php echo get_permalink($comment->ID); ?>#comment-<?php echo $comment->comment_ID; ?>" class="comm_link">
                                <h4><?php echo strip_tags($comment->comment_author); ?></h4>
                                <p>&#8220;<?php echo ts_trim_text($comment->com_excerpt, 50); ?>&#8221;</p>
                            </a>
                            <p class="small"><?php _e('on', 'ThemeStockyard');?> <a href="<?php echo get_permalink($comment->comment_post_ID); ?>" class="post-link"><?php echo ts_trim_text(get_the_title($comment->comment_post_ID), 36);?></a></p>
						</div>
					</li>
				<?php 
				}				
			echo '</ul></div>';

        wp_reset_query();
        echo '</div>';
		echo '</div>';
		echo '</div>';
		echo $after_widget;
	}
	

	/* Update the widget settings. */
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['tab1']  = $new_instance['tab1'];
		$instance['tab2']  = $new_instance['tab2'];
		$instance['tab3']  = $new_instance['tab3'];
		$instance['crop_thumbs']   = strip_tags( $new_instance['crop_thumbs']);
		$instance['count'] = $new_instance['count'];
		
		return $instance;
	}

	
	/* Displays the widget settings controls on the widget panel. */
	function form( $instance ) {
	
		$defaults = array(
			'tab1'  => 'Popular',
			'tab2'  => 'Recent',
			'tab3'  => 'Comments',
			'crop_thumbs' => 1,
			'count' => 5
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); 
		?>

		<p>
			<label for="<?php echo $this->get_field_id( 'tab1' ); ?>"><?php _e('Popular Post Title:', 'ThemeStockyard') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'tab1' ); ?>" name="<?php echo $this->get_field_name( 'tab1' ); ?>" value="<?php echo esc_attr($instance['tab1']); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link1' ); ?>"><?php _e('Recent Post Title:', 'ThemeStockyard') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'tab2' ); ?>" name="<?php echo $this->get_field_name( 'tab2' ); ?>" value="<?php echo esc_attr($instance['tab2']); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'tab2' ); ?>"><?php _e('Comments Title:', 'ThemeStockyard') ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'tab3' ); ?>" name="<?php echo $this->get_field_name( 'tab3' ); ?>" value="<?php echo esc_attr($instance['tab3']); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e('Number of Items:', 'ThemeStockyard') ?> (1 - 20)</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'tab3' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo esc_attr($instance['count']); ?>" />
		</p>
		
		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id('crop_thumbs'); ?>" name="<?php echo $this->get_field_name('crop_thumbs'); ?>" <?php echo ($instance['crop_thumbs'] == 1) ? 'checked="checked"' : ''; ?> value="1" />
			<label for="<?php echo $this->get_field_id('crop_thumbs'); ?>"><?php _e('Uniformly crop "Featured Image" thumbnails', 'ThemeStockyard'); ?></label>
		</p>		
	
	<?php
	}
}