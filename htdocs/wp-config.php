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
define( 'AUTH_KEY',         'o)35:8rK,(}8j=ZBX}r<X[z]= =w^Y %D$q691W%R<15XW92<n9%I612-oD^k)j&' );
define( 'SECURE_AUTH_KEY',  'YJ$(QvmB+}}Dq_.EXmi&z<D#uNV5Bmn>*./RKrfFqoScRrI}P|hJ_`/,J/.L^Tof' );
define( 'LOGGED_IN_KEY',    ' 50/0W$%sLy?+u[xk-{v++s;fi<*m0%4)^5KOkX?]r]w!p^]XkU#5$%-SK+v.dn}' );
define( 'NONCE_KEY',        '|e1M  2eVtB}]KH[^J^n`<!<?m&n=O7H5:{*;Wy7r~O5v.OetEHB]KF1..L`<m0V' );
define( 'AUTH_SALT',        'aTiK-w:/*%<(xN@*D XbaWO6c m-!E/e{aDf&Vq>W9bI[Ya#&BanNb#tN&-Hu#:+' );
define( 'SECURE_AUTH_SALT', 'viKyUgiq2EEha+(;JX|J3Xg]*V%fOC[gBIsUT*jhjpaRrBMpAvYMz:&$>Aah3Ik~' );
define( 'LOGGED_IN_SALT',   'I^Y.W(Xx<H-:=.Zi-9$+.Hbn*9R2(YS*TrA7nKa1HXl^ux9L;lV!Nl]hA,R:S)e#' );
define( 'NONCE_SALT',       '&z=}D_uvV`<&=c7saTUc*7`ShxV[-yu2LVQg;yOu<C+HJB(^bmlN!&GXw5[e?wJJ' );

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
$table_prefix = 'wp1_';

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

