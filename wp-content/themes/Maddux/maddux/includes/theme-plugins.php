<?php
/*-----------------------------------------------------------------------------------

- Loads all the .php files found in /includes/plugins/ directory

----------------------------------------------------------------------------------- */

include( TS_SERVER_PATH . '/includes/plugins/twitter/twitter.php' );
include( TS_SERVER_PATH . '/includes/plugins/multiple_sidebars.php' );
require_once(TS_SERVER_PATH . '/includes/plugins/tgm-plugin-activation/activate-plugins.php');
/*
if(defined('ICL_SITEPRESS_VERSION')) :
    include( TS_SERVER_PATH . '/includes/plugins/wpml.php' );
endif;
*/
