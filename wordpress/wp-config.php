<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '80901964' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '[Fre7sp>&PSs|jWW^(M`QFLBw9cZWns5e(,(C!Scd3:xe$:4+]?4M(WM?ai+uspK' );
define( 'SECURE_AUTH_KEY',  'M$=X3P{wfKyEL0i@&t^m!pMAdkq{(c~wZj|g`[C63$-iL2g+P`&,UNon.jS@lb2l' );
define( 'LOGGED_IN_KEY',    'W]F48V_HqdbS`8AbSE5K:tZ1Tk-^i)v2qc!Z,2J?wSk.XIDp/yKkGX]!mU6!|:)E' );
define( 'NONCE_KEY',        '~s1z@odKphWN| xsBM_p.@/Pr$]^4DU=8m;][ajYJJvD=DMnz}#JX+YPVhK_n2In' );
define( 'AUTH_SALT',        'fh_MQIsMMZ<auU:op>/q4jd(o5>SLWXWDd5q,irYLLdBpIrMy8KP]T;]^#mpg,,^' );
define( 'SECURE_AUTH_SALT', 'wwJ<$d3P<n2Lq8iMd(XQ=? iYzT7E:vHfTCLYE]uxI$?!#]:g}}[PFiA*vBS`l*Q' );
define( 'LOGGED_IN_SALT',   'd$RoV6Di|jN=VT{3|H5!P[0ueCBNulKg,u`~[snst1V}gv&_pT7IHJ=GJ>LsHy8(' );
define( 'NONCE_SALT',       'IL3M+D!O0^T;9?3.llVM+q6|6Eo@F797sTqgG$=`e$R).%J/);Cd<qy~FR:Rhc-#' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
