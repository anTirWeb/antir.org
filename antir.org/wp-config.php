<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'antir_wordpress_prod');

/** MySQL database username */
define('DB_USER', 'antir_wpdbUsr1');

/** MySQL database password */
define('DB_PASSWORD', 'URtZ1BzMYNHRjfq5xApU');

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
define('AUTH_KEY',         '[<>Nw`}oT}w1zZ+fIK;u#^Xp+ySbZ!qFF2dW|YAp9Aw?iE(ZTLpQfA*5$mwtqn4Q');
define('SECURE_AUTH_KEY',  'qT~.1vYH<y4P96aVSeT`UJyANHvL2by>h3vdwZ{ys2yte6>s4hY&PdRmU]hgiC4h');
define('LOGGED_IN_KEY',    '+d_`m4:@ 5txvD<_}`>i*]c?07p|St<s[n}O~VQ|M3711kCwnE1V0Z<jMHM?g=>p');
define('NONCE_KEY',        '|ybxJK`6-]n48%g{9oT1>w9,im[NHp[O/8@K.8RIAc)0p5kI0CG2ekSXT@jKD*,s');
define('AUTH_SALT',        'k,a%MV2ZT~//Ka<b6IGY,jd!@P)=& b^8Z.-wbIS]iL/w7)b%4s4jIM&jg#N)ew#');
define('SECURE_AUTH_SALT', 'C{Bl=%>bt+i@&[R*p9;K20Wh n*g%SmHT%0*|F3/y= WYO/;ME(>S1wQ;7^TPR3E');
define('LOGGED_IN_SALT',   'Oi{%b<:Z}c@>^&UnbuPvd6zN!IXs[|K_Uw^[7=oRFh7);r aRS.y@`/14n$.q?b-');
define('NONCE_SALT',       'j<)%~8Epim9=IV3*5`aHdWz}%QV.~sUg u;iz~,&1qTMd.4={f5q*$kH+%0N84ey');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_r5261';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);
define('WP_MEMORY_LIMIT', '96M');

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
