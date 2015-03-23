<?php
/*-----------------------------------------------------------------------------------*/
/* FYI: The Custom Metaboxes init.php file is loaded at the bottom of this page */
/* 
/* Also, get_post_meta() seems to return values as a string even when the saved value is 0. 
/* Try to avoid zeros (or booleans more generally), and just adapt to "yes", "no". :(
/*-----------------------------------------------------------------------------------*/
function ts_load_metaboxes() 
{ 
    /*-----------------------------------------------------------------------------------*/
    /* PAGE METABOX */
    /*-----------------------------------------------------------------------------------*/

	add_filter ('cmb_meta_boxes', 'cmb_page_metaboxes');
	function cmb_page_metaboxes(array $meta_boxes) 
	{
        global $wpdb;
        
        /*** begin: helper variables ***/
        $cmb_slider_count = array();
        for($i = 1; $i <= 20; $i++) {
            $cmb_slider_count[] = array('name'=>$i, 'value'=>$i);
        }        
        
        $ts_cmb_categories 		= array(); 
        $ts_cmb_categories_obj 	= get_categories('hide_empty=0');
        foreach ($ts_cmb_categories_obj as $cmb_cat) {
            $ts_cmb_categories[$cmb_cat->term_id] = $cmb_cat->cat_name;
        }        
        
        $cmb_bg_repeat      = array(
                                array("name"=>"repeat", "value"=>"repeat"),
                                array("name"=>"no-repeat", "value"=>"no-repeat"),
                                array("name"=>"repeat-x", "value"=>"repeat-x"),
                                array("name"=>"repeat-y", "value"=>"repeat-y"),
                            );
                                
        $cmb_bg_pos 		= array(
                                array("name"=>"top left", "value"=>"top left"),
                                array("name"=>"top center", "value"=>"top center"),
                                array("name"=>"top right", "value"=>"top right"),
                                array("name"=>"center left", "value"=>"center left"),
                                array("name"=>"center center", "value"=>"center center"),
                                array("name"=>"center right", "value"=>"center right"),
                                array("name"=>"bottom left", "value"=>"bottom left"),
                                array("name"=>"bottom center", "value"=>"bottom center"),
                                array("name"=>"bottom right", "value"=>"bottom right"),
                            );
        
        $ts_rev_sliders = array();
        $ts_rev_sliders[] = array('name'=>__('[none]','ThemeStockyard'), 'value'=>'');
        if(function_exists('rev_slider_shortcode')) {
            $get_sliders = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'revslider_sliders');
            if($get_sliders) {
                foreach($get_sliders as $slider) {
                    $ts_rev_sliders[] = array('name'=>$slider->title, 'value'=>$slider->alias);
                }
            }
        }
        
        $ts_slider_type_options = array(
            array('name' => __('[none]', 'ThemeStockyard'), 'value' => ''),
            array('name' => __('Carousel Slider', 'ThemeStockyard'), 'value' => 'carousel'),
            array('name' => __('Flexslider', 'ThemeStockyard'),  'value' => 'flex'),
        );
        if(function_exists('rev_slider_shortcode')) {
            $ts_slider_type_options[] = array('name' => __('Slider Revolution', 'ThemeStockyard'),  'value' => 'rev');
        }
        /*** end: helper variables ***/
	    
		$prefix = '_page_';

		$meta_boxes[] = array(
			'id'         => 'page_metabox',
			'title'      => __('General Page Settings', 'ThemeStockyard'),
			'pages'      => array( 'page' ),
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true,
			'fields'     => array(

				array(
					'name'    => __('Title Bar Caption', 'ThemeStockyard'),
					'id'      => $prefix . 'titlebar_caption',
					'type'    => 'text',
					"std"     => ''
				),

				array(
					'name'    => __('Show Breadcrumbs', 'ThemeStockyard'),
					'id'      => $prefix . 'show_breadcrumbs',
					'type'    => 'select',
					'options' => array(
						array('name' => __('Use default', 'ThemeStockyard'), 'value' => 'default'),
						array('name' => __('Yes', 'ThemeStockyard'), 'value' => 'yes'),
						array('name' => __('No', 'ThemeStockyard'),  'value' => 'no'),
					),
					"std"     => 'default'
				),

				array(
					'name'    => __('Show Page Title Bar', 'ThemeStockyard'),
					'id'      => $prefix . 'titlebar',
					'type'    => 'select',
					'options' => array(
						array('name' => __('Use default', 'ThemeStockyard'), 'value' => 'default'),
						array('name' => __('Yes', 'ThemeStockyard'), 'value' => 'yes'),
						array('name' => __('No', 'ThemeStockyard'),  'value' => 'no'),
					),
					"std"     => 'default'
				),
	               
			    array(
					'name'    => __('Show the sidebar?', 'ThemeStockyard'),
					'desc'    => '',
					'id'      => $prefix . 'sidebar',
					'type'    => 'select',
					'options' => array(
						array('name' => __('Use default', 'ThemeStockyard'), 'value' => 'default'),
						array('name' => __('Yes', 'ThemeStockyard'), 'value' => 'yes'),
						array('name' => __('No', 'ThemeStockyard'), 'value' => 'no'),
					),
					"std"     => 'default'
				),
	               
			    array(
					'name'    => __('Sidebar Position', 'ThemeStockyard'),
					'desc'    => '',
					'id'      => $prefix . 'sidebar_position',
					'type'    => 'select',
					'options' => array(
						array('name' => __('Use default', 'ThemeStockyard'), 'value' => 'default'),
						array('name' => __('Right', 'ThemeStockyard'), 'value' => 'right'),
						array('name' => __('Left', 'ThemeStockyard'), 'value' => 'left'),
					),
					"std"     => 'default'
				),
				
				array(
					'name'    => __('Content Padding', 'ThemeStockyard'),
					'desc'    => __('Top/bottom content padding is automatically removed in some cases.', 'ThemeStockyard'),
					'id'      => $prefix . 'content_padding',
					'type'    => 'select',
                    'options' => array(
                        array('name' => __('Normal', 'ThemeStockyard'), 'value' => ''),
                        array('name' => __('Remove Top Padding', 'ThemeStockyard'), 'value' => 'no_top_padding'),
                        array('name' => __('Remove Bottom Padding', 'ThemeStockyard'), 'value' => 'no_bottom_padding'),
                        array('name' => __('Remove Top & Bottom Padding', 'ThemeStockyard'), 'value' => 'no_padding'),           
                    )
				),
				
				array(
                    'name' => __('Slider Settings' , 'ThemeStockyard'),
                    'desc' => '',
                    'type' => 'title',
                    'id'   => $prefix . 'title_image_slider_project'
                ), 
                
                array(
					'name'    => __('Slider Width', 'ThemeStockyard'),
					'id'      => $prefix . 'slider_width',
					'type'    => 'select',
					'options' => array(
						array('name' => __('Content Width', 'ThemeStockyard'), 'value' => 'content'),
						array('name' => __('Full width', 'ThemeStockyard'), 'value' => 'fullwidth'),
					),
					"std"     => 'content'
				),
                
				array(
					'name'    => __('Slider Type', 'ThemeStockyard'),
					'id'      => $prefix . 'slider_type',
					'type'    => 'select',
					'options' => $ts_slider_type_options,
					"std"     => ''
				),
				
				array(
					'name'    => __('Slider Revolution: Select a slider', 'ThemeStockyard'),
					'id'      => $prefix . 'rev_slider',
					'desc'    => __('This setting is only useful when the <a href="http://codecanyon.net/item/slider-revolution-responsive-wordpress-plugin/2751380?ref=themestockyard" target="_blank">Slider Revolution</a> plugin is installed and activated.', 'ThemeStockyard'),
					'type'    => 'select',
					"std"     => '',
					'options' => $ts_rev_sliders,
					'hidden'  => true,
					'unhide_id' => $prefix . 'slider_type',
					'unhide_value' => 'rev'
				),
				
				array(
					'name'    => '',
					'id'      => $prefix . 'rev_slider_stop_here',
					'desc'    => __('The following slider settings are not used with the Slider Revolution.', 'ThemeStockyard'),
					'type'    => 'title',
					'hidden'  => true,
					'unhide_id' => $prefix . 'slider_type',
					'unhide_value' => 'rev'
				),
                
				array(
					'name'    => __('Slider Source', 'ThemeStockyard'),
					'id'      => $prefix . 'slider_source',
					//'desc'    => __('Choose whether the slides should come from &#8220;Blog posts&#8221; or &#8220;Slider posts&#8221;.', 'ThemeStockyard'),
					'type'    => 'select',
					'options' => array(
						//array('name' => __('[none]', 'ThemeStockyard'), 'value' => ''),
						array('name' => __('Blog posts', 'ThemeStockyard'), 'value' => 'blog'),
						array('name' => __('Specific Blog posts', 'ThemeStockyard'), 'value' => 'specific_blog_posts'),
						//array('name' => __('Slider posts', 'ThemeStockyard'),  'value' => 'slider'),
					),
					"std"     => 'blog',
				),
				
				
                array(
                    'name' => __('Input Blog Post IDs', 'ThemeStockyard'),
                    'desc' => __('Separate with commas. <strong>Note:</strong> To easily see blog post IDs, navigate to Dashboard > Posts to see the column displaying IDs.', 'ThemeStockyard'),
                    'id'   => $prefix . 'slider_blog_post_ids',
                    'type' => 'text',
                    'std'  => '',
					'unhide_id' => $prefix . 'slider_source',
					'unhide_value' => 'specific_blog_posts'
                ),

				array(
					'name'    => __('Blog Categories', 'ThemeStockyard'),
					'id'      => $prefix . 'slider_blog_cats',
					'desc'    => __('Leave all unchecked to show posts from <strong>all</strong> categories.', 'ThemeStockyard'),
					'type'    => 'multicheck',
					'options' => $ts_cmb_categories,
					"std"     => '',
					'hidden'  => true,
					'unhide_id' => $prefix . 'slider_source',
					'unhide_value' => 'blog'
				),
                /*
				array(
					'name'    => __('Carousel & Flexslider:  Portfolio Categories', 'ThemeStockyard'),
					'id'      => $prefix . 'slider_portfolio_cats',
					'desc'    => __('Leave all unchecked to show posts from <strong>all</strong> categories.', 'ThemeStockyard'),
					'type'    => 'taxonomy_multicheck',
					'taxonomy'=> 'portfolio-category',
					"std"     => '',
					'hidden'  => true,
					'unhide_id' => $prefix . 'slider_source',
					'unhide_value' => 'portfolio'
				),
                */
				array(
					'name'    => __('Slider Category', 'ThemeStockyard'),
					'id'      => $prefix . 'slider_category',
					'desc'    => __('To use &#8220;Slider posts&#8221;, you must first <a href="post-new.php?post_type=slider">create slides</a> and <a href="edit-tags.php?taxonomy=slider-category&post_type=slider">slider categories</a>.', 'ThemeStockyard'),
					'type'    => 'select_slider_cats',
					"std"     => '',
					'hidden'  => true,
					'unhide_id' => $prefix . 'slider_source',
					'unhide_value' => 'slider'
				),
                

				array(
					'name'    => __('Text Alignment', 'ThemeStockyard'),
					'id'      => $prefix . 'slider_text_align',
					'desc'    => __('Title, description, etc', 'ThemeStockyard'),
					'type'    => 'select',
					'options' => array(
						array('name' => __('left', 'ThemeStockyard'), 'value' => 'left'),
						array('name' => __('center', 'ThemeStockyard'), 'value' => 'center'),
						array('name' => __('right', 'ThemeStockyard'),  'value' => 'right'),
					),
					"std"     => 'left'
				),
                
                array(
					'name'    => __('# of Slides', 'ThemeStockyard'),
					'id'      => $prefix . 'slider_count',
					'desc'    => __('Choose the number of items to show in the slider.', 'ThemeStockyard'),
					'type'    => 'select',
					'options' => $cmb_slider_count,
					"std"     => 5,
				),
                

				array(
					'name'    => __('Allow videos?', 'ThemeStockyard'),
					'id'      => $prefix . 'slider_allow_videos',
					'desc'    => '',
					'type'    => 'select',
					'options' => array(
						array('name' => __('Yes', 'ThemeStockyard'), 'value' => 'yes'),
						array('name' => __('No', 'ThemeStockyard'), 'value' => 'no'),
					),
					"std"     => 'no'
				),
				
				
                array(
                    'name' => __('Slider Height', 'ThemeStockyard'),
                    'desc' => __('Leave blank for default: 420px', 'ThemeStockyard'),
                    'id'   => $prefix . 'slider_height',
                    'type' => 'text_small',
                    'std'  => '',
					'unhide_id' => $prefix . 'slider_type',
					'unhide_value' => 'flex'
                ),
				
				
                array(
                    'name' => __('Slider Height', 'ThemeStockyard'),
                    'desc' => __('Leave blank for default: 420px (Minimum: 300px - Maximum: 600px)', 'ThemeStockyard'),
                    'id'   => $prefix . 'slider_carousel_height',
                    'type' => 'text_small',
                    'std'  => '',
					'unhide_id' => $prefix . 'slider_type',
					'unhide_value' => 'carousel'
                ),
				
				/*
                array(
                    'name' => __('Add Bottom Margin to Slider', 'ThemeStockyard'),
                    'id'   => $prefix . 'slider_bottom_margin',
                    'type'    => 'select',
					'options' => array(
						array('name' => __('Yes', 'ThemeStockyard'), 'value' => 'yes'),
						array('name' => __('No', 'ThemeStockyard'), 'value' => 'no'),
					),
					"std"     => 'yes',
                ),
				*/

			),
		);

		$meta_boxes[] = array(
			'id'         => 'page_metabox2',
			'title'      => __('Custom CSS', 'ThemeStockyard'),
			'pages'      => array( 'page' ),
			'context'    => 'normal',
			'priority'   => 'low',
			'show_names' => true,
			'fields'     => array(

				array(
					'desc'    => __('Type or paste your page-specific CSS here.', 'ThemeStockyard'),
					'id'      => $prefix . 'css',
					'type'    => 'textarea_code',
					"std"     => ''
				),
				 
			),
		);

		return $meta_boxes;
	}


	
/*-----------------------------------------------------------------------------------*/
/*  POST METABOX */
/*-----------------------------------------------------------------------------------*/
	add_filter ('cmb_meta_boxes', 'cmb_post_metaboxes');
	function cmb_post_metaboxes(array $meta_boxes) 
	{	    
		$prefix = '_p_';

		$meta_boxes[] = array(
			'id'         => 'post_metabox2',
			'title'      => __('General Post Settings', 'ThemeStockyard'),
			'pages'      => array( 'post' ),
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true,
			'fields'     => array(

				array(
					'name'    => __('Title Bar Caption', 'ThemeStockyard'),
					'id'      => $prefix . 'titlebar_caption',
					'type'    => 'text',
					"std"     => ''
				),

				array(
					'name'    => __('Show Breadcrumbs', 'ThemeStockyard'),
					'id'      => $prefix . 'show_breadcrumbs',
					'type'    => 'select',
					'options' => array(
						array('name' => __('Use default', 'ThemeStockyard'), 'value' => 'default'),
						array('name' => __('Yes', 'ThemeStockyard'), 'value' => 'yes'),
						array('name' => __('No', 'ThemeStockyard'),  'value' => 'no'),
					),
					"std"     => 'default'
				),

				array(
					'name'    => __('Show Title Bar', 'ThemeStockyard'),
					'id'      => $prefix . 'titlebar',
					'type'    => 'select',
					'options' => array(
						array('name' => __('Use default', 'ThemeStockyard'), 'value' => 'default'),
						array('name' => __('Yes', 'ThemeStockyard'), 'value' => 'yes'),
						array('name' => __('No', 'ThemeStockyard'),  'value' => 'no'),
					),
					"std"     => 'default',
				),
	        
	               
			    array(
					'name'    => __('Show the sidebar?', 'ThemeStockyard'),
					'desc'    => '',
					'id'      => $prefix . 'sidebar',
					'type'    => 'select',
					'options' => array(
						array('name' => __('Use default', 'ThemeStockyard'), 'value' => 'default'),
						array('name' => __('Yes', 'ThemeStockyard'), 'value' => 'yes'),
						array('name' => __('No', 'ThemeStockyard'), 'value' => 'no'),
					),
					"std"     => 'default',
				),
	               
			    array(
					'name'    => __('Sidebar Position', 'ThemeStockyard'),
					'desc'    => '',
					'id'      => $prefix . 'sidebar_position',
					'type'    => 'select',
					'options' => array(
						array('name' => __('Use default', 'ThemeStockyard'), 'value' => 'default'),
						array('name' => __('Right', 'ThemeStockyard'), 'value' => 'right'),
						array('name' => __('Left', 'ThemeStockyard'), 'value' => 'left'),
						array('name' => __('Right (under featured image)', 'ThemeStockyard'), 'value' => 'content-right'),
						array('name' => __('Left (under featured image)', 'ThemeStockyard'), 'value' => 'content-left'),
						array('name' => __('Right (next to comments)', 'ThemeStockyard'), 'value' => 'comments-right'),
						array('name' => __('Left (next to comments)', 'ThemeStockyard'), 'value' => 'comments-left'),
					),
					"std"     => 'default'
				),
	        
	               
			    array(
					'name'    => __('Sharing Options position', 'ThemeStockyard'),
					'desc'    => '',
					'id'      => $prefix . 'sharing_options_position',
					'type'    => 'select',
					'options' => array(
						array('name' => __('Use default', 'ThemeStockyard'), 'value' => 'default'),
						array('name' => __('Top (below featured image)', 'ThemeStockyard'), 'value' => 'top'),
						array('name' => __('Right', 'ThemeStockyard'), 'value' => 'right'),
						array('name' => __('Left', 'ThemeStockyard'), 'value' => 'left'),
						array('name' => __('Hidden', 'ThemeStockyard'), 'value' => 'hidden'),
					),
					"std"     => 'default',
				),
	        
	               
			    array(
					'name'    => __('Show "Featured Image" on single post', 'ThemeStockyard'),
					'desc'    => __('Show or hide the featured image when viewing this individual post page', 'ThemeStockyard'),
					'id'      => $prefix . 'show_featured_image_on_single',
					'type'    => 'select',
					'options' => array(
						array('name' => __('Use default', 'ThemeStockyard'), 'value' => 'default'),
						array('name' => __('Yes', 'ThemeStockyard'), 'value' => 'yes'),
						array('name' => __('No', 'ThemeStockyard'), 'value' => 'no'),
					),
					"std"     => 'default',
				),
	        
	               
			    array(
					'name'    => __('Preview Image', 'ThemeStockyard'),
					'desc'    => __('Preview Images can be used as alternatives to Featured Images within the &#8220;posts loop&#8221; (archives, blog, search, recent posts, etc) &ndash; they are <strong>not</strong> shown within sliders or on single post pages.', 'ThemeStockyard'),
					'id'      => $prefix . 'preview_image',
					'type'    => 'file',
					'save_id' => true,
					'allow'   => 'upload',
				),
				/*
				array(
					'name'    => __('Content Padding', 'ThemeStockyard'),
					'desc'    => __('Top/bottom content padding is automatically removed in some cases.', 'ThemeStockyard'),
					'id'      => $prefix . 'content_padding',
					'type'    => 'select',
                    'options' => array(
                        array('name' => __('Normal', 'ThemeStockyard'), 'value' => ''),
                        array('name' => __('Remove Top Padding', 'ThemeStockyard'), 'value' => 'no_top_padding'),
                        array('name' => __('Remove Bottom Padding', 'ThemeStockyard'), 'value' => 'no_bottom_padding'),
                        array('name' => __('Remove Top & Bottom Padding', 'ThemeStockyard'), 'value' => 'no_padding'),           
                    )
				),
				*/
				array(
					'name'    => __('Show Related Posts', 'ThemeStockyard'),
					'id'      => $prefix . 'related_posts',
					'type'    => 'select',
                    'options' => array(
                        array('name' => __('Use default', 'ThemeStockyard'), 'value' => 'default'),
                        array('name' => __('Yes', 'ThemeStockyard'), 'value' => 'yes'),
                        array('name' => __('No', 'ThemeStockyard'), 'value' => 'no'),               
                    )
				),
				
				array(
					'name'    => __('Crop featured image(s)?', 'ThemeStockyard'),
					'id'      => $prefix . 'crop_images',
					'type'    => 'select',
                    'options' => array(
                        array('name' => __('Use default', 'ThemeStockyard'), 'value' => 'default'),
                        array('name' => __('Yes', 'ThemeStockyard'), 'value' => 'yes'),
                        array('name' => __('No', 'ThemeStockyard'), 'value' => 'no'),               
                    )
				),

		        array(
					'name' => __('Alternate Category Text (within Slider)', 'ThemeStockyard'),
					'desc' => __('If this post appears in a slider, the text entered here will be shown instead of the category name. <strong>Note:</strong> best to keep it short - one or two words.', 'ThemeStockyard'),
					'type' => 'text',
					'id'   => $prefix . 'alt_category_text'
		        ),
				
				
				// start gallery & video settings...
				array(
                    'name' => __('Gallery Settings' , 'ThemeStockyard'),
                    'desc' => '',
                    'type' => 'title',
                    'id'   => $prefix . 'title_image_slider_project'
                ),
                
				array(
                    'name'    => __('Image 1' , 'ThemeStockyard'),
                    'desc'    => __('Upload an image or enter an URL.' , 'ThemeStockyard'),
                    'id'      => $prefix . 'image_1',
                    'type'    => 'file',
                    'save_id' => true,
                    'allow'   => array( 'attachment' )
                ),
                
                array(
                    'name'    => __('Image 2' , 'ThemeStockyard'),
                    'desc'    => __('Upload an image or enter an URL.' , 'ThemeStockyard'),
                    'id'      => $prefix . 'image_2',
                    'type'    => 'file',
                    'save_id' => true,
                    'allow'   => array( 'attachment' )
                ),
                
                array(
                    'name'    => __('Image 3' , 'ThemeStockyard'),
                    'desc'    => __('Upload an image or enter an URL.' , 'ThemeStockyard'),
                    'id'      => $prefix . 'image_3',
                    'type'    => 'file',
                    'save_id' => true,
                    'allow'   => array( 'attachment' )
                ),
                
                array(
                    'name'    => __('Image 4' , 'ThemeStockyard'),
                    'desc'    => __('Upload an image or enter an URL.' , 'ThemeStockyard'),
                    'id'      => $prefix . 'image_4',
                    'type'    => 'file',
                    'save_id' => true,
                    'allow'   => array( 'attachment' )
                ),
                
                array(
                    'name'    => __('Image 5' , 'ThemeStockyard'),
                    'desc'    => __('Upload an image or enter an URL.' , 'ThemeStockyard'),
                    'id'      => $prefix . 'image_5',
                    'type'    => 'file',
                    'save_id' => true,
                    'allow'   => array( 'attachment' )
                ),
                
                array(
                    'name'    => __('Image 6' , 'ThemeStockyard'),
                    'desc'    => __('Upload an image or enter an URL.' , 'ThemeStockyard'),
                    'id'      => $prefix . 'image_6',
                    'type'    => 'file',
                    'save_id' => true,
                    'allow'   => array( 'attachment' )
                ),
                
                array(
                    'name'    => __('Image 7' , 'ThemeStockyard'),
                    'desc'    => __('Upload an image or enter an URL.' , 'ThemeStockyard'),
                    'id'      => $prefix . 'image_7',
                    'type'    => 'file',
                    'save_id' => true,
                    'allow'   => array( 'attachment' )
                ),
                
                array(
                    'name'    => __('Image 8' , 'ThemeStockyard'),
                    'desc'    => __('Upload an image or enter an URL.' , 'ThemeStockyard'),
                    'id'      => $prefix . 'image_8',
                    'type'    => 'file',
                    'save_id' => true,
                    'allow'   => array( 'attachment' )
                ),
                
                array(
                    'name'    => __('Image 9' , 'ThemeStockyard'),
                    'desc'    => __('Upload an image or enter an URL.' , 'ThemeStockyard'),
                    'id'      => $prefix . 'image_9',
                    'type'    => 'file',
                    'save_id' => true,
                    'allow'   => array( 'attachment' )
                ),
                
                array(
                    'name'    => __('Image 10' , 'ThemeStockyard'),
                    'desc'    => __('Upload an image or enter an URL.' , 'ThemeStockyard'),
                    'id'      => $prefix . 'image_10',
                    'type'    => 'file',
                    'save_id' => true,
                    'allow'   => array( 'attachment' )
                ),
                
                
	        
		        array(
					'name' => __('Video Settings', 'ThemeStockyard'),
					'desc' => __('To enable a featured video, paste a video ID or URL below.', 'ThemeStockyard'),
					'type' => 'title',
					'id'   => $prefix . 'video_title_menu_setting'
		        ),

		        array(
					'name' => __('Vimeo Video URL', 'ThemeStockyard'),
					'desc' => '',
					'type' => 'text',
					'id'   => $prefix . 'vimeo_id'
		        ),

		        array(
					'name' => __('YouTube Video URL', 'ThemeStockyard'),
					'desc' => '',
					'type' => 'text',
					'id'   => $prefix . 'youtube_id'
		        ),

		        array(
					'name' => __('Self-hosted Video', 'ThemeStockyard'),
					'desc' => __('Upload your own video.<br/><strong>Note:</strong> Self-hosted video is only supported on single post pages &mdash; not within the loop.', 'ThemeStockyard'),
					'type' => 'file',
					'id'   => $prefix . 'self_hosted_video',
		        ),
		        
		        
	        
		        array(
					'name' => __('Featured Audio Settings', 'ThemeStockyard'),
					'desc' => __('To enable featured audio, paste a SoundCloud or Spotify URL or embed code below.<br/><strong>Note:</strong> Featured Audio is only supported on single post pages &mdash; not within the loop.', 'ThemeStockyard'),
					'type' => 'title',
					'id'   => $prefix . 'audio_title_menu_setting'
		        ),

		        array(
					'name' => __('SoundCloud URL', 'ThemeStockyard'),
					'desc' => '',
					'type' => 'text',
					'id'   => $prefix . 'soundcloud_id'
		        ),

		        array(
					'name' => __('Spotify URL', 'ThemeStockyard'),
					'desc' => '',
					'type' => 'text',
					'id'   => $prefix . 'spotify_id'
		        ),

		        array(
					'name' => __('Self-hosted Audio', 'ThemeStockyard'),
					'desc' => __('Upload your own audio.', 'ThemeStockyard'),
					'type' => 'file',
					'id'   => $prefix . 'self_hosted_audio',
		        ),
			),
		);
		
		$meta_boxes[] = array(
			'id'         => 'post_metabox4',
			'title'      => __('Custom CSS', 'ThemeStockyard'),
			'pages'      => array( 'post' ),
			'context'    => 'normal',
			'priority'   => 'low',
			'show_names' => true,
			'fields'     => array(
	        
		        array(
					'desc'    => __('Type or paste your post-specific CSS here.', 'ThemeStockyard'),
					'id'      => $prefix . 'css',
					'type'    => 'textarea_code',
					"std"     => ''
				),

			),
		);

		return $meta_boxes;
	}


    /*-----------------------------------------------------------------------------------

    - Loads all the .php files found in /includes/metaboxes/ directory

    ----------------------------------------------------------------------------------- */

    require_once( TS_SERVER_PATH . '/includes/metaboxes/init.php' );	
}

add_action( 'after_setup_theme', 'ts_load_metaboxes' );