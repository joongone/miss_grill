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