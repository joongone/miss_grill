<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'miss_grill');

/** MySQL database username */
define('DB_USER', 'miss_grill');

/** MySQL database password */
define('DB_PASSWORD', 'miss!grill');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '}Yhjd]M<BYS.||h,<^$5U}-[D CPW9Wsyg>1<*4o(wRZ**;8w_va|zP$Ui3lHp.r');
define('SECURE_AUTH_KEY',  'w?)1@];~UrGlDPL|{kR27?&JQcB$(N^{n[$HuZ)Ox+oIJW|5%|zzk,ls[+60ejwu');
define('LOGGED_IN_KEY',    'YAnPV4O(|H5eQQVT2??<YG}LB.P]:JiUkuh~gOYbzMtXq+%|4$|=fQuJ%Qnfbt)?');
define('NONCE_KEY',        ';c+Q8!{Bx&2ZfBv3OdCuRJM+h[D]Eq(46`J|:!Xuw;%uI+uo<:k7)l3>%d;HAB@I');
define('AUTH_SALT',        '@-2ebnIxiMq!q^<Uwv!X.6#j+$a%6Y);pCyWaXt_,H-45h1)I%C`nw)L+:9ZV=f ');
define('SECURE_AUTH_SALT', 'hNRbf,k-w@{!l8>?*D<<-vyyMCG$$1et!@2#vN1bvi~[tjJRFbVY;)M`#<[ vTXZ');
define('LOGGED_IN_SALT',   'UtCzr/V_OIJr4)j~_sgDvRL7w1=X;k;w_=hv{b6Knzge!uZ=e&ArU3Bae%3QF6Ln');
define('NONCE_SALT',       '-6ei,UZsy0{369@jd2=U#101`g6`xus7zyt^OugwU]SD]mbjS>el_fG}/ia0(%|@');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
