<?php
add_action('widgets_init', 'ts_twitter_widget');
function ts_twitter_widget(){
	register_widget('ts_twitter');
}

class ts_twitter extends WP_Widget {

	/* Widget setup */
	function ts_twitter() {

		/* Widget settings */
		$widget_ops = array( 
			'classname'   => 'twitter-widget-wrapper', 
			'description' => __('A widget that displays your latest tweets.', 'ThemeStockyard') 
		);

		/* Widget control settings */
		$control_ops = array( 
			'width'   => 250, 
			'height'  => 350, 
			'id_base' => 'twitter-widget' 
		);

		/* Create the widget */
		$this->WP_Widget('twitter-widget', '(TS) '.__('Twitter Widget', 'ThemeStockyard'), $widget_ops, $control_ops);
	}


	/* Display the widget on the screen */
	function widget($args, $instance) {
 		extract($args);

 		wp_enqueue_script('tweet');

		$title    = apply_filters('widget_title', $instance['title']);
		$username = (isset($instance['username'])) ? preg_replace("/[^a-zA-Z0-9\-_]+/", "", $instance['username']) : '';
		$number   = (isset($instance['number'])) ? $instance['number'] : 3;		
		$consumer_key = (isset($instance['consumer_key'])) ? $instance['consumer_key'] : '';
		$consumer_secret = (isset($instance['consumer_secret'])) ? $instance['consumer_secret'] : '';
		$access_token = (isset($instance['access_token'])) ? $instance['access_token'] : '';
		$access_token_secret = (isset($instance['access_token_secret'])) ? $instance['access_token_secret'] : '';
		$links_in_new_tab = (isset($instance['links_in_new_tab']) && $instance['links_in_new_tab'] == 1) ? true : false;

        echo $before_widget;
		 
		echo (trim($title)) ? $before_title . $title . $after_title : ''; 
		
		
		$last_twitter_save = get_option('ts_last_twitter_save_'.$username);
		$last_twitter_reponse = get_option('ts_last_twitter_response_'.$username);
		$last_twitter_reponse = ($last_twitter_reponse) ? json_decode($last_twitter_reponse, true) : '';
		
		if($last_twitter_save && (time() - $last_twitter_save) < 120 && $last_twitter_reponse && count($last_twitter_reponse) > 0)
		{
            //$last_twitter_reponse = json_decode($last_twitter_reponse, true);
		}
		else
		{
            $twitter_config = array(
                'consumer_key'               => $consumer_key,
                'consumer_secret'            => $consumer_secret,
                'token'                      => $access_token,
                'secret'                     => $access_token_secret,
            );
            
            $tmhOAuth = new tmhOAuth($twitter_config);
            
            $params = array(
                'count' => $number,
                'screen_name'  => $username
            );

            $code = $tmhOAuth->user_request(array(
                'method' => 'GET',
                'url' => $tmhOAuth->url("1.1/statuses/user_timeline"),
                'params' => $params
            ));

            if($code == 200) :
                $last_twitter_reponse = $tmhOAuth->response['response'];
                $last_twitter_reponse_error = $last_twitter_reponse;
                update_option('ts_last_twitter_save_'.$username, time());
                update_option('ts_last_twitter_response_'.$username, $last_twitter_reponse);
                $last_twitter_reponse = json_decode($last_twitter_reponse, true);
            else :
                //echo '<div><pre>'.$tmhOAuth->response['raw'].'</pre></div>';
            endif;
		}
		
		
		echo '<div class="ts-twitter-widget">';
		echo (count($last_twitter_reponse)) ? '<ul>' : '';
		$i = 1;
		if(is_array($last_twitter_reponse))
		{            
            foreach($last_twitter_reponse AS $tweet)
            {           
                $actual_tweet = ts_clean_tweet($tweet['text'], $links_in_new_tab);
                $urls = $tweet['entities']['urls'];
                
                foreach($urls AS $url) :
                    $seek = $url['url'];
                    $replace = $url['expanded_url'];
                    $replace_display = $url['display_url'];
                    $actual_tweet = str_replace($seek, $replace, $actual_tweet);
                    $actual_tweet = str_replace('>'.$replace.'<', '>'.$replace_display.'<', $actual_tweet);
                endforeach;
                
                echo '<li><p>'.$actual_tweet.'</p>';
                $target = ($links_in_new_tab) ? 'target="_blank"' : '';
                echo '<small><a href="'.esc_url('https://twitter.com/'.$tweet['user']['screen_name'].'/status/'.$tweet['id_str']).'" class="small" '.$target.'>'.ts_time2str($tweet['created_at']).'</a></small><i class="fa fa-twitter subtle-text-color"></i></li>';
                
                $i++;
                
                if($i > $number) break;
            }
		} 
		echo (count($last_twitter_reponse)) ? '</ul>' : '';
		echo '</div><!-- end: .ts-twitter-widget -->';
		echo $after_widget . '<!-- end: .widget -->';
  	}


