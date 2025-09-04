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
define( 'DB_NAME', 'wordpress_stock' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'admin' );

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
define( 'AUTH_KEY',         'o;O|$.sSmfa?: &cp`dskjc[a<Ki5_NYF{anyQOLC<zlOc,~B2$4R6AoQlGzaF&o' );
define( 'SECURE_AUTH_KEY',  '{wS!UAcZo,Jt`|Z.GKV^V]UE7)ak[9Mu=(6x$iGvOV9MY6=JGV7iP@O8H|K:pk3{' );
define( 'LOGGED_IN_KEY',    'se4R7/CE)nKhq>*0kJT2l%<l`4ej93S6^M2P+I%)<gmnu^$>2:4h4L:5d?%ajb:x' );
define( 'NONCE_KEY',        '::Bc|sBb4E82I;?o)Ian7<zst-I@,8A( k(X<{50 0|.f/nwI8%!{;Lq1I-0?u.}' );
define( 'AUTH_SALT',        '1.UEL;6fCSjJwygHJ=Mrf0bAT^U0ISKr._fJ_4T-,m=- %$mv?Wk*u*k>qvlQZ5y' );
define( 'SECURE_AUTH_SALT', 'k:.t,j41:y6>#0U03kC#XsbYP;EzGA(0d<gC8,Xipx[HF9HLor_i>~4-,;8Zjcis' );
define( 'LOGGED_IN_SALT',   '7o7b*d,exaIqJ7z_hj`9ur) #L*(u@kG&gVNVG?vSr7+bxbz_g#LDj=`W8uHpmE5' );
define( 'NONCE_SALT',       'rmco!Aku1*o(nPOU4J*,B7+ikZ=1+=~aJ]Xer:?#00b]Gf4I{d16MNZZfs$Nrf(o' );

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
