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
define( 'DB_NAME', 'proyecto' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         '~hI~m]VM[#V5oy1FZL(I9.Q>Z>5D6X))Jf,8 Iuf0WW5wn])j}m3:G./_U5R^$_D' );
define( 'SECURE_AUTH_KEY',  '(t}}e-6?Mr2OdDB<R!J,0Hs$?:(%^`RZ+@]Vd<h(y?Sp}dqkqaktR:[b{JJ*-r@M' );
define( 'LOGGED_IN_KEY',    ';hNgCDZzA@tw(zCLdUJY]P.P/)V~gHM1.C[e,hx3;RoLwq;b2a6Qz+o&bc3QtKF)' );
define( 'NONCE_KEY',        'xofP>N#^N-iu1/bUwNM3sRm>%rI`|KOKME#%*eZ=VMU<ssB.<~BEkx] u-EQU[:j' );
define( 'AUTH_SALT',        'zE)DGh&EaAC)U2d@fZmhJYc#DA88M5*[2rsS{(|%oh?StYG<r0=46fFrhu(6XQkF' );
define( 'SECURE_AUTH_SALT', ';V2g8 vD:iqISF.nP/yqqr^obb6Bw_GM`.I>|C&`Z#>T!Hyhb3J}l,i(JC|JYt:r' );
define( 'LOGGED_IN_SALT',   'pB1h%0BcYScm-!>4=`J|w JR;!_0`}QT,MSxQ!E|5Zc~Sm+s$Hi28%Ag;]Vax(u!' );
define( 'NONCE_SALT',       '6uB.<+,kt3g/0ipu`BJ.k~:aQQ,Yq2jYJhT@Y86rCml`CbSk8k5{YY+Ud@c#kj+1' );

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