	/* Update the widget settings */
	function update($new_instance, $old_instance) {

		$instance = $old_instance;

		$instance['title']       = strip_tags( $new_instance['title']);
		$instance['username']    = strip_tags( $new_instance['username']);
		$instance['number']      = strip_tags( $new_instance['number']);
		$instance['consumer_key'] = $new_instance['consumer_key'];
		$instance['consumer_secret'] = $new_instance['consumer_secret'];
		$instance['access_token'] = $new_instance['access_token'];
		$instance['access_token_secret'] = $new_instance['access_token_secret'];
		$instance['links_in_new_tab'] = $new_instance['links_in_new_tab'];

		return $instance;
	}


	/* Displays the widget settings controls on the widget panel */
	function form($instance) {

		$defaults = array( 
			'title'    => __('Twitter', 'ThemeStockyard'), 
			'number'   => 3,
			'username' => '',
			'consumer_key' => '',
			'consumer_secret' => '',
			'access_token' => '',
			'access_token_secret' => '',
			'links_in_new_tab' => ''
		);
		$instance = wp_parse_args((array) $instance, $defaults); 
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Twitter Username:', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" value="<?php echo esc_attr($instance['username']); ?>" />
		</p>

		<p>
			<input type="checkbox" id="<?php echo $this->get_field_id('links_in_new_tab'); ?>" name="<?php echo $this->get_field_name('links_in_new_tab'); ?>" <?php echo ($instance['links_in_new_tab'] == 1) ? 'checked="checked"' : ''; ?> value="1" />
			<label for="<?php echo $this->get_field_id('links_in_new_tab'); ?>"><?php _e('Open links in new tab?', 'ThemeStockyard'); ?></label>
			<small class="block"><?php _e('This includes hashtags and usernames as well', 'ThemeStockyard');?></small>
		</p>
	     
	    <p><a href="http://dev.twitter.com/apps" target="_blank"><?php _e('Find or Create your Twitter App', 'ThemeStockyard');?></a></p>
	    <p>
	 		<label for="<?php echo $this->get_field_id('number'); ?>"><?php  _e('Number of tweets:', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo esc_attr($instance['number']); ?>" />
	    </p>

		<p>
			<label for="<?php echo $this->get_field_id('consumer_key'); ?>"><?php _e('Consumer Key:', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('consumer_key'); ?>" name="<?php echo $this->get_field_name('consumer_key'); ?>" value="<?php echo esc_attr($instance['consumer_key']); ?>" />
		</p>
	     
	    <p>
	 		<label for="<?php echo $this->get_field_id('consumer_secret'); ?>"><?php  _e('Consumer Secret:', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('consumer_secret'); ?>" name="<?php echo $this->get_field_name('consumer_secret'); ?>" value="<?php echo esc_attr($instance['consumer_secret']); ?>" />
	    </p>

		<p>
			<label for="<?php echo $this->get_field_id('access_token'); ?>"><?php _e('Access Token:', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('access_token'); ?>" name="<?php echo $this->get_field_name('access_token'); ?>" value="<?php echo esc_attr($instance['access_token']); ?>" />
		</p>
	     
	    <p>
	 		<label for="<?php echo $this->get_field_id('access_token_secret'); ?>"><?php  _e('Access Token Secret:', 'ThemeStockyard'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id('access_token_secret'); ?>" name="<?php echo $this->get_field_name('access_token_secret'); ?>" value="<?php echo esc_attr($instance['access_token_secret']); ?>" />
	    </p>
	    <p><small><?php _e('<strong>Note:</strong> Tweets are cached for 2 minutes.', 'ThemeStockyard');?></small></p>
		<?php
	}

}