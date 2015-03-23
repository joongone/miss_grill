<?php
/*-----------------------------------------------------------------------------------*/
/* The Slider custom post type
/*-----------------------------------------------------------------------------------*/
add_action('after_setup_theme', 'ts_slider_register');
add_action('after_setup_theme', 'ts_slider_post_type_setup');

function ts_slider_post_type_setup() 
{
    add_filter('manage_edit-slider_columns', 'slider_edit_columns');
    add_action('manage_slider_posts_custom_column',  'slider_custom_columns');
}

function ts_slider_register() { 
    global $smof_data;

    $labels = array(
        'name'               => _x('Slider', 'Slider General Name', 'ThemeStockyard'),
        //'menu_name'          => _x('Slider', 'Slider General Name', 'ThemeStockyard'),
        'singular_name'      => _x('Slider Post', 'Slider Singular Name', 'ThemeStockyard'),
        'all_items'          => __('All Slides', 'ThemeStockyard'),
        'add_new'            => _x('Add New', 'Add New Slider Name', 'ThemeStockyard'),
        'add_new_item'       => __('Add New Slider Post', 'ThemeStockyard'),
        'edit_item'          => __('Edit Slider Post', 'ThemeStockyard'),
        'new_item'           => __('New Slider Post', 'ThemeStockyard'),
        'view_item'          => __('View Slider Post', 'ThemeStockyard'),
        'search_items'       => __('Search Slider Posts', 'ThemeStockyard'),
        'not_found'          => __('Nothing found', 'ThemeStockyard'),
        'not_found_in_trash' => __('Nothing found in Trash', 'ThemeStockyard'),
        'parent_item_colon'  => ''
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'exclude_from_search'=> true,
        'publicly_queryable' => true,
        'show_in_nav_menus'  => false,
        'show_ui'            => true,
        'query_var'          => true,
        //'rewrite'            => array("slug" => 'slider'),
        'capability_type'    => 'post',
        //'capabilities'       => array('edit_post','delete_post'),
        'hierarchical'       => false,
        'supports'           => array('title','author','thumbnail')
    ); 

    register_post_type('slider' , $args);
        
    register_taxonomy(
        "slider-category", array("slider"), array(
            "hierarchical"   => true,
            "label"          => "Categories", 
            "singular_label" => "Categories",
            'show_in_nav_menus'  => false,
            "rewrite"        => true));
    register_taxonomy_for_object_type('slider-category', 'slider');
    //flush_rewrite_rules();
}



         
function slider_edit_columns($columns) {  
    $columns = array(  
        "cb"          => "<input type=\"checkbox\" />",  
        "title"       => __('Slide Title', 'ThemeStockyard'),  
        "description" => __('Slide Description' , 'ThemeStockyard'),   
        "type"        => __('Categories', 'ThemeStockyard'), 
        "photo"=> __('Photo', 'ThemeStockyard'), 
        "date"     => __('Date', 'ThemeStockyard'),
    );    
    return $columns;  
}    
  


  
function slider_custom_columns($column) {  
    global $post;  
    switch ($column) {  

        case "type":  
            echo get_the_term_list($post->ID, 'slider-category', '', ', ','');  
            break; 
            
        case "description":  
            ts_max_charlength(150);  
            break;   
            
        case "photo":  
            the_post_thumbnail('thumbnail');
            break;  
    }  
}    


/*-----------------------------------------------------------------------------------*/
/* The Slider metaboxes
/*-----------------------------------------------------------------------------------*/ 
add_filter('cmb_meta_boxes', 'cmb_slider_metaboxes');
function cmb_slider_metaboxes(array $meta_boxes) {
    
    $prefix = '_slider_';

    $meta_boxes[] = array(
        'id'         => 'slider_metaboxes',
        'title'      => __('Slide Settings' , 'ThemeStockyard'),
        'pages'      => array('slider'),
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true,
        'fields'     => array(
                    
            array(
                'name'    => __('Slide Content Type:' , 'ThemeStockyard'),
                'desc'    => __('Choose current slide content type. (Add Youtube or Vimeo URL further down)' , 'ThemeStockyard'),
                'id'      => $prefix . 'slide_type',
                'type'    => 'select',
                'options' => array(
                    array('name' => 'Image', 'value' => 'image'),
                    array('name' => 'Youtube', 'value' => 'youtube'),
                    array('name' => 'Vimeo', 'value' => 'vimeo')                
                    )
            ),
            
            array(
                'name' => __('Description' , 'ThemeStockyard'),
                'desc' => __('Not used with Youtube/Vimeo videos' , 'ThemeStockyard'),
                'id'   => $prefix . 'description',
                'type' => 'textarea_small'
            ),
            
            array(
                'name' => __('Destination URL' , 'ThemeStockyard'),
                'desc' => __('Not used with Youtube/Vimeo videos' , 'ThemeStockyard'),
                'id'   => $prefix . 'url',
                'type' => 'text'
            ),
            
            array(
                'name' => __('Launch URL in new tab?' , 'ThemeStockyard'),
                'desc' => __('Not used with Youtube/Vimeo videos' , 'ThemeStockyard'),
                'id'   => $prefix . 'new_tab',
                'type' => 'checkbox'
            ),
            
            array(
                'name' => __('&#8220;Read more&#8221; button text' , 'ThemeStockyard'),
                'desc' => __('Only used when URL is present (not used with videos). Leave blank to hide.' , 'ThemeStockyard'),
                'id'   => $prefix . 'read_more',
                'type' => 'text',
                'std'  => __('Read More...' , 'ThemeStockyard'),
            ),
            
            array(
                'name' => __('Hide all text?' , 'ThemeStockyard'),
                'desc' => __('This is automatically done for videos' , 'ThemeStockyard'),
                'id'   => $prefix . 'hide_text',
                'type' => 'checkbox'
            ),
            
            array(
                'name' => 'Youtube & Vimeo Slide',
                'desc' => '',
                'type' => 'title',
                'id'   => $prefix . 'video'
            ),
            
            array(
                'name' => __('Vimeo URL/ID here:' , 'ThemeStockyard'),
                'desc' => __('Enter your Vimeo URL or ID here.' , 'ThemeStockyard'),
                'id'   => $prefix . 'vimeo_id',
                'type' => 'text'
            ),
            
            array(
                'name' => __('Youtube URL/ID here:' , 'ThemeStockyard'),
                'desc' => __('Enter your Youtube URL or ID here.' , 'ThemeStockyard'),
                'id'   => $prefix . 'youtube_id',
                'type' => 'text'
            ),
        ),
    );

    return $meta_boxes;
}