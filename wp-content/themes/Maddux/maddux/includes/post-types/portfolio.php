<?php
/*-----------------------------------------------------------------------------------*/
/* The Portfolio custom post type
/*-----------------------------------------------------------------------------------*/
add_action('after_setup_theme', 'ts_portfolio_register');
add_action('after_setup_theme', 'ts_portfolio_post_type_setup');

function ts_portfolio_post_type_setup() 
{
    add_filter('template_include', 'ts_portfolio_template_loader', 99 ); 
    add_filter('manage_portfolio_posts_columns', 'ts_portfolio_edit_columns');
    add_action('manage_portfolio_posts_custom_column',  'ts_portfolio_custom_columns');
}

function ts_portfolio_register() 
{ 
    global $smof_data;

    $labels = array(
        'name'               => _x('Portfolio', 'Portfolio General Name', 'ThemeStockyard'),
        'singular_name'      => _x('Portfolio Post', 'Portfolio Singular Name', 'ThemeStockyard'),
        'add_new'            => _x('Add New', 'Add New Portfolio Name', 'ThemeStockyard'),
        'add_new_item'       => __('Add New Portfolio Post', 'ThemeStockyard'),
        'edit_item'          => __('Edit Portfolio Post', 'ThemeStockyard'),
        'new_item'           => __('New Portfolio Post', 'ThemeStockyard'),
        'view_item'          => __('View Portfolio Post', 'ThemeStockyard'),
        'search_items'       => __('Search Portfolio', 'ThemeStockyard'),
        'not_found'          => __('Nothing found', 'ThemeStockyard'),
        'not_found_in_trash' => __('Nothing found in Trash', 'ThemeStockyard'),
        'parent_item_colon'  => ''
    );

    $args = array(
        'labels'             => $labels,
        'has_archive'        => true,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'query_var'          => true,
        'rewrite'            => array("slug" => ts_option_vs_default('portfolio_slug', 'work')),
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'supports'           => array('title','editor','author','thumbnail','excerpt', 'custom-fields', 'page-attributes'),

    ); 

    register_post_type('portfolio' , $args);
        
    register_taxonomy(
        "portfolio-category", array("portfolio"), array(
            "hierarchical"   => true,
            "label"          => "Portfolio Categories", 
            "labels"         => array(
                                    'menu_name'          => __('Categories', 'ThemeStockyard'),
                                ),
            "singular_label" => "Portfolio Category", 
            "rewrite"        => true));
    register_taxonomy_for_object_type('portfolio-category', 'portfolio');
    
    /*
    register_taxonomy(
        "portfolio-skill", array("portfolio"), array(
            "hierarchical"   => true, 
            "label"          => "Portfolio Skills", 
            "singular_label" => "Skill", 
            "labels"         => array(
                                    'menu_name'          => __('Skills', 'ThemeStockyard'),
                                ), 
            "rewrite"        => true));
    register_taxonomy_for_object_type('portfolio-skill', 'portfolio');

    register_taxonomy(
        "portfolio-year", array("portfolio"), array(
            "hierarchical"   => true, 
            "label"          => "Portfolio Years", 
            "singular_label" => "Portfolio Year", 
            "labels"         => array(
                                    'menu_name'          => __('Years', 'ThemeStockyard'),
                                ), 
            "rewrite"        => true));
    register_taxonomy_for_object_type('portfolio-year', 'portfolio');
    */
    //flush_rewrite_rules();
}


function ts_portfolio_template_loader( $template ) {

    $find = array();
    $file = '';

    if ( is_single() && get_post_type() == 'portfolio' ) {

        $file 	= 'single-portfolio.php';
        $find[] = $file;

    } elseif ( is_tax( 'portfolio-category' ) || is_tax( 'portfolio-skill' ) || is_tax( 'portfolio-year' ) ) {

        $file 		= 'taxonomy-portfolio.php';
        //$find[] 	= 'archive-portfolio.php';
        $find[] 	= $file;

    } elseif ( is_post_type_archive( 'portfolio' )) {

        $file 	= 'archive-portfolio.php';
        $find[] = $file;

    }

    if ( $file ) {
        $template = locate_template( $find );
    }

    return $template;
}




     
function ts_portfolio_edit_columns($columns) {  
    $columns = array(  
        "cb"          => "<input type=\"checkbox\" />",  
        "title"       => __('Project', 'ThemeStockyard'),  
        "description" => __('Description' , 'ThemeStockyard'),   
        "type"        => __('Categories', 'ThemeStockyard'),  
        //"year"        => __('Year', 'ThemeStockyard'), 
        //"skill"       => __('Skills', 'ThemeStockyard'),
        "photo"     => __('Photo', 'ThemeStockyard'),
        "date"     => __('Date', 'ThemeStockyard'), 
    );    
    return $columns;  
}    
  


   
function ts_portfolio_custom_columns($column) {  
    global $post;  
    switch ($column) {  

        case "type":  
            echo get_the_term_list($post->ID, 'portfolio-category', '', ', ','');  
            break; 
            
        case "description":  
            ts_max_charlength(150);  
            break;     
            
        case "skill":  
            echo get_the_term_list($post->ID, 'portfolio-skill', '', ', ','');  
            break;  
            
        case "year":  
            echo get_the_term_list($post->ID, 'portfolio-year', '', ', ','');  
            break; 
            
        case "photo":  
            echo get_the_post_thumbnail($post->ID, 'thumbnail');
            break;  
    }  
}    


/*-----------------------------------------------------------------------------------*/
/* The Portfolio metaboxes
/*-----------------------------------------------------------------------------------*/
add_filter('cmb_meta_boxes', 'cmb_portfolio_metaboxes');    
function cmb_portfolio_metaboxes(array $meta_boxes) {
    
    $prefix = '_portfolio_';

    $meta_boxes[] = array(
        'id'         => 'portfolio_metaboxes',
        'title'      => __('Portfolio Settings' , 'ThemeStockyard'),
        'pages'      => array('portfolio'),
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true,
        'fields'     => array(
            
            array(
                'name' => __('General Settings' , 'ThemeStockyard'), 
                'desc' => '',
                'type' => 'title',
                'id'   => $prefix . 'title_general_setting'
            ),
                    
            array(
                'name'    => __('Page Layout:' , 'ThemeStockyard'),
                'desc'    => __('Choose a layout type for this portfolio post.' , 'ThemeStockyard'),
                'id'      => $prefix . 'layout',
                'type'    => 'select',
                'options' => array(
                    array('name' => __('Use default', 'ThemeStockyard'), 'value' => 'default'),
                    array('name' => __('2/3 media (left)', 'ThemeStockyard'), 'value' => '2-3-media_1-3-text'),
                    array('name' => __('2/3 media (right)', 'ThemeStockyard'), 'value' => '1-3-text_2-3-media'),
                    array('name' => __('1/2 media (left)', 'ThemeStockyard'), 'value' => '1-2-media_1-2-text'),
                    array('name' => __('1/2 media (right)', 'ThemeStockyard'), 'value' => '1-2-text_1-2-media'),
                    //array('name' => __('1/3 media (left)', 'ThemeStockyard'), 'value' => '1-3-media_2-3-text'),
                    //array('name' => __('1/3 media (right)', 'ThemeStockyard'), 'value' => '2-3-text_1-3-media'),
                    array('name' => __('Fullwidth media', 'ThemeStockyard'), 'value' => 'fullwidth'),               
                )
            ),
                    
            array(
                'name'    => __('Project Content Type:' , 'ThemeStockyard'),
                'desc'    => __('Choose current project content type.' , 'ThemeStockyard'),
                'id'      => $prefix . 'project_type',
                'type'    => 'select',
                'options' => array(
                    array('name' => __('Single Image', 'ThemeStockyard'), 'value' => 'image'),
                    array('name' => __('Gallery', 'ThemeStockyard'), 'value' => 'gallery'),
                    array('name' => 'Youtube', 'value' => 'youtube'),
                    array('name' => 'Vimeo', 'value' => 'vimeo'),
                    array('name' => __('Self-hosted video', 'ThemeStockyard'), 'value' => 'self_hosted_video')                
                )
            ),
            
            array(
                'name' => __('Client Name' , 'ThemeStockyard'),
                'desc' => '',
                'id'   => $prefix . 'client_name',
                'type' => 'text'
            ),
            
            array(
                'name' => __('URL' , 'ThemeStockyard'),
                'desc' => '',
                'id'   => $prefix . 'url',
                'type' => 'text'
            ),
            
            /*array(
                'name'    => __('Remove Top Content Padding', 'ThemeStockyard'),
                'id'      => $prefix . 'remove_top_padding',
                'type'    => 'checkbox',
            ),
            
            array(
                'name'    => __('Remove Bottom Content Padding', 'ThemeStockyard'),
                'id'      => $prefix . 'remove_bottom_padding',
                'type'    => 'checkbox',
            ),*/
            
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
                'name'    => __('Show Project Title in content', 'ThemeStockyard'),
                'id'      => $prefix . 'show_content_title',
                'type'    => 'select',
                'options' => array(
                    array('name' => __('Use default', 'ThemeStockyard'), 'value' => 'default'),
                    array('name' => __('Yes', 'ThemeStockyard'), 'value' => 'yes'),
                    array('name' => __('No', 'ThemeStockyard'), 'value' => 'no'),               
                )
            ),
            
            array(
                'name'    => __('Show &#8220;Previous/Next&#8221; links', 'ThemeStockyard'),
                'id'      => $prefix . 'show_direction_links',
                'type'    => 'select',
                'options' => array(
                    array('name' => __('Use default', 'ThemeStockyard'), 'value' => 'default'),
                    array('name' => __('Yes', 'ThemeStockyard'), 'value' => 'yes'),
                    array('name' => __('No', 'ThemeStockyard'), 'value' => 'no'),               
                )
            ),
            
            array(
                'name'    => __('Show Related Posts', 'ThemeStockyard'),
                'id'      => $prefix . 'related_posts',
                'type'    => 'select',
                'options' => array(
                    array('name' => __('Use default', 'ThemeStockyard'), 'value' => 'default'),
                    array('name' => __('Yes', 'ThemeStockyard'), 'value' => '1'),
                    array('name' => __('No', 'ThemeStockyard'), 'value' => '0'),               
                )
            ),
                        
            array(
                'name' => __('Gallery Settings' , 'ThemeStockyard'),
                'desc' => '',
                'type' => 'title',
                'id'   => $prefix . 'title_image_slider_project'
            ),
                    
            array(
                'name'    => __('Display gallery as:' , 'ThemeStockyard'),
                'desc'    => __('Choose how to display gallery images on single post pages.' , 'ThemeStockyard'),
                'id'      => $prefix . 'gallery_display',
                'type'    => 'select',
                'options' => array(
                    array('name' => __('Flexslider', 'ThemeStockyard'), 'value' => 'flex'),
                    //array('name' => __('Carousel Slider', 'ThemeStockyard'), 'value' => 'carousel'),
                    //array('name' => __('Grid (Masonry)', 'ThemeStockyard'), 'value' => 'masonry'),
                    array('name' => 'Multiple Images', 'value' => 'images'),               
                )
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
                'desc' => '',
                'type' => 'title',
                'id'   => $prefix . 'title_video_project'
            ),
            
            array(
                'name' => __('Youtube URL/ID:' , 'ThemeStockyard'),
                'desc' => '',
                'id'   => $prefix . 'youtube_id',
                'type' => 'text'
            ),
            
            array(
                'name' => __('Vimeo URL/ID:' , 'ThemeStockyard'),
                'desc' => '',
                'id'   => $prefix . 'vimeo_id',
                'type' => 'text'
            ),

            array(
                'name' => __('Self-hosted Video', 'ThemeStockyard'),
                'desc' => __('Upload your own video.', 'ThemeStockyard'),
                'type' => 'file',
                'id'   => $prefix . 'self_hosted_video',
            ),
            
        ),
    );

    return $meta_boxes;
}
