<?php

/*----------------------------------------------------------------------------*/
/* Functions - You probably don't want to edit this top bit */
/*----------------------------------------------------------------------------*/
define('TS_PATH', get_template_directory_uri());
define('TS_SERVER_PATH', get_template_directory());
define('TS_PAGEBUILDER_PATH', get_template_directory() . '/includes/plugins/page-builder/blocks/');

$admin_path = TS_SERVER_PATH . '/admin/';
$includes_path = TS_SERVER_PATH . '/includes/';

// Slightly Modified Options Framework
require_once ($admin_path . 'index.php');

// Theme specific functionality
require_once ($includes_path . 'theme-functions.php'); 		// Custom theme functions
require_once ($includes_path . 'theme-post-types.php');		// Theme post types
require_once ($includes_path . 'theme-plugins.php');        // Pre-packaged plugins
require_once ($includes_path . 'theme-dyn-css.php'); 		// Dynamic CSS
require_once ($includes_path . 'theme-shortcodes.php'); 	// Shortcodes
require_once ($includes_path . 'theme-scripts.php');		// Load css & javascript in wp_head
require_once ($includes_path . 'theme-sidebars.php');		// Initialize widgetized areas
require_once ($includes_path . 'theme-widgets.php');		// Theme widgets
require_once ($includes_path . 'theme-metaboxes.php');		// Theme metaboxes

/*-----------------------------------------------------------------------------------*/
/* End Functions - Feel free to add custom functions below */
/*-----------------------------------------------------------------------------------*/




/*
    멀티 이미지 업로드 개수 설정
*/
add_filter('list_images','my_list_images');
//add_filter('list_images','my_list_images',10,2);
function my_list_images(){
    //I only need two pictures
    $picts = array(
        'image1' => '_image1',
        'image2' => '_image2',
        'image3' => '_image3',
        'image4' => '_image4',
        'image5' => '_image5',
        'image6' => '_image6',
        'image7' => '_image7',
        'image8' => '_image8',
        'image9' => '_image9',
        'image10' => '_image10',
        'image11' => '_image11',
        'image12' => '_image12',
        'image13' => '_image13',
        'image14' => '_image14',
        'image15' => '_image15',
        'image16' => '_image16',
        'image17' => '_image17',
        'image18' => '_image18',
        'image19' => '_image19',
        'image20' => '_image20',
    );
    return $picts;
}


/*
    메인 하단 이미지 Nameing 갖고오는 함수
    parameter: $content_id : page($page_id), post($post_id) 값
    return: $bottom_image_names : 업로드된 이미지 key값

*/
function get_bottom_image_names($content_id){
    $bottom_image_count = 0;
    $bottom_image_names = array();
    $bottom_img_lists = get_images_ids(true,$content_id);
    foreach($bottom_img_lists as $key => $value){
        $bottom_image_names[$bottom_image_count] = $key;
        $bottom_image_count++;
    }
    return $bottom_image_names;
}

/*
    메인 하단 이미지 FUll 사이즈 URL 갖고오는 함수
    parameter: $content_id : page($page_id), post($post_id) 값
    return: $bottom_image_names : 업로드된 이미지 URL값

*/
function get_bottom_image_fullsize_file_lists($content_id){

    $bottom_image_names = get_bottom_image_names($content_id);

    $bottom_image_files = array();
    $bottom_image_file_lists = get_multi_images_src('medium','full',false,$content_id);
    for($i=0; $i<count($bottom_image_names); $i++){
        $image_name = $bottom_image_names[$i];

        //full
        $bottom_image_files[$i] = $bottom_image_file_lists[$image_name][1][0];
    }   
    return  $bottom_image_files;
}

/*
    메인 하단 이미지 MEDIUM 사이즈 URL 갖고오는 함수
    parameter: $content_id : page($page_id), post($post_id) 값
    return: $bottom_image_names : 업로드된 이미지 URL값

*/
function get_bottom_image_mediumsize_file_lists($content_id){

    $bottom_image_names = get_bottom_image_names($content_id);

    $bottom_image_files = array();
    $bottom_image_file_lists = get_multi_images_src('medium','full',false,$content_id);
    for($i=0; $i<count($bottom_image_names); $i++){
        $image_name = $bottom_image_names[$i];

        //medium
        $bottom_image_files[$i] = $bottom_image_file_lists[$image_name][0][0];
    }   
    return  $bottom_image_files;
}


/**
 * 변수의 구성요소를 리턴받는다.
 */
function get_printr ($var, $title = NULL, $style = NULL, $title_style = NULL) {

    if( ! $style){
        $style = "background-color:#000; color:#00ff00; padding:5px; font-size:14px; margin: 5px 0";
    }

    if( ! $title_style){
        $title_style = "color:#fff";
    }

    $dump = '';
    $dump .= '<div style="text-align: left;">';
    $dump .= "<pre style='$style'>";
    if ($title) {
        $dump .= "<strong style='{$title_style}'>{$title} :</strong> \n";
    }
    if($var === null){
        $dump .= "`null`";
    }else if($var === true){
        $dump .= "`(bool) true`";
    }else if($var === false){
        $dump .= "`(bool) false`";
    }else{
        $dump .= print_r($var, TRUE);
    }
    $dump .= '</pre>';
    $dump .= '</div>';
    return $dump;
}

/**
 * 변수의 구성요소를 출력한다.
 */
function printr ($var, $title = NULL, $style = NULL, $title_style = NULL) {
    $dump = get_printr($var, $title, $style, $title_style);
    echo $dump;
}

/**
 * 변수의 구성요소를 출력하고 멈춘다.
 */
function printr2 ($var, $title = NULL, $style = NULL, $title_style = NULL) {
    printr($var, $title,  $style, $title_style);
    exit;
}

function register_my_menus() {
    register_nav_menus(
        array( 'test-menu' => __( 'Test Menu' ) )
    );
}
add_action( 'init', 'register_my_menus' );