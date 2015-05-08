<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
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
define('DB_NAME', 'saladmaster');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '2 |kAMkzH@0A&.a#q|kCyTI56Hu};;[8E3E]BxmS4YG5:+${]v7Z+Ly.r|0P|=04');
define('SECURE_AUTH_KEY',  'bE$YYdFB#%$2<LAx*37%Xhh$auD,`GEM~=vJDLeXy.NlaYl-`6X/[8-G>; -Wp-A');
define('LOGGED_IN_KEY',    '~(<F#5j0:yLL!WXN~<)|%H2M_(Xv.C$I~K(BAhVL/!i#G*0:O:xuw43RUOSlZ5jl');
define('NONCE_KEY',        ':YRt4qP`U;C#V7dJG@#]Q3lTr&}D?IR8dy8Hp-Q%e^Ct,$P_g;0[3QHyCkH#^X8<');
define('AUTH_SALT',        'LF)ES}X<x-XbL&[mX!:&ea?,p/ge!!Y.1K]y!i?;t4s+#V-q|,J`pvYkG4=h:A--');
define('SECURE_AUTH_SALT', 'xV2F131T^W{--|(+h0[73!eu>pXx  3n3KQXj{h.gNv]t18X|J)9iSZ UFD7IWr/');
define('LOGGED_IN_SALT',   'Z5sMe2D`F4(8V{PyNLSv_8WJS9U.5HvLl~16+EOKe@XU!`m);VbzR&?h3:e3~mg2');
define('NONCE_SALT',       '%|7o-q(A|@O>*MU5[$-n*+T3}6@{4M VDF[oS|LpJ2<W%Md4B/gv7.n^*[6ZHBs|');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'saladmaster_';

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
