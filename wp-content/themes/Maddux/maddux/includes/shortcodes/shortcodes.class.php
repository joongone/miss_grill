<?php
class tsShortcodes {

    public static $_dir;
    public static $_url;

    function __construct()
    {
        // Windows-proof constants: replace backward by forward slashes. Thanks to: @peterbouwmeester
        self::$_dir     = trailingslashit( str_replace( '\\', '/', dirname( __FILE__ ) ) );
        $wp_content_dir = trailingslashit( str_replace( '\\', '/', WP_CONTENT_DIR ) );
        $relative_url   = str_replace( $wp_content_dir, '', self::$_dir );
        $wp_content_url = ( is_ssl() ? str_replace( 'http://', 'https://', WP_CONTENT_URL ) : WP_CONTENT_URL );
        self::$_url     = trailingslashit( $wp_content_url ) . $relative_url;

    	require_once( 'shortcodes.php' );	
		define('TS_TINYMCE_URI', get_template_directory_uri().'/includes/shortcodes/tinymce');
		define('TS_TINYMCE_DIR', get_template_directory().'/includes/shortcodes/tinymce');
		

        add_action('init', array(&$this, 'init'));
        add_action('admin_init', array(&$this, 'admin_init'));
        add_action('wp_ajax_ts_shortcodes_popup', array(&$this, 'popup'));
	}

	/**
	 * Registers TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function init()
	{
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;

		if ( get_user_option('rich_editing') == 'true' )
		{
			add_filter( 'mce_external_plugins', array(&$this, 'add_rich_plugins') );
			add_filter( 'mce_buttons', array(&$this, 'register_rich_buttons') );
		}

	}

	// --------------------------------------------------------------------------

	/**
	 * Define TinyMCE rich editor js plugin
	 *
	 * @return	void
	 */
	function add_rich_plugins( $plugin_array )
	{
        global $wp_version;
        
        $ts_wp_version = preg_replace("/[^0-9\.]/", "",$wp_version);
        
		if( is_admin() ) {
            /*
            if($ts_wp_version < '3.9') {
                $plugin_array['tsShortcodes'] = TS_TINYMCE_URI . '/tinymce-legacy.js';
			} else {
                $plugin_array['ts_button'] = TS_TINYMCE_URI . '/tinymce.js';
			}
			*/
			$plugin_array['ts_button'] = TS_TINYMCE_URI . '/tinymce.js';
		}

		return $plugin_array;
	}

	// --------------------------------------------------------------------------

	/**
	 * Adds TinyMCE rich editor buttons
	 *
	 * @return	void
	 */
	function register_rich_buttons( $buttons )
	{
		array_push( $buttons, "|", 'ts_button' );
		return $buttons;
	}

	/**
	 * Enqueue Scripts and Styles
	 *
	 * @return	void
	 */
	function admin_init()
	{
		// css
		wp_enqueue_style( 'ts-popup', TS_TINYMCE_URI . '/css/popup.css', false, '1.0', 'all' );
		wp_enqueue_style( 'jquery.chosen', TS_TINYMCE_URI . '/css/chosen.css', false, '1.0', 'all' );
		wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css', false, '4.3.0', 'all' );
		wp_enqueue_style( 'wp-color-picker' );

		// js
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-livequery', TS_TINYMCE_URI . '/js/jquery.livequery.js', false, '1.1.1', false );
		wp_enqueue_script( 'jquery-appendo', TS_TINYMCE_URI . '/js/jquery.appendo.js', false, '1.0', false );
		wp_enqueue_script( 'base64', TS_TINYMCE_URI . '/js/base64.js', false, '1.0', false );
		wp_enqueue_script( 'jquery.chosen', TS_TINYMCE_URI . '/js/chosen.jquery.min.js', false, '1.0', false );
    	wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'ts-popup', TS_TINYMCE_URI . '/js/popup.js', false, '1.0', false );

		// Dev mode
		$dev_mode = 'false';
		if(function_exists('ts_option_vs_default')) {
            $dev_mode = (ts_option_vs_default('shortcode_dev_mode', 0) == 1) ? 'true' : 'false';
		} elseif(function_exists('ts_option_vs_default')) {
            $dev_mode = (ts_option_vs_default('shortcode_dev_mode', 0) == 1) ? 'true' : 'false';
		}
		
		global $wp_version;
        
        $ts_wp_version = preg_replace("/[^0-9\.]/", "",$wp_version);

		wp_localize_script( 'jquery', 'tsShortcodes', array('theurl' => TS_TINYMCE_URI, 'dev' => $dev_mode, 'wp_version' => $ts_wp_version) );
	}

	/**
	 * Popup function which will show shortcode options in thickbox.
	 *
	 * @return void
	 */
	function popup() {

		require_once( TS_TINYMCE_DIR . '/ts-sc.php' );

		die();

	}

}
$ts_shortcodes_obj = new tsShortcodes();