<?php

//add_action('init','of_options');


if (!function_exists('of_options'))
{
	function of_options()
	{
        $data = of_get_options();
        
        global $ts_all_fonts;
        
        $ts_all_fonts = ts_all_fonts(true);
        
        //Access the WordPress Categories via an Array
        $of_categories 		= array();  
        $of_categories_obj 	= get_categories('hide_empty=0');
        foreach ($of_categories_obj as $of_cat) {
            $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;
        }
        $_of_categories     = $of_categories;
        $categories_tmp 	= array_unshift($of_categories, __("Select a category:", 'ThemeStockyard'));    
           
        //Access the WordPress Pages via an Array
        $of_pages 			= array();
        $of_pages_obj 		= get_pages('sort_column=post_parent,menu_order');    
        foreach ($of_pages_obj as $of_page) {
            $of_pages[$of_page->ID] = $of_page->post_name; 
        }
        $of_pages_tmp 		= array_unshift($of_pages, __("Select a page:", 'ThemeStockyard'));       
    
        //Testing 
        $of_options_select 	= array("one","two","three","four","five"); 
        $of_options_radio 	= array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
        
        //Sample Homepage blocks for the layout manager (sorter)
        $of_options_homepage_blocks = array
        ( 
            "disabled" => array (
                "placebo" 		=> "placebo", //REQUIRED!
                "block_one"		=> "Block One",
                "block_two"		=> "Block Two",
                "block_three"	=> "Block Three",
            ), 
            "enabled" => array (
                "placebo" 		=> "placebo", //REQUIRED!
                "block_four"	=> "Block Four",
            ),
        );


        //Stylesheets Reader
        $alt_stylesheet_path = LAYOUT_PATH;
        $alt_stylesheets = array();
        
        if ( is_dir($alt_stylesheet_path) ) 
        {
            if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) 
            { 
                while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) 
                {
                    if(stristr($alt_stylesheet_file, ".css") !== false)
                    {
                        $alt_stylesheets[] = $alt_stylesheet_file;
                    }
                }    
            }
        }


        //Background Images Reader
        $bg_images_path =  get_stylesheet_directory(). '/images/bg/'; // change this to where you store your bg images
        $bg_images_url = get_template_directory_uri().'/images/bg/'; // change this to where you store your bg images
        $bg_images = array();
        
        if ( is_dir($bg_images_path) ) {
            if ($bg_images_dir = opendir($bg_images_path) ) { 
                while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
                    if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
                        $bg_images[] = $bg_images_url . $bg_images_file;
                    }
                }    
            }
        }
        

        /*-----------------------------------------------------------------------------------*/
        /* TO DO: Add options/functions that use these */
        /*-----------------------------------------------------------------------------------*/
        
        //More Options
        $uploads_arr 		= wp_upload_dir();
        $all_uploads_path 	= $uploads_arr['path'];
        $all_uploads 		= get_option('of_uploads');
        $other_entries 		= array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20");
        $body_attachment	= array("scroll","fixed");
        $body_repeat 		= array("no-repeat","repeat-x","repeat-y","repeat");
        $body_pos 			= array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
        $css_shadow_entries = array('min'=>'-10','max'=>'10');
        
        // Image Alignment radio box
        $of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
        
        // Image Links to Options
        $of_options_image_link_to = array("image" => "The Image","post" => "The Post");


        /*-----------------------------------------------------------------------------------*/
        /* The Options Array */
        /*-----------------------------------------------------------------------------------*/

        // Set the Options Array
        global $of_options;
        $of_options = array();

        /***
        General Settings
        ***/
        $of_options[] = array( 	"name" 		=> __("General Settings", 'ThemeStockyard'),
                                "type" 		=> "heading"
                        );
        /*
        $of_options[] = array( "name" => __("Enable &#8220;Sticky&#8221; Navigation", 'ThemeStockyard'),
                            "desc" => __("Turn on sticky navigation. <strong>Default:</strong> On<br/><strong>Note:</strong> not recommended when using &#8220;mega menu&#8221; plugins.", 'ThemeStockyard'),
                            "id" => "sticky_nav",
                            "std" => 1,
                            "type" => "switch");
        */
        $of_options[] = array( "name" => __("Enable &#8220;Smooth Page Scrolling&#8221;", 'ThemeStockyard'),
                            "desc" => __("Makes scrolling a bit smoother.<br/><strong>Default:</strong> Off", 'ThemeStockyard'),
                            "id" => "smooth_page_scroll",
                            "std" => 1,
                            "type" => "switch");
        /*
        $of_options[] = array( "name" => __("Enable &#8220;RTL&#8221; Mode", 'ThemeStockyard'),
                            "desc" => __("<strong>BETA:</strong> Most aspects of the site should work fine in RTL mode, but there is probably room for improvement.<br/><strong>Default:</strong> Off", 'ThemeStockyard'),
                            "id" => "rtl",
                            "std" => 0,
                            "type" => "switch");
        */
        /*
        $of_options[] = array( "name" => __("Responsive Design", 'ThemeStockyard'),
                            "desc" => __("Enable responsive design.", 'ThemeStockyard'),
                            "id" => "responsive",
                            "std" => 1,
                            "type" => "switch");
        */
        $of_options[] = array( "name" => __("Enable Inline CSS", 'ThemeStockyard'),
                            "desc" => __("Only enable this setting as a last resort if styling options (typography, colors, backgrounds, etc) are not updating correctly.", 'ThemeStockyard'),
                            "id" => "enable_inline_css",
                            "std" => 0,
                            "type" => "switch",
                            );
                        
        $of_options[] = array( 	"name" 		=> __("Custom CSS", 'ThemeStockyard'),
                                "desc" 		=> __("Paste any custom CSS you have right here.", 'ThemeStockyard'),
                                "id" 		=> "custom_css",
                                "std" 		=> "",
                                "type" 		=> "textarea"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Tracking Code", 'ThemeStockyard'),
                                "desc" 		=> __("Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.", 'ThemeStockyard'),
                                "id" 		=> "site_analytics",
                                "std" 		=> "",
                                "type" 		=> "textarea"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("&lt;HEAD&gt; Code", 'ThemeStockyard'),
                                "desc" 		=> __("Paste any scripts/code that you want to be in the &lt;head&gt; (HTML) section here.", 'ThemeStockyard'),
                                "id" 		=> "head_code",
                                "std" 		=> "",
                                "type" 		=> "textarea"
                        );

        $of_options[] = array( 	"name" 		=> __("Custom Favicon", 'ThemeStockyard'),
                                "desc" 		=> __("Upload a 16px x 16px Png/Gif image that will represent your website's favicon.", 'ThemeStockyard'),
                                "id" 		=> "custom_favicon",
                                "std" 		=> "",
                                "type" 		=> "upload"
                        ); 

        $of_options[] = array( "name" => __("Apple iPhone Icon Upload", 'ThemeStockyard'),
                            "desc" => __("Icon for Apple iPhone (57px x 57px)", 'ThemeStockyard'),
                            "id" => "iphone_icon",
                            "std" => "",
                            "type" => "upload");

        $of_options[] = array( "name" => __("Apple iPhone Retina Icon Upload", 'ThemeStockyard'),
                            "desc" => __("Icon for Apple iPhone Retina Version (114px x 114px)", 'ThemeStockyard'),
                            "id" => "iphone_icon_retina",
                            "std" => "",
                            "type" => "upload");

        $of_options[] = array( "name" => __("Apple iPad Icon Upload", 'ThemeStockyard'),
                            "desc" => __("Icon for Apple iPhone (72px x 72px)", 'ThemeStockyard'),
                            "id" => "ipad_icon",
                            "std" => "",
                            "type" => "upload");

        $of_options[] = array( "name" => __("Apple iPad Retina Icon Upload", 'ThemeStockyard'),
                            "desc" => __("Icon for Apple iPad Retina Version (144px x 144px)", 'ThemeStockyard'),
                            "id" => "ipad_icon_retina",
                            "std" => "",
                            "type" => "upload");
                        
        $of_options[] = array( 	"name" 		=> __("Custom RSS URL", 'ThemeStockyard'),
                                "desc" 		=> __("Paste your FeedBurner (or other) URL here.", 'ThemeStockyard'),
                                "id" 		=> "rss_url",
                                "std" 		=> "",
                                "type" 		=> "text"
                        );		

        // Header Options
        $of_options[] = array( 	"name" 		=> __("Header Options", 'ThemeStockyard'),
                                "type" 		=> "heading",
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Logo Options", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "logo_options_info",
                                "std" 		=> __('<h3>Logo Options</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );


        $of_options[] = array(  "name" => __("Logo", 'ThemeStockyard'),
                                "desc" => __("Upload your brand/company logo here.", 'ThemeStockyard'),
                                "id" => "logo_upload",
                                "std" => '',
                                "type" => "media");

        $of_options[] = array(  "name" => __("Retina Logo", 'ThemeStockyard'),
                                "desc" => __("Upload your retina logo here.", 'ThemeStockyard'),
                                "id" => "retina_logo",
                                "std" => '',
                                "type" => "media");

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("Retina logo width. Example: 120px", 'ThemeStockyard'),
                                "id" 		=> "retina_logo_width",
                                "std" 		=> "",
                                "type" 		=> "text"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("Retina logo height. Example: 40px", 'ThemeStockyard'),
                                "id" 		=> "retina_logo_height",
                                "std" 		=> "",
                                "type" 		=> "text"
                        );

        $alt_logo_text = get_option('blogname');
        $of_options[] = array( 	"name" 		=> __("Alternate Logo Text", 'ThemeStockyard'),
                                "desc" 		=> __("This text only shows up if you choose not to use an image logo above. <strong>Note:</strong> This text can be styled in the &#8220;Typography&#8221; section.", 'ThemeStockyard'),
                                "id" 		=> "logo_text",
                                "std" 		=> ($alt_logo_text) ? $alt_logo_text : "Your company",
                                "type" 		=> "text"
                        );
        /*
        $of_options[] = array( 	"name" 		=> __("Logo Top Margin", 'ThemeStockyard'),
                                "desc" 		=> __("Default: 35px", 'ThemeStockyard'),
                                "id" 		=> "logo_top_margin",
                                "std" 		=> "35px",
                                "type" 		=> "text"
                        );

        $of_options[] = array( 	"name" 		=> __("Logo Bottom Margin", 'ThemeStockyard'),
                                "desc" 		=> __("Default: 10px", 'ThemeStockyard'),
                                "id" 		=> "logo_bottom_margin",
                                "std" 		=> "10px",
                                "type" 		=> "text"
                        );
        */				
        /*							
        $of_options[] = array( 	"name" 		=> __("Top Layout (logo and main navigation)", 'ThemeStockyard'),
                                "desc" 		=> __("Choose a logo/main nav layout for your website.", 'ThemeStockyard'),
                                "id" 		=> "top_layout",
                                "std" 		=> "normal",
                                "type" => "select",
                                "options"   => array(
                                        'normal' => __('Standard', 'ThemeStockyard'),
                                        'centered' => __('Centered', 'ThemeStockyard'),
                                    ),
                        );
        */
                        
        $of_options[] = array( 	"name" 		=> __("Main Navigation Options", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "main_nav_options_info",
                                "std" 		=> __('<h3>Main Navigation Options</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );
        /*
        $of_options[] = array( 	"name" 		=> __("Main Navigation Top Margin", 'ThemeStockyard'),
                                "desc" 		=> __("Default: 20px", 'ThemeStockyard'),
                                "id" 		=> "main_nav_top_margin",
                                "std" 		=> "20px",
                                "type" 		=> "text"
                        );
        */
        /*
        $of_options[] = array( 	"name" 		=> __("Show Search Icon in Main Navigation", 'ThemeStockyard'),
                                "desc" 		=> __("Toggle ON or OFF any time<br/><strong>Note:</strong> Only works when a menu has been assigned to the &#8220;Main Navigation&#8221; menu location.", 'ThemeStockyard'),
                                "id" 		=> "include_main_nav_search_link",
                                "std" 		=> 1,
                                "type" 		=> "switch"
                        );
        */
        /*
        $of_options[] = array( 	"name" 		=> __("Show &#8220;User&#8221; Icon in Main Navigation", 'ThemeStockyard'),
                                "desc" 		=> __("Toggle ON or OFF any time", 'ThemeStockyard'),
                                "id" 		=> "include_main_nav_user_link",
                                "std" 		=> 1,
                                "type" 		=> "switch"
                        );
                        
        */				
        $of_options[] = array( 	"name" 		=> __("Show &#8220;Shop&#8221; Icon in Main Navigation", 'ThemeStockyard'),
                                "desc" 		=> __("Toggle ON or OFF any time.", 'ThemeStockyard'),
                                "id" 		=> "include_main_nav_shop_link",
                                "std" 		=> 1,
                                "type" 		=> "switch"
                        );
        /*
        $of_options[] = array( 	"name" 		=> __("Main Navigation: Distance Between Links", 'ThemeStockyard'),
                                "desc" 		=> __("Set the distance between the top-level links in the main navigation.<br/>Default: 40px", 'ThemeStockyard'),
                                "id" 		=> "main_nav_left_margin",
                                "std" 		=> "30px",
                                "type" 		=> "text"
                        );
        */				
        $of_options[] = array( 	"name" 		=> __("Social Icons in Header", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "social_icons_in_header_options_info",
                                "std" 		=> __('<h3>Social Icons in Header</h3><p>To show a linked icon in the header (next to the search field), add the appropriate URLs below...</p>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("<strong>Facebook</strong>", 'ThemeStockyard'),
                                "id" 		=> "social_url_facebook",
                                "std" 		=> '',
                                "type" 		=> "text"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("<strong>Twitter</strong>", 'ThemeStockyard'),
                                "id" 		=> "social_url_twitter",
                                "std" 		=> '',
                                "type" 		=> "text"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("<strong>Pinterest</strong>", 'ThemeStockyard'),
                                "id" 		=> "social_url_pinterest",
                                "std" 		=> '',
                                "type" 		=> "text"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("<strong>Google+</strong>", 'ThemeStockyard'),
                                "id" 		=> "social_url_google_plus",
                                "std" 		=> '',
                                "type" 		=> "text"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("<strong>Instagram</strong>", 'ThemeStockyard'),
                                "id" 		=> "social_url_instagram",
                                "std" 		=> '',
                                "type" 		=> "text"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("<strong>Flickr</strong>", 'ThemeStockyard'),
                                "id" 		=> "social_url_flickr",
                                "std" 		=> '',
                                "type" 		=> "text"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("<strong>Youtube</strong>", 'ThemeStockyard'),
                                "id" 		=> "social_url_youtube",
                                "std" 		=> '',
                                "type" 		=> "text"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("<strong>Vimeo</strong>", 'ThemeStockyard'),
                                "id" 		=> "social_url_vimeo",
                                "std" 		=> '',
                                "type" 		=> "text"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("<strong>VK</strong>", 'ThemeStockyard'),
                                "id" 		=> "social_url_vk",
                                "std" 		=> '',
                                "type" 		=> "text"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("<strong>Tumblr</strong>", 'ThemeStockyard'),
                                "id" 		=> "social_url_tumblr",
                                "std" 		=> '',
                                "type" 		=> "text"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("<strong>Behance</strong>", 'ThemeStockyard'),
                                "id" 		=> "social_url_behance",
                                "std" 		=> '',
                                "type" 		=> "text"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("<strong>Dribbble</strong>", 'ThemeStockyard'),
                                "id" 		=> "social_url_dribbble",
                                "std" 		=> '',
                                "type" 		=> "text"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("<strong>Soundcloud</strong>", 'ThemeStockyard'),
                                "id" 		=> "social_url_soundcloud",
                                "std" 		=> '',
                                "type" 		=> "text"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("<strong>RSS</strong> (use the <strong>[rss_url]</strong> shortcode for the default RSS url).", 'ThemeStockyard'),
                                "id" 		=> "social_url_rss",
                                "std" 		=> '',
                                "type" 		=> "text"
                        );	
                        	
        $of_options[] = array( 	"name" 		=> __("Alternative to Social Icons & Search in Header", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "alt_social_icons_search_options_info",
                                "std" 		=> '<h3>'.__('Alternative to Social Icons & Search in Header','ThemeStockyard').'</h3><p>'.__('By default, social icons and a search field will be shown in the header (next to the logo). If necessary, you can use the following options to change that.', 'ThemeStockyard').'</p>',
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Content to show in Social Icons / Search area", 'ThemeStockyard'),
                                "desc" 		=> __("Choose what to show in the area next to your logo.<br/><strong>Default:</strong> Social Icons & Search", 'ThemeStockyard'),
                                "id" 		=> "social_icons_search_content_option",
                                "std" 		=> "social_search",
                                "type" => "select",
                                "options"   => array(
                                        'social_search' => __('Social Icons & Search', 'ThemeStockyard'),
                                        'top_header_widget_area' => __('Top Header Widget Area', 'ThemeStockyard'),
                                        'alternative_field' => __('Alternative to Social Icons and Search (below)', 'ThemeStockyard'),
                                        'nothing' => __('Nothing', 'ThemeStockyard'),
                                    ),
                        );

        $of_options[] = array( 	"name" 		=> __('Alternative to Social Icons and Search', 'ThemeStockyard'),
                                "desc" 		=> __("HTML is permitted", 'ThemeStockyard'),
                                "id" 		=> "alternative_to_social_icons_search",
                                "std" 		=> '',
                                "type" 		=> "textarea"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Top Bar Options", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "top_bar_options_info",
                                "std" 		=> __('<h3>Top Bar Options</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );

        $of_options[] = array( 	"name" 		=> __("Show Top Bar", 'ThemeStockyard'),
                                "desc" 		=> __("Toggle ON or OFF any time", 'ThemeStockyard'),
                                "id" 		=> "show_top_bar",
                                "std" 		=> 1,
                                "type" 		=> "switch"
                        );

        $of_options[] = array( 	"name" 		=> __("Top Bar Left Content", 'ThemeStockyard'),
                                "id" 		=> "top_bar_left_content",
                                "std" 		=> "ticker",
                                "type" => "radio",
                                "options"   => array(
                                    'ticker' => __('News Ticker', 'ThemeStockyard'),
                                    'small_nav' => __('Show &#8220;Small Navigation&#8221; menu', 'ThemeStockyard'),
                                    'top_bar_alt_content' => __('Show &#8220;Top Bar Custom Content&#8221;', 'ThemeStockyard'),
                                ),
                        );

        $of_options[] = array( 	"name" 		=> __("Top Bar Right Content", 'ThemeStockyard'),
                                "id" 		=> "top_bar_right_content",
                                "std" 		=> "small_nav",
                                "type" => "radio",
                                "options"   => array(
                                    'ticker' => __('News Ticker', 'ThemeStockyard'),
                                    'small_nav' => __('Show &#8220;Small Navigation&#8221; menu', 'ThemeStockyard'),
                                    'top_bar_alt_content' => __('Show &#8220;Top Bar Custom Content&#8221;', 'ThemeStockyard'),
                                ),
                        );

        $of_options[] = array( 	"name" 		=> __("Top Bar Custom Content", 'ThemeStockyard'),
                                "desc"      => __('If using the <strong>[date format="..."]</strong> shortcode, see <a href="http://codex.wordpress.org/Formatting_Date_and_Time" target="_blank">this page</a> for formatting options.', 'ThemeStockyard'),
                                "id" 		=> "top_bar_alt_content",
                                "std" 		=> '[date format="l, F j, Y"]',
                                "type" 		=> "textarea"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Top Ad Options", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "top_ad_options_info",
                                "std" 		=> __('<h3>Top Ad Options</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );

        $of_options[] = array( 	"name" 		=> __("Show Top Ad", 'ThemeStockyard'),
                                "desc" 		=> __("Toggle ON or OFF any time", 'ThemeStockyard'),
                                "id" 		=> "show_top_ad",
                                "std" 		=> 1,
                                "type" 		=> "switch"
                        );

        $of_options[] = array( 	"name" 		=> __("Top Ad Content", 'ThemeStockyard'),
                                "desc"      => __('Paste your Google Adwords or other ad code here', 'ThemeStockyard'),
                                "id" 		=> "top_ad_code",
                                "std" 		=> '',
                                "type" 		=> "textarea"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Title Bar Options", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "title_bar_options_info",
                                "std" 		=> __('<h3>Title Bar Options</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );
        /*
        $of_options[] = array( 	"name" 		=> __("Show Page/Post Title Bar", 'ThemeStockyard'),
                                "desc" 		=> __("Toggle ON or OFF any time", 'ThemeStockyard'),
                                "id" 		=> "show_titlebar",
                                "std" 		=> 1,
                                "type" 		=> "switch"
                        );
        */
        $of_options[] = array( 	"name" 		=> __("Show Title Bar on pages", 'ThemeStockyard'),
                                "desc" 		=> __("Toggle ON or OFF any time", 'ThemeStockyard'),
                                "id" 		=> "show_titlebar_on_pages",
                                "std" 		=> ts_option_vs_default('show_titlebar', 1), // legacy compatibility
                                "type" 		=> "switch"
                        );

        $of_options[] = array( 	"name" 		=> __("Show Title Bar on posts", 'ThemeStockyard'),
                                "desc" 		=> __("Toggle ON or OFF any time", 'ThemeStockyard'),
                                "id" 		=> "show_titlebar_on_posts",
                                "std" 		=> ts_option_vs_default('show_titlebar', 1), // legacy compatibility
                                "type" 		=> "switch"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Show &#8220;Breadcrumbs&#8221; on pages", 'ThemeStockyard'),
                                "desc" 		=> '',
                                "id" 		=> "show_breadcrumbs_on_pages",
                                "std" 		=> 1,
                                "type" 		=> "switch"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Show &#8220;Breadcrumbs&#8221; on posts", 'ThemeStockyard'),
                                "desc" 		=> '',
                                "id" 		=> "show_breadcrumbs_on_posts",
                                "std" 		=> 0,
                                "type" 		=> "switch"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Header Alignment Options", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "header_alignment_options_info",
                                "std" 		=> '<h3>'.__('Header Alignment Options', 'ThemeStockyard').'</h3>',
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Logo Alignment", 'ThemeStockyard'),
                                "desc" 		=> __("Choose a logo alignment for your website.<br/><strong>Note:</strong> Social links, Search, and Top Header Widgets are not compatible with a &#8220;Centered&#8221; logo.", 'ThemeStockyard'),
                                "id" 		=> "logo_alignment_layout",
                                "std" 		=> "normal",
                                "type" => "select",
                                "options"   => array(
                                        'normal' => __('Standard', 'ThemeStockyard'),
                                        'centered' => __('Centered', 'ThemeStockyard'),
                                    ),
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Main Navigation Alignment", 'ThemeStockyard'),
                                "desc" 		=> __("Choose a main navigation (menu) alignment for your website.", 'ThemeStockyard'),
                                "id" 		=> "main_nav_alignment_layout",
                                "std" 		=> "normal",
                                "type" => "select",
                                "options"   => array(
                                        'normal' => __('Standard', 'ThemeStockyard'),
                                        'centered' => __('Centered', 'ThemeStockyard'),
                                    ),
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Title Bar Alignment", 'ThemeStockyard'),
                                "desc" 		=> __("Choose a title bar alignment for your website.", 'ThemeStockyard'),
                                "id" 		=> "titlebar_layout",
                                "std" 		=> "normal",
                                "type" => "select",
                                "options"   => array(
                                        'normal' => __('Standard', 'ThemeStockyard'),
                                        'centered' => __('Centered', 'ThemeStockyard'),
                                    ),
                        );
            
            
        // Footer Options
        $of_options[] = array( 	"name" 		=> __("Footer Options", 'ThemeStockyard'),
                                "type" 		=> "heading",
                        );

        $of_options[] = array( 	"name" 		=> __("Show Bottom Ad", 'ThemeStockyard'),
                                "desc" 		=> __("Toggle ON or OFF any time", 'ThemeStockyard'),
                                "id" 		=> "show_bottom_ad",
                                "std" 		=> 1,
                                "type" 		=> "switch"
                        );

        $of_options[] = array( 	"name" 		=> __("Bottom Ad Content", 'ThemeStockyard'),
                                "desc"      => __('Paste your Google Adwords or other ad code here', 'ThemeStockyard'),
                                "id" 		=> "bottom_ad_code",
                                "std" 		=> '',
                                "type" 		=> "textarea"
                        );

        $of_options[] = array( 	"name" 		=> __("Show Footer &#8220;Widget Area&#8221;", 'ThemeStockyard'),
                                "id" 		=> "show_footer_widgets",
                                "std" 		=> 1,
                                "type" 		=> "switch"
                        );

        $url =  ADMIN_DIR . 'assets/images/';
        $of_options[] = array( 	"name" 		=> __("Footer &#8220;Widget Area&#8221; Layout", 'ThemeStockyard'),
                                "id" 		=> "footer_layout",
                                "std" 		=> "footer2",
                                "type" 		=> "images",
                                "options" 	=> array(
                                    'footer1' 	    => $url . 'footer-1.png',
                                    'footer2' 	    => $url . 'footer-2.png',
                                    'footer3' 	    => $url . 'footer-3.png',
                                    'footer4' 	    => $url . 'footer-4.png',
                                    'footer5' 	    => $url . 'footer-5.png',
                                    'footer6' 	    => $url . 'footer-6.png',
                                    'footer7' 	    => $url . 'footer-7.png',
                                    'footer8' 	    => $url . 'footer-8.png'
                                )
                        );

        $of_options[] = array( 	"name" 		=> __("Show Copyright &amp; Bottom Navigation Area", 'ThemeStockyard'),
                                "id" 		=> "show_copyright",
                                "std" 		=> 1,
                                "type" 		=> "switch"
                        );

        $of_options[] = array( 	"name" 		=> __("Copyright Text", 'ThemeStockyard'),
                                "desc" 		=> __("<strong>Note:</strong> Use the [year] shortcode to always show the current year.", 'ThemeStockyard'),
                                "id" 		=> "copyright_text",
                                "std" 		=> "&copy; Copyright [year]. All rights reserved.",
                                "type" 		=> "text"
                        );

        // Sidebar Options
        $of_options[] = array( 	"name" 		=> __("Sidebar Options", 'ThemeStockyard'),
                                "type" 		=> "heading"
                        );

        $of_options[] = array( "name" => __("Sidebar Width", 'ThemeStockyard'),
                            "desc" => __("Set the desired sidebar width in pixels.<br/>Even numbers work best.<br/>Min: 100px - Max: 600px<br/><strong>Default:</strong> 310px", 'ThemeStockyard'),
                            "id" => "sidebar_width",
                            "std" => '310px',
                            "type" => "text",
                            );

        $of_options[] = array( "name" => __("Default Sidebar Visibility", 'ThemeStockyard'),
                            "desc" => __("<strong>Show sidebar on Pages</strong><br/>(Can be changed for individual pages)", 'ThemeStockyard'),
                            "id" => "show_page_sidebar",
                            "std" => 1,
                            "type" => "checkbox",
                            );

        $of_options[] = array( "name" => '',
                            "desc" => __("<strong>Show sidebar on Blog posts</strong><br/>(Can be changed for individual posts)", 'ThemeStockyard'),
                            "id" => "show_post_sidebar",
                            "std" => 1,
                            "type" => "checkbox",
                            );

        $of_options[] = array( "name" => __("Default Sidebar Position: Pages", 'ThemeStockyard'),
                            "desc" => __("Can be changed for individual pages", 'ThemeStockyard'),
                            "id" => "page_sidebar_position",
                            "std" => 'right',
                            "type" => "radio",
                            "options"   => array(
                                    'right' => __('Right', 'ThemeStockyard'),
                                    'left' => __('Left', 'ThemeStockyard'),
                                ),
                            );

        $of_options[] = array( "name" => __("Default Sidebar Position: Posts", 'ThemeStockyard'),
                            "desc" => __("Can be changed for individual posts", 'ThemeStockyard'),
                            "id" => "post_sidebar_position",
                            "std" => 'right',
                            "type" => "radio",
                            "options"   => array(
                                    'right' => __('Right', 'ThemeStockyard'),
                                    'left' => __('Left', 'ThemeStockyard'),
                                    'content-right' => __('Right (under fullwidth featured media)', 'ThemeStockyard'),
                                    'content-left' => __('Left (under fullwidth featured media)', 'ThemeStockyard'),
                                    'comments-right' => __('Right (under content, next to comments)', 'ThemeStockyard'),
                                    'comments-left' => __('Left (under content, next to comments)', 'ThemeStockyard'),
                                ),
                            );

        $of_options[] = array( "name" => __("Sidebar Placement on Tablets", 'ThemeStockyard'),
                            "desc" => __("For devices with a viewport smaller than 768 pixels (like tablets), decide where the sidebar should appear.", 'ThemeStockyard'),
                            "id" => "tablet_sidebar_placement",
                            "std" => 'beside-content',
                            "type" => "radio",
                            "options"   => array(
                                    'beside-content' => __('Beside Content (default)', 'ThemeStockyard'),
                                    'below-content' => __('Below Content', 'ThemeStockyard'),
                                ),
                            );

        // Blog Options
        $of_options[] = array( 	"name" 		=> __("Blog Options", 'ThemeStockyard'),
                                "type" 		=> "heading"
                        );	

        $of_options[] = array( 	"name" 		=> __("Turn on &#8220;Infinite Scrolling&#8221; for the &#8220;Blog&#8221;?", 'ThemeStockyard'),
                                "desc" 		=> __("If set to ON, more posts will load automatically as users scroll down the page. <strong>Note:</strong> This option is only for the main blog page and pages that use the &#8220;Blog Template&#8221;. The blog shortcode has its own infinite scroll method.", 'ThemeStockyard'),
                                "id" 		=> "infinite_scroll_on_blog_template",
                                "std" 		=> 0,
                                "type" 		=> "switch" 
                        );

        $of_options[] = array( 	"name" 		=> __("Crop Featured Images on &#8220;Blog&#8221; page?", 'ThemeStockyard'),
                                "desc" 		=> __("<strong>Note:</strong> This option is only used with &#8220;1 Column&#8221; and &#8220;Traditional&#8221; blog layouts.", 'ThemeStockyard'),
                                "id" 		=> "crop_images_on_blog",
                                "std" 		=> 1,
                                "type" 		=> "switch" 
                        );

        $of_options[] = array( 	"name" 		=> __("Show hover effect on Featured Images?", 'ThemeStockyard'),
                                "desc" 		=> '',
                                "id" 		=> "show_featured_image_hover_effect",
                                "std" 		=> 1,
                                "type" 		=> "switch" 
                        );

        $of_options[] = array( 	"name" 		=> __("Default posts layout on &#8220;Blog&#8221; page", 'ThemeStockyard'),
                                "desc" 		=> __("Choose a default layout for the blog", 'ThemeStockyard'),
                                "id" 		=> "blog_layout",
                                "std" 		=> "1column",
                                "type" => "select",
                                "options"   => array(
                                        '1column' => __('1 Column', 'ThemeStockyard'),
                                        '2columns' => __('2 Columns', 'ThemeStockyard'),
                                        '3columns' => __('3 Columns', 'ThemeStockyard'),
                                        'cards' => __('Cards', 'ThemeStockyard'),
                                        'masonry' => __('Grid/Masonry', 'ThemeStockyard'),
                                        'mediumimage' => __('Medium Images', 'ThemeStockyard'),
                                        'traditional' => __('Traditional', 'ThemeStockyard'),
                                    ),
                        );

        $of_options[] = array( 	"name" 		=> __("Default posts layout on &#8220;Search&#8221; page", 'ThemeStockyard'),
                                "desc" 		=> __("Choose a layout for the Search results page", 'ThemeStockyard'),
                                "id" 		=> "search_layout",
                                "std" 		=> "1column",
                                "type" => "select",
                                "options"   => array(
                                        '1column' => __('1 Column', 'ThemeStockyard'),
                                        '2columns' => __('2 Columns', 'ThemeStockyard'),
                                        '3columns' => __('3 Columns', 'ThemeStockyard'),
                                        'cards' => __('Cards', 'ThemeStockyard'),
                                        'masonry' => __('Grid/Masonry', 'ThemeStockyard'),
                                        'mediumimage' => __('Medium Images', 'ThemeStockyard'),
                                        'legacy' => __('Legacy', 'ThemeStockyard'),
                                    ),
                        );

        $of_options[] = array( 	"name" 		=> __("Default posts layout on &#8220;Archives&#8221; page", 'ThemeStockyard'),
                                "desc" 		=> __("Choose a layout for the Search results page", 'ThemeStockyard'),
                                "id" 		=> "archive_layout",
                                "std" 		=> "1column",
                                "type" => "select",
                                "options"   => array(
                                        '1column' => __('1 Column', 'ThemeStockyard'),
                                        '2columns' => __('2 Columns', 'ThemeStockyard'),
                                        '3columns' => __('3 Columns', 'ThemeStockyard'),
                                        'cards' => __('Cards', 'ThemeStockyard'),
                                        'masonry' => __('Grid/Masonry', 'ThemeStockyard'),
                                        'mediumimage' => __('Medium Images', 'ThemeStockyard'),
                                        'legacy' => __('Legacy', 'ThemeStockyard'),
                                    ),
                        );

        $of_options[] = array( 	"name" 		=> __("Default excerpt length within loop", 'ThemeStockyard'),
                                "desc" 		=> __('&#8220;Default / 1 Column&#8221; layout. <strong>Default:</strong> 320', 'ThemeStockyard'),
                                "id" 		=> "excerpt_length_default",
                                "std" 		=> "320",
                                "type" => "text",
                                'class' => 'small-text'
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __('&#8220;2 Column&#8221;, &#8220;3 Column&#8221;and &#8220;Medium Image&#8221; layouts. <strong>Default:</strong> 160', 'ThemeStockyard'),
                                "id" 		=> "excerpt_length_2col_3col_medium",
                                "std" 		=> "160",
                                "type" => "text",
                                'class' => 'small-text'
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __('&#8220;Masonry&#8221; and &#8220;Card&#8221; layouts. <strong>Default:</strong> 100', 'ThemeStockyard'),
                                "id" 		=> "excerpt_length_masonry_cards",
                                "std" 		=> "100",
                                "type" => "text",
                                'class' => 'small-text'
                        );

        $of_options[] = array( 	"name" 		=> __('Exclude Categories from Loop', 'ThemeStockyard'),
                                "desc" 		=> __('Optionally select one or more categories. Posts within these categories will not appear in blog results.', 'ThemeStockyard'),
                                "id" 		=> "excluded_blog_loop_categories",
                                "std" 		=> "",
                                "type" => "multiselect",
                                'options' => $_of_categories
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Single Post Options", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "single_post_options_info",
                                "std" 		=> __('<h3>Single Post Options</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );

        $of_options[] = array( 	"name" 		=> __("Crop Featured Images on &#8220;Single&#8221; post?", 'ThemeStockyard'),
                                "desc" 		=> '',
                                "id" 		=> "crop_images_on_post",
                                "std" 		=> 1,
                                "type" 		=> "switch" 
                        );	

        $of_options[] = array( 	"name" 		=> __('Cropped Featured Image Dimensions (with sidebar)', 'ThemeStockyard'),
                                "desc" 		=> __('<strong>Width</strong> (leave blank for default)', 'ThemeStockyard'),
                                "id" 		=> "cropped_featured_image_width",
                                "std" 		=> '',
                                "type" => "text",
                                'class' => 'small-text'
                        );	

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __('<strong>Height</strong> (leave blank for default)', 'ThemeStockyard'),
                                "id" 		=> "cropped_featured_image_height",
                                "std" 		=> '',
                                "type" => "text",
                                'class' => 'small-text'
                        );

        $of_options[] = array( 	"name" 		=> __('Cropped Featured Image Dimensions (NO sidebar)', 'ThemeStockyard'),
                                "desc" 		=> __('<strong>Width</strong> (leave blank for default)', 'ThemeStockyard'),
                                "id" 		=> "cropped_featured_image_width_full",
                                "std" 		=> '',
                                "type" => "text",
                                'class' => 'small-text'
                        );	

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __('<strong>Height</strong> (leave blank for default)', 'ThemeStockyard'),
                                "id" 		=> "cropped_featured_image_height_full",
                                "std" 		=> '',
                                "type" => "text",
                                'class' => 'small-text'
                        );		

        $of_options[] = array( 	"name" 		=> __("Show Featured Images/Videos on &#8220;Single&#8221; post?", 'ThemeStockyard'),
                                "desc" 		=> __('Use this option if you only want featured images to appear within the "loop", but not on individual post pages', 'ThemeStockyard'),
                                "id" 		=> "show_images_on_post",
                                "std" 		=> 1,
                                "type" 		=> "switch" 
                        );	

        $of_options[] = array( 	"name" 		=> __("Show &#8220;About the Author&#8221; on &#8220;Single&#8221; post pages?", 'ThemeStockyard'),
                                "desc" 		=> '',
                                "id" 		=> "author_info_on_post",
                                "std" 		=> 1,
                                "type" => "switch"
                        );	

        $of_options[] = array( 	"name" 		=> __("Show related posts on &#8220;Single&#8221; post pages?", 'ThemeStockyard'),
                                "desc" 		=> '',
                                "id" 		=> "show_related_blog_posts",
                                "std" 		=> 'yes',
                                "type" => "select",
                                "options"   => array(
                                        '1' => __('Yes', 'ThemeStockyard'),
                                        '0' => __('No', 'ThemeStockyard'),
                                    ),
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __('Related Posts Title Text', 'ThemeStockyard'),
                                "id" 		=> "related_blog_posts_title_text",
                                "std" 		=> "Related Posts",
                                "type" => "text",
                        );
        /*
        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __('Related Posts Title Alignment', 'ThemeStockyard'),
                                "id" 		=> "related_blog_posts_title_alignment",
                                "std" 		=> "left",
                                "type" => "select",
                                "options"   => array(
                                        'left' => __('Left', 'ThemeStockyard'),
                                        'center' => __('Center', 'ThemeStockyard'),
                                        'right' => __('Right', 'ThemeStockyard'),
                                    ),
                        );		
        */		

        $of_options[] = array( 	"name" 		=> __("Sharing Options position on &#8220;Single&#8221; post?", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "sharing_options_position_on_post",
                                "std" 		=> 'top',
                                "type" 		=> "radio",
                                "options"   => array(
                                    'top' => __('Top (below featured image)', 'ThemeStockyard'),
                                    'right' => __('Right', 'ThemeStockyard'),
                                    'left' => __('Left', 'ThemeStockyard'),
                                    'hidden' => __('Hidden', 'ThemeStockyard'),
                                ),
                        );		

        $of_options[] = array( 	"name" 		=> __("Available Sharing Options...", 'ThemeStockyard'),
                                "desc" 		=> __("Select the Sharing Options you want your website visitors to use.", 'ThemeStockyard'),
                                "id" 		=> "available_sharing_options",
                                "std" 		=> array(
                                    'facebook',
                                    'twitter',
                                    'google-plus',
                                    'pinterest',
                                    'tumblr',
                                    'linkedin',
                                    'reddit',
                                    'email',
                                    'print'
                                ),
                                "type" 		=> "multicheck",
                                'keyAsValue' => true,
                                "options"   => array(
                                    'facebook' => 'Facebook',
                                    'twitter' => 'Twitter',
                                    'google-plus' => 'Google+',
                                    'pinterest' => 'Pinterest',
                                    'vk' => 'VK',
                                    'tumblr' => 'Tumblr',
                                    'linkedin' => 'LinkedIn',
                                    'reddit' => 'Reddit',
                                    'digg' => 'Digg',
                                    'stumbleupon' => 'StumbleUpon',
                                    'email' => __('Email', 'ThemeStockyard'),
                                    'print' => __('Print', 'ThemeStockyard')
                                ),
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Single Post Options Beta", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "single_post_options_info",
                                "std" 		=> __('<h3>Single Post Options (BETA)</h3><p>The following options are in open beta and may not work as expected.</p>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );	
                        
        $of_options[] = array( 	"name" 		=> __("Show page view count for single posts?", 'ThemeStockyard'),
                                "desc" 		=> __('The page view count will be shown within the meta section of the title bar.<br/><strong>Note:</strong> The counter will not update properly on cached pages.', 'ThemeStockyard'),
                                "id" 		=> "show_titlebar_post_view_count",
                                "std" 		=> 0,
                                "type" 		=> "switch" 
                        );
                        
        /*
        $of_options[] = array( 	"name" 		=> __("Show author avatars?", 'ThemeStockyard'),
                                "desc" 		=> __('Show author avatars within loop and on single posts.', 'ThemeStockyard'),
                                "id" 		=> "show_author_avatar",
                                "std" 		=> 0,
                                "type" 		=> "switch" 
                        );		

        */			
                        
        // Comment Options
        $of_options[] = array( 	"name" 		=> __("Comment Options", 'ThemeStockyard'),
                                "type" 		=> "heading",
                        );

        $of_options[] = array( 	"name" 		=> __("Show Comments on pages", 'ThemeStockyard'),
                                "desc" 		=> '',
                                "id" 		=> "show_comments_on_pages",
                                "std" 		=> 0,
                                "type" 		=> "switch"
                        );

        $of_options[] = array( 	"name" 		=> __("Show user avatars next to comments", 'ThemeStockyard'),
                                "desc" 		=> __("Not available for Disqus comments", 'ThemeStockyard'),
                                "id" 		=> "show_comments_avatars",
                                "std" 		=> 1,
                                "type" 		=> "switch"
                        );

        $of_options[] = array( 	"name" 		=> __("Use Disqus", 'ThemeStockyard'),
                                "desc" 		=> __('Enable <a href="http://disqus" target="_blank">Disqus</a> comments (instead of standard comments)', 'ThemeStockyard'),
                                "id" 		=> "use_disqus",
                                "std" 		=> 0,
                                "type" 		=> "switch"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Disqus Shortname", 'ThemeStockyard'),
                                "desc" 		=> __("Type the &#8220;shortname&#8221; that belongs to the Disqus account you created for this website.", 'ThemeStockyard'),
                                "id" 		=> "disqus_shortname",
                                "std" 		=> "",
                                "type" 		=> "text"
                        );

        // Shop Options
        $of_options[] = array( 	"name" 		=> __("Shop Options", 'ThemeStockyard'),
                                "type" 		=> "heading",
                        );
                        
        $of_options[] = array( 	"name" 		=> __("WooCommerce Options", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "woocommerce_options_info",
                                "std" 		=> __('<h3>WooCommerce Options</h3><p>The following settings will are only useful if the <a href="http://www.woothemes.com/woocommerce/" target="_blank">WooCommerce plugin</a> is installed and activated.</p>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );

        $of_options[] = array( 	"name" 		=> __("Ajax Load Mini Shopping Cart on Each Page", 'ThemeStockyard'),
                                "desc" 		=> __('Enable ajax loading of the shopping cart (in the main navigation area) on each page load. This setting should be enabled if WP Cache or another caching plugin is in use.', 'ThemeStockyard'),
                                "id" 		=> "enable_cart_ajax_loading",
                                "std" 		=> 0,
                                "type" 		=> "switch"
                        );

        $of_options[] = array( 	"name" 		=> __("Show &#8220;Add to Cart&#8221; Buttons on Results Page", 'ThemeStockyard'),
                                "desc" 		=> __('Default: On', 'ThemeStockyard'),
                                "id" 		=> "show_add_to_cart_button_on_results",
                                "std" 		=> 1,
                                "type" 		=> "switch"
                        );

        $of_options[] = array( 	"name" 		=> __("Show &#8220;Add to Cart&#8221; Buttons on Single Product Page(s)", 'ThemeStockyard'),
                                "desc" 		=> __('Default: On', 'ThemeStockyard'),
                                "id" 		=> "show_add_to_cart_button_on_single",
                                "std" 		=> 1,
                                "type" 		=> "switch"
                        );

        $of_options[] = array( 	"name" 		=> __("Show &#8220;Price(s)&#8221; on Results Page", 'ThemeStockyard'),
                                "desc" 		=> __('Default: On', 'ThemeStockyard'),
                                "id" 		=> "show_shop_prices_on_results",
                                "std" 		=> 1,
                                "type" 		=> "switch"
                        );

        $of_options[] = array( 	"name" 		=> __("Show &#8220;Price(s)&#8221; on Single Product Page(s)", 'ThemeStockyard'),
                                "desc" 		=> __('Default: On', 'ThemeStockyard'),
                                "id" 		=> "show_shop_prices_on_single",
                                "std" 		=> 1,
                                "type" 		=> "switch"
                        );
        /*
        $of_options[] = array( 	"name" 		=> __("Show &#8220;Review Score&#8221; on Results Page", 'ThemeStockyard'),
                                "desc" 		=> __('Default: On', 'ThemeStockyard'),
                                "id" 		=> "show_shop_reviews_on_results",
                                "std" 		=> 1,
                                "type" 		=> "switch"
                        );
        */
        $of_options[] = array( 	"name" 		=> __("Show &#8220;Reviews&#8221; on Single Product Page(s)", 'ThemeStockyard'),
                                "desc" 		=> __('Default: On', 'ThemeStockyard'),
                                "id" 		=> "show_shop_reviews_on_single",
                                "std" 		=> 1,
                                "type" 		=> "switch"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Disable Cart and Checkout", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "disable_cart_options_info",
                                "std" 		=> __('<h3>Catalog Mode</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );

        $of_options[] = array( 	"name" 		=> __("Disable Cart and Checkout Pages", 'ThemeStockyard'),
                                "desc" 		=> __('Default: Off', 'ThemeStockyard'),
                                "id" 		=> "catalog_mode",
                                "std" 		=> 0,
                                "type" 		=> "switch"
                        );

        // Other Options
        $of_options[] = array( 	"name" 		=> __("Other Options", 'ThemeStockyard'),
                                "type" 		=> "heading",
                        );
        /*				
        $of_options[] = array( 	"name" 		=> __("UberMenu Options", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "search_options_info",
                                "std" 		=> __('<h3>UberMenu Options</h3><p>Only useful when the <a href="http://themeforest.net/item/ubermenu-wordpress-mega-menu-plugin/154703" target="_blank">UberMenu</a> plugin is installed and activated. See <a href="http://themestockyard.com/addison/documentation/#!/ubermenu" target="_blank">the documentation</a> for integration tips.</p>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );

        $of_options[] = array( 	"name" 		=> __("Use Default Theme Styling", 'ThemeStockyard'),
                                "desc" 		=> __('Enable this option if you want your &#8220;Uber Menu&#8221; to keep the original look and feel of the theme.', 'ThemeStockyard'),
                                "id" 		=> "override_ubermenu_styling",
                                "std" 		=> 1,
                                "type" 		=> "switch"
                        );
        */				
        $of_options[] = array( 	"name" 		=> __("Search Options", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "search_options_info",
                                "std" 		=> __('<h3>Search Options</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );

        $of_options[] = array( 	"name" 		=> __("Search Input Placeholder Text", 'ThemeStockyard'),
                                "desc" 		=> __('This text will be used in sidebar search inputs as well.', 'ThemeStockyard'),
                                "id" 		=> "search_placeholder_text",
                                "std" 		=> "Search...",
                                "type" 		=> "text"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Breadcrumb Options", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "breadcrumb_options_info",
                                "std" 		=> __('<h3>&#8220;Breadcrumb&#8221; Options</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );

        $of_options[] = array( 	"name" 		=> __("&#8220;Breadcrumb&#8221; Home Link Text", 'ThemeStockyard'),
                                "desc" 		=> __('This text will be used to represent the homepage link in the &#8220;breadcrumbs&#8221;.<br/><strong>Note:</strong> Leave blank for default.', 'ThemeStockyard'),
                                "id" 		=> "breadcrumbs_home_link_text",
                                "std" 		=> "",
                                "type" 		=> "text"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Image Options", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "image_options_info",
                                "std" 		=> __('<h3>JPEG Compression Options</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );

        $of_options[] = array( 	"name" 		=> __("Sharpen Resized Images?", 'ThemeStockyard'),
                                "desc" 		=> __('<strong>Default:</strong> On', 'ThemeStockyard'),
                                "id" 		=> "sharpen_resized_images",
                                "std" 		=> 1,
                                "type" 		=> "switch"
                        );

        $of_options[] = array( 	"name" 		=> __("Use Custom JPEG Compression?", 'ThemeStockyard'),
                                "desc" 		=> __('<strong>Default:</strong> On', 'ThemeStockyard'),
                                "id" 		=> "use_custom_jpeg_compression",
                                "std" 		=> 1,
                                "type" 		=> "switch"
                        );

        $of_options[] = array( 	"name" 		=> __('JPEG Compression', 'ThemeStockyard'),
                                "desc" 		=> __("Set your desired JPEG compression for resized images. <strong>Note:</strong> While a higher setting will result in clearer images, it can also  result in larger file sizes and slower page loads.", 'ThemeStockyard'),
                                "id" 		=> "jpeg_compression",
                                "std" 		=> "95",
                                "min" 		=> "1",
                                "step"		=> "1",
                                "max" 		=> "100",
                                "type" 		=> "sliderui" 
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Developer Options", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "developer_options_info",
                                "std" 		=> __('<h3>Developer Options</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );

        $of_options[] = array( 	"name" 		=> __("Enable Style Selector", 'ThemeStockyard'),
                                "desc" 		=> __('Should probably only be used by developers', 'ThemeStockyard'),
                                "id" 		=> "enable_style_selector",
                                "std" 		=> 0,
                                "type" 		=> "switch"
                        );
                        
                        
                        /**/
                        
        /************************************************************************************
        Styling Options
        ************************************************************************************/


        // Typography
        $of_options[] = array(  "name"      => __("Typography", 'ThemeStockyard'),
                                "type"      => "heading",
                                "class"     => "mt10",
                                );

        $alt_logo_text = get_option('blogname');
        $preview_text  = ($alt_logo_text) ? $alt_logo_text : 'Grumpy wizards make toxic brew for the evil Queen and Jack.';
        $of_options[] = array( 	"name" 		=> __("Alternate Logo", 'ThemeStockyard'),
                                "desc"      => __("Choose a font<br/><strong>Note:</strong> only useful if you haven't uploaded a logo", 'ThemeStockyard'),
                                "id" 		=> "logo_font_family",
                                "std" 		=> "Droid Serif",
                                "type" 		=> "select_google_font",
                                "options"   => $ts_all_fonts,
                                "preview"   => array("text"=>$preview_text, "size"=>'30px'),
                        );

        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __("Alternate logo size &amp; style", 'ThemeStockyard'),
                                "id" 		=> "logo_font_style",
                                "std" 		=> array('size' => '36px','style' => 'normal'),
                                "type" 		=> "typography",
                                "class"     => "w345"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("General Typography Options", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "general_typography_options_info",
                                "std" 		=> __('<h3>General Typography</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );


        $of_options[] = array( 	"name" 		=> __("Small Text", 'ThemeStockyard'),
                                "desc" 		=> __("Choose a font", 'ThemeStockyard'),
                                "id" 		=> "small_font_family",
                                "std" 		=> "Open Sans",
                                "type" 		=> "select_google_font",
                                "options"   => $ts_all_fonts,
                                "preview"   => array("text"=>'0123456789 Grumpy wizards make toxic brew for the evil Queen and Jack.', "size"=>'16px'),
                        );

        $of_options[] = array( 	"name" 		=> __("Plain Text", 'ThemeStockyard'),
                                "desc" 		=> __("Choose a font", 'ThemeStockyard'),
                                "id" 		=> "body_font_family",
                                "std" 		=> "Droid Serif",
                                "type" 		=> "select_google_font",
                                "preview"   => array("text"=>'0123456789 Grumpy wizards make toxic brew for the evil Queen and Jack.', "size"=>'16px'),
                                "options"   => $ts_all_fonts,
                        );

        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __("Font size &amp; style", 'ThemeStockyard'),
                                "id" 		=> "body_font_style",
                                "std" 		=> array('size' => '14px'),
                                "type" 		=> "typography",
                                "class"     => "w345",
                        );
                                    
        $of_options[] = array( 	"name" 		=> __("&lt;H1&gt; heading", 'ThemeStockyard'),
                                "desc" 		=> __("Choose a font", 'ThemeStockyard'),
                                "id" 		=> "h1_font_family",
                                "std" 		=> "Droid Serif",
                                "type" 		=> "select_google_font",
                                "options"   => $ts_all_fonts,
                                "preview"   => array("text"=>'0123456789 Grumpy wizards make toxic brew for the evil Queen and Jack.', "size"=>'16px'),
                        );

        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __("Font style", 'ThemeStockyard'),
                                "id" 		=> "h1_font_style",
                                "std" 		=> array('style' => 'normal','size' => '36px'),
                                "type" 		=> "typography",
                                "class"     => "w345",
                        );
                        
        $of_options[] = array( 	"name" 		=> __("&lt;H2&gt; heading", 'ThemeStockyard'),
                                "desc" 		=> __("Choose a font", 'ThemeStockyard'),
                                "id" 		=> "h2_font_family",
                                "std" 		=> "Droid Serif",
                                "type" 		=> "select_google_font",
                                "options"   => $ts_all_fonts,
                                "preview"   => array("text"=>'0123456789 Grumpy wizards make toxic brew for the evil Queen and Jack.', "size"=>'16px'),
                        );

        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __("Font style", 'ThemeStockyard'),
                                "id" 		=> "h2_font_style",
                                "std" 		=> array('style' => 'normal','size' => '26px'),
                                "type" 		=> "typography",
                                "class"     => "w345",
                        );
                        
        $of_options[] = array( 	"name" 		=> __("&lt;H3&gt; heading", 'ThemeStockyard'),
                                "desc" 		=> __("Choose a font", 'ThemeStockyard'),
                                "id" 		=> "h3_font_family",
                                "std" 		=> "Droid Serif",
                                "type" 		=> "select_google_font",
                                "options"   => $ts_all_fonts,
                                "preview"   => array("text"=>'0123456789 Grumpy wizards make toxic brew for the evil Queen and Jack.', "size"=>'16px'),
                        );

        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __("Font style", 'ThemeStockyard'),
                                "id" 		=> "h3_font_style",
                                "std" 		=> array('style' => 'normal','size' => '20px'),
                                "type" 		=> "typography",
                                "class"     => "w345",
                        );
                        
        $of_options[] = array( 	"name" 		=> __("&lt;H4&gt; heading", 'ThemeStockyard'),
                                "desc" 		=> __("Choose a font", 'ThemeStockyard'),
                                "id" 		=> "h4_font_family",
                                "std" 		=> "Droid Serif",
                                "type" 		=> "select_google_font",
                                "options"   => $ts_all_fonts,
                                "preview"   => array("text"=>'0123456789 Grumpy wizards make toxic brew for the evil Queen and Jack.', "size"=>'16px'),
                        );

        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __("Font style", 'ThemeStockyard'),
                                "id" 		=> "h4_font_style",
                                "std" 		=> array('style' => 'normal','size' => '15px'),
                                "type" 		=> "typography",
                                "class"     => "w345",
                        );
                        
        $of_options[] = array( 	"name" 		=> __("&lt;H5&gt; heading", 'ThemeStockyard'),
                                "desc" 		=> __("Choose a font", 'ThemeStockyard'),
                                "id" 		=> "h5_font_family",
                                "std" 		=> "Open Sans",
                                "type" 		=> "select_google_font",
                                "options"   => $ts_all_fonts,
                                "preview"   => array("text"=>'0123456789 Grumpy wizards make toxic brew for the evil Queen and Jack.', "size"=>'16px'),
                        );

        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __("Font style", 'ThemeStockyard'),
                                "id" 		=> "h5_font_style",
                                "std" 		=> array('style' => 'normal','size' => '14px'),
                                "type" 		=> "typography",
                                "class"     => "w345",
                        );
                        
        $of_options[] = array( 	"name" 		=> __("&lt;H6&gt; heading", 'ThemeStockyard'),
                                "desc" 		=> __("Choose a font", 'ThemeStockyard'),
                                "id" 		=> "h6_font_family",
                                "std" 		=> "Open Sans",
                                "type" 		=> "select_google_font",
                                "options"   => $ts_all_fonts,
                                "preview"   => array("text"=>'0123456789 Grumpy wizards make toxic brew for the evil Queen and Jack.', "size"=>'16px'),
                        );

        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __("Font style", 'ThemeStockyard'),
                                "id" 		=> "h6_font_style",
                                "std" 		=> array('style' => 'normal','size' => '12px'),
                                "type" 		=> "typography",
                                "class"     => "w345",
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Main Navigation Typography Options", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "main_nav_typography_options_info",
                                "std" 		=> __('<h3>Main Navigation Typography</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );


        $of_options[] = array( 	"name" 		=> __("Main Navigation", 'ThemeStockyard'),
                                "desc" 		=> __("Choose a font", 'ThemeStockyard'),
                                "id" 		=> "main_nav_font_family",
                                "std" 		=> "Open Sans",
                                "type" 		=> "select_google_font",
                                "options"   => $ts_all_fonts,
                                "preview"   => array("text"=>'0123456789 Grumpy wizards make toxic brew for the evil Queen and Jack.', "size"=>'16px'),
                        );
                        
        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __("Font size", 'ThemeStockyard'),
                                "id" 		=> "main_nav_font_style",
                                "std" 		=> array('size' => '14px'),
                                "type" 		=> "typography",
                                "class"     => "w345",
                        );

        $of_options[] = array( 	"name" 		=> __("Main Navigation: Sub-menu", 'ThemeStockyard'),
                                "desc" 		=> __("Choose a font", 'ThemeStockyard'),
                                "id" 		=> "main_nav_submenu_font",
                                "std" 		=> "Open Sans",
                                "type" 		=> "select_google_font",
                                "options"   => $ts_all_fonts,
                                "preview"   => array("text"=>'0123456789 Grumpy wizards make toxic brew for the evil Queen and Jack.', "size"=>'16px'),
                        );
                        
        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __("Font size", 'ThemeStockyard'),
                                "id" 		=> "main_nav_submenu_font_style",
                                "std" 		=> array('size' => '14px'),
                                "type" 		=> "typography",
                                "class"     => "w345",
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Footer Typography Options", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "footer_typography_options_info",
                                "std" 		=> __('<h3>Footer Typography</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );

        $of_options[] = array( 	"name" 		=> __("Footer: Plain Text", 'ThemeStockyard'),
                                "desc" 		=> __("Choose a font", 'ThemeStockyard'),
                                "id" 		=> "footer_font_family",
                                "std" 		=> "Droid Serif",
                                "type" 		=> "select_google_font",
                                "preview"   => array("text"=>'0123456789 Grumpy wizards make toxic brew for the evil Queen and Jack.', "size"=>'13px'),
                                "options"   => $ts_all_fonts,
                        );

        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __("Font size", 'ThemeStockyard'),
                                "id" 		=> "footer_font_style",
                                "std" 		=> array('size' => '14px'),
                                "type" 		=> "typography",
                                "class"     => "w345",
                        );



        // Colors
        $of_options[] = array(  "name"      => __("Colors", 'ThemeStockyard'),
                                "type"      => "heading",
                                );

        $of_options[] = array( 	"name" 		=> __("Choose a theme/skin", 'ThemeStockyard'),
                                "desc" 		=> __("<strong>Note:</strong> Choosing a theme/skin will automatically change some of the colors below.", 'ThemeStockyard'),
                                "id" 		=> "skin",
                                "std" 		=> "light",
                                "type" => "select",
                                "options"   => array(
                                        'light' => __('Light', 'ThemeStockyard'),
                                        'dark' => __('Dark', 'ThemeStockyard'),
                                    ),
                        );

        $of_options[] = array( 	"name" 		=> __("Choose a color scheme", 'ThemeStockyard'),
                                "desc" 		=> __("<strong>Note:</strong> Choosing a color scheme will automatically change some of the colors below.", 'ThemeStockyard'),
                                "id" 		=> "color_scheme",
                                "std" 		=> "yellow",
                                "type" => "select",
                                "options"   => array(
                                        'magenta' => __('Magenta', 'ThemeStockyard'),
                                        'red' => __('Red', 'ThemeStockyard'),
                                        'peach' => __('Peach', 'ThemeStockyard'),
                                        'purple' => __('Purple', 'ThemeStockyard'),
                                        'navy' => __('Navy', 'ThemeStockyard'),
                                        'blue' => __('Blue', 'ThemeStockyard'),
                                        'teal' => __('Teal', 'ThemeStockyard'),
                                        'green' => __('Green 1', 'ThemeStockyard'),
                                        'green2' => __('Green 2', 'ThemeStockyard'),
                                        'yellow' => __('Mustard Yellow (default)', 'ThemeStockyard'),
                                        'orange' => __('Orange', 'ThemeStockyard'),
                                        'brown' => __('Brown', 'ThemeStockyard'),
                                        'gray' => __('Gray', 'ThemeStockyard'),
                                    ),
                        );

        $of_options[] = array( 	"name" 		=> "",
                                "desc" => __("Check this box to create your own color scheme.", 'ThemeStockyard'),
                                "id" => "use_custom_color_scheme",
                                "std" => 0,
                                "type" => "checkbox",
                                "folds" => 1,
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" => __('<button id="custom_color_scheme_button" type="button" class="button-primary">Select Color</button> &nbsp; Choose any color you like, then click the button.', 'ThemeStockyard'),
                                "id" => "custom_color_scheme",
                                "std" => "",
                                "type" => "color",
                                "fold" => "use_custom_color_scheme"
                        );
                                
        $of_options[] = array( 	"name" 		=> __("General Colors", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "general_colors_info",
                                "std" 		=> __('<h3>General Colors</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );  

        $of_options[] = array( 	"name" 		=> __("Primary/Highlight Color", 'ThemeStockyard'),
                                "desc" 		=> '',
                                "id" 		=> "primary_color",
                                "std" 		=> '#E8B71A',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> __("Standard Border Color", 'ThemeStockyard'),
                                "desc" 		=> '',
                                "id" 		=> "standard_border_color",
                                "std" 		=> '#eee',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> __("Subtle Text Color", 'ThemeStockyard'),
                                "desc" 		=> '',
                                "id" 		=> "subtle_text_color",
                                "std" 		=> '#999',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> __("Subtle Background Color", 'ThemeStockyard'),
                                "desc" 		=> '',
                                "id" 		=> "subtle_bg_color",
                                "std" 		=> '#f5f5f5',
                                "type" 		=> "color"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Top area colors", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "top_area_colors_info",
                                "std" 		=> __('<h3>Top area colors</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );

        $of_options[] = array( 	"name" 		=> __("Top Bar", 'ThemeStockyard'),
                                "desc" 		=> __("Bottom border color", 'ThemeStockyard'),
                                "id" 		=> "top_bar_border_color",
                                "std" 		=> '#eee',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("Background color", 'ThemeStockyard'),
                                "id" 		=> "top_bar_bg_color",
                                "std" 		=> '#f5f5f5',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("Text color", 'ThemeStockyard'),
                                "id" 		=> "top_bar_font_color",
                                "std" 		=> '#808080',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("Link color", 'ThemeStockyard'),
                                "id" 		=> "top_bar_link_color",
                                "std" 		=> '#383838',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> __("Alternate Logo", 'ThemeStockyard'),
                                "desc" 		=> __("Alternate logo color<br/><strong>Note:</strong> only useful if you haven't uploaded a logo.", 'ThemeStockyard'),
                                "id" 		=> "logo_font_color",
                                "std" 		=> '#383838',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> __("Main Navigation Colors", 'ThemeStockyard'),
                                "desc" 		=> __("Link color", 'ThemeStockyard'),
                                "id" 		=> "main_nav_link_color",
                                "std" 		=> '#808080',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __("Hover/active color", 'ThemeStockyard'),
                                "id" 		=> "main_nav_hover_color",
                                "std" 		=> '#383838',
                                "type" 		=> "color"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Main Navigation: Sub-menu", 'ThemeStockyard'),
                                "desc" 		=> __('Background Color', 'ThemeStockyard'),
                                "id" 		=> "main_nav_submenu_bg_color",
                                "std" 		=> '#222',
                                "type" 		=> "color"
                        );
                        
        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("Link color", 'ThemeStockyard'),
                                "id" 		=> "main_nav_submenu_link_color",
                                "std" 		=> '#ccc',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __("Hover/Active Link Color", 'ThemeStockyard'),
                                "id" 		=> "main_nav_submenu_hover_color",
                                "std" 		=> '#fff',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __("Text Color", 'ThemeStockyard'),
                                "id" 		=> "main_nav_submenu_text_color",
                                "std" 		=> '#aaa',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __("Border/Separator Color", 'ThemeStockyard'),
                                "id" 		=> "main_nav_submenu_border_color",
                                "std" 		=> '#333',
                                "type" 		=> "color"
                        );	

        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __("Subtle Background Color", 'ThemeStockyard'),
                                "id" 		=> "main_nav_submenu_subtle_bg_color",
                                "std" 		=> '#282828',
                                "type" 		=> "color"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Title Bar Colors", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "title_bar_colors_info",
                                "std" 		=> __('<h3>Title Bar Colors</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );

        $of_options[] = array( 	"name" 		=> __("Title Bar Heading", 'ThemeStockyard'),
                                "desc" 		=> __("Font color", 'ThemeStockyard'),
                                "id" 		=> "title_bar_heading_color",
                                "std" 		=> "#212121",
                                "type" 		=> "color"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Body Colors", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "body_colors_info",
                                "std" 		=> __('<h3>Body/Content Colors</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );

        $of_options[] = array( 	"name" 		=> __("Body: General Links", 'ThemeStockyard'),
                                "desc" 		=> __("Link color", 'ThemeStockyard'),
                                "id" 		=> "body_link_color",
                                "std" 		=> "#212121",
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> __("Body: Post Content Links", 'ThemeStockyard'),
                                "desc" 		=> __("Link color", 'ThemeStockyard'),
                                "id" 		=> "body_post_content_link_color",
                                "std" 		=> "#E8B71A",
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> __("Body: Title Links", 'ThemeStockyard'),
                                "desc" 		=> __("Link color", 'ThemeStockyard'),
                                "id" 		=> "body_title_link_color",
                                "std" 		=> "#212121",
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> __("Body: Plain Text", 'ThemeStockyard'),
                                "desc" 		=> __("Body text color", 'ThemeStockyard'),
                                "id" 		=> "body_font_color",
                                "std" 		=> '#555',
                                "type" 		=> "color",
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Body: &lt;H1-6&gt; Headings", 'ThemeStockyard'),
                                "desc" 		=> __("Body heading colors", 'ThemeStockyard'),
                                "id" 		=> "heading_font_color",
                                "std" 		=> '#444',
                                "type" 		=> "color",
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Blog Colors", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "blog_colors_info",
                                "std" 		=> __('<h3>Blog Colors</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );

        $of_options[] = array( 	"name" 		=> __("Blog: Masonry Cards Background", 'ThemeStockyard'),
                                "desc" 		=> __("Background color", 'ThemeStockyard'),
                                "id" 		=> "masonry_cards_bg_color",
                                "std" 		=> '#fff',
                                "type" 		=> "color",
                        );
                        
        $of_options[] = array( 	"name" 		=> __("WooCommerce Colors", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "woocommerce_colors_info",
                                "std" 		=> __('<h3>WooCommerce Colors</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("Price Color", 'ThemeStockyard'),
                                "id" 		=> "woocommerce_price_color",
                                "std" 		=> '#7ac142',
                                "type" 		=> "color",
                        );
                    
        $of_options[] = array( 	"name" 		=> __("Form Colors", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "form_colors_info",
                                "std" 		=> __('<h3>Form Colors</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );

        $of_options[] = array( 	"name" 		=> __("Form Element Colors", 'ThemeStockyard'),
                                "desc" 		=> __("Text color", 'ThemeStockyard'),
                                "id" 		=> "form_font_color",
                                "std" 		=> '#808080',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("Form field border color", 'ThemeStockyard'),
                                "id" 		=> "form_border_color",
                                "std" 		=> '#ddd',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("Form field background color", 'ThemeStockyard'),
                                "id" 		=> "form_background_color",
                                "std" 		=> '#f9f9f9',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("Form field background color (focus)", 'ThemeStockyard'),
                                "id" 		=> "form_focus_background_color",
                                "std" 		=> '#fff',
                                "type" 		=> "color"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Footer Colors", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "footer_colors_info",
                                "std" 		=> __('<h3>Footer Colors</h3>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );
                                
        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("Border color (top and bottom)", 'ThemeStockyard'),
                                "id" 		=> "footer_border_color",
                                "std" 		=> '#eee',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("Background color", 'ThemeStockyard'),
                                "id" 		=> "footer_widget_bg_color",
                                "std" 		=> "#f5f5f5",
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> __("Footer: &#8220;Widget Area&#8221;", 'ThemeStockyard'),
                                "desc" 		=> __("Link color", 'ThemeStockyard'),
                                "id" 		=> "footer_widgets_link_color",
                                "std" 		=> '#383838',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __("Plain text color", 'ThemeStockyard'),
                                "id" 		=> "footer_widget_font_color",
                                "std" 		=> '#808080',
                                "type" 		=> "color",
                        );

        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __("Headings", 'ThemeStockyard'),
                                "id" 		=> "footer_widget_headings_color",
                                "std" 		=> '#808080',
                                "type" 		=> "color",
                        );
                                
        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("Widget border colors (some widgets use borders, set those colors here)", 'ThemeStockyard'),
                                "id" 		=> "footer_widget_border_color",
                                "std" 		=> '#eee',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> __("Footer Form Elements", 'ThemeStockyard'),
                                "desc" 		=> __("Text color", 'ThemeStockyard'),
                                "id" 		=> "footer_form_font_color",
                                "std" 		=> '#555',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("Form field border color", 'ThemeStockyard'),
                                "id" 		=> "footer_form_border_color",
                                "std" 		=> '#ddd',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> '',
                                "desc" 		=> __("Form field background color", 'ThemeStockyard'),
                                "id" 		=> "footer_form_background_color",
                                "std" 		=> '#fff',
                                "type" 		=> "color"
                        );
                        
        /*

        $of_options[] = array( 	"name" 		=> __("Copyright &amp; Bottom Nav", 'ThemeStockyard'),
                                "desc" 		=> __("Plain text color", 'ThemeStockyard'),
                                "id" 		=> "copyright_font_color",
                                "std" 		=> '#999',
                                "type" 		=> "color",
                        );

        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __('Link Color', 'ThemeStockyard'),
                                "id" 		=> "copyright_link_color",
                                "std" 		=> '#E8B71A',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __('Link Hover Color', 'ThemeStockyard'),
                                "id" 		=> "copyright_link_hover_color",
                                "std" 		=> '#E8B71A',
                                "type" 		=> "color"
                        );

        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __('Link Hover Color', 'ThemeStockyard'),
                                "id" 		=> "copyright_link_border_color",
                                "std" 		=> '#c0c0c0',
                                "type" 		=> "color"
                        );
        */





        // Backgrounds Styles
        $of_options[] = array(  "name"      => __("Background", 'ThemeStockyard'),
                                "type"      => "heading",
                                );
                                
        $of_options[] = array( "name" => __("Enable Fullwidth Layout", 'ThemeStockyard'),
                            "desc" => __("Turn <strong>off</strong> to use a background image.<br/><strong>Default:</strong> On", 'ThemeStockyard'),
                            "id" => "layout",
                            "std" => 1,
                            "type" => "switch");
                                
        $of_options[] = array( "name" => __("Add Subtle Shadow To Content", 'ThemeStockyard'),
                            "desc" => __("This adds a very subtle shadow on the left and right sides of web page content. <strong>Note:</strong> Only useful when fullwidth layout is disabled.", 'ThemeStockyard'),
                            "id" => "layout_shadow",
                            "std" => 1,
                            "type" => "switch");
                                           
        $of_options[] = array( 	"name" 		=> __("Body background color.", 'ThemeStockyard'),
                                "desc" 		=> '',
                                "id" 		=> "background_color",
                                "std" 		=> "#fff",
                                "type" 		=> "color"
                        );
                                
        $of_options[] = array( 	"name" 		=> __("Body content background color", 'ThemeStockyard'),
                                "desc" 		=> __("<strong>Note:</strong> not useful with fullwidth layout", 'ThemeStockyard'),
                                "id" 		=> "content_background_color",
                                "std" 		=> "#fff",
                                "type" 		=> "color"
                        );

        $url =  get_template_directory_uri() . '/images/backgrounds/';
        $of_options[] = array( 	"name" 		=> __("Body: Background Pattern/Color", 'ThemeStockyard'),
                                "desc" 		=> __('Choose a background pattern and color for your website.<br/><br/>Visit <a href="http://subtlepatterns.com" target="_blank">SubtlePatterns.com</a> for more.', 'ThemeStockyard'),
                                "id" 		=> "background_pattern",
                                "std" 		=> "",
                                "type" 		=> "images",
                                "options" 	=> array(
                                    '' 	            => $url . 'none_thumb.jpg',
                                    'arches' 	    => $url . 'arches_thumb.png',
                                    'bright-squares'    => $url . 'bright-squares_thumb.jpg',
                                    'cartographer'    => $url . 'cartographer_thumb.png',	
                                    'dark_wood' 	    => $url . 'dark_wood_thumb.png',
                                    'diagmonds'    => $url . 'diagmonds_thumb.png',
                                    'escheresque_ste' 	    => $url . 'escheresque_ste_thumb.png',
                                    'escheresque'    => $url . 'escheresque_thumb.png',
                                    'food'    => $url . 'food_thumb.png',
                                    'gplaypattern' 	    => $url . 'gplaypattern_thumb.png',
                                    'graphy'    => $url . 'graphy_thumb.png',
                                    'green_cup'    => $url . 'green_cup_thumb.png',
                                    'grunge-wall' 	    => $url . 'grunge-wall_thumb.jpg',
                                    'px_by_Gr3g' 	    => $url . 'px_by_Gr3g_thumb.png',							
                                    'retina_wood'    => $url . 'retina_wood_thumb.jpg',
                                    'school'    => $url . 'school_thumb.png',
                                    'shattered'    => $url . 'shattered_thumb.png',
                                    'skulls'    => $url . 'skulls_thumb.png',
                                    'sneaker_mesh_fabric'      => $url . 'sneaker_mesh_fabric_thumb.jpg',
                                    'stressed_linen' 	    => $url . 'stressed_linen_thumb.png',
                                    'swirl_pattern'    => $url . 'swirl_pattern_thumb.png',
                                    'symphony'    => $url . 'symphony_thumb.png',
                                    'tileable_wood_texture'    => $url . 'tileable_wood_texture_thumb.png',
                                    'type' 	    => $url . 'type_thumb.png',
                                )
                        );

        $of_options[] = array( 	"name" 		=> "",
                                "desc" => __("<strong>Alternatively, you can upload your own.</strong> Check the box to get started.", 'ThemeStockyard'),
                                "id" => "use_custom_background_image",
                                "std" => 0,
                                "type" => "checkbox",
                                "folds" => 1,
                        );

        $of_options[] = array( 	"name" 		=> __("Body: Custom Background Image", 'ThemeStockyard'),
                                "desc" => __('Upload a custom background image or pattern here.<br/><strong>Note:</strong> only useful in &#8220;Boxed&#8221; layout', 'ThemeStockyard'),
                                "id" => "custom_background_image",
                                "std" => "",
                                "type" => "media",
                                "fold" => "use_custom_background_image"
                        );

        $of_options[] = array( 	"name" 		=> "",
                                "desc" 		=> __("Custom background image properties: Repeat, Position, Attachment", 'ThemeStockyard'),
                                "id" 		=> "custom_background_positioning",
                                "std" 		=> array('position'=>'top center', 'repeat'=>'repeat', 'attachment'=>'scroll'),
                                "type" 		=> "background_positioning",
                                "options" 	=> array('position'=>$body_pos, 'repeat'=>$body_repeat, 'attachment'=>$body_attachment),
                                "fold" => "use_custom_background_image"
                        );
        /*
        $of_options[] = array( 	"name" 		=> "",
                                "desc" => __("<strong>Use background image with Fullwidth layout.</strong><br/>By default, background images are only used with the boxed layout.", 'ThemeStockyard'),
                                "id" => "fullwidth_bg_image",
                                "std" => 0,
                                "type" => "checkbox",
                        );
        */  





        // Backup Options
        $of_options[] = array( 	"name" 		=> __("Backup Options", 'ThemeStockyard'),
                                "type" 		=> "heading",
                                "class"     => "mt10"
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Backup and Restore Options", 'ThemeStockyard'),
                                "id" 		=> "of_backup",
                                "std" 		=> "",
                                "type" 		=> "backup",
                                "desc" 		=> __('You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.', 'ThemeStockyard'),
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Transfer Theme Options Data", 'ThemeStockyard'),
                                "id" 		=> "of_transfer",
                                "std" 		=> "",
                                "type" 		=> "transfer",
                                "desc" 		=> __('You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".', 'ThemeStockyard'),
                        );
                        
        // Documentation Options
        $of_options[] = array( 	"name" 		=> __("Documentation", 'ThemeStockyard'),
                                "type" 		=> "heading",
                                "class"     => ""
                        );
                        
        $of_options[] = array( 	"name" 		=> __("Documentation Info", 'ThemeStockyard'),
                                "desc" 		=> "",
                                "id" 		=> "documentation_info",
                                "std" 		=> __('<h3>Documentation</h3><p>A copy of the documentation for the Maddux theme can always be found online at: <a href="http://themestockyard.com/maddux/documentation" target="_blank">http://themestockyard.com/maddux/documentation</a></p><p>Additionally, a copy should have been included with your Themeforest download.</p>', 'ThemeStockyard'),
                                "icon" 		=> true,
                                "type" 		=> "info"
                        );
				
	}//End function: of_options()
}//End check if function exists: of_options()