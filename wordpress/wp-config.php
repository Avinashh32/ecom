<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'shop_db' );

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
define( 'AUTH_KEY',         '!b^ZFP8k:tBY_!,}_wx<6&`<!Mn*Wlov.toe]?2Mu+wKa|Jf&QCF<rP-E>_etpD^' );
define( 'SECURE_AUTH_KEY',  '*&{F&=%Vz/?ke=vF=8woJ8N+d+Mt(*+Y9tvspU _}H=T:^`}2hRE7i[6fh%0ub1)' );
define( 'LOGGED_IN_KEY',    'r:U &!z#S#n[t)VhsS1=nk}RrS!EB^(Kxt0f@O].~eC3s}gS?F>jg|C+tOfwe*.J' );
define( 'NONCE_KEY',        'J&IxWQbI cqAT>4aw$dO$R@CU),3mY{asRR7U$qTXEyL{|XF<[5*@g.>fSLI;s8M' );
define( 'AUTH_SALT',        'vw~W==k8Z(KP<F;S?Nj?Zgz>YK@3=/-T;I_:3N-1X/b|oM`y-1%.iAffU*yeDRsL' );
define( 'SECURE_AUTH_SALT', '4rn&Py;?/,wjf@f_0O?8Q+8s<Ha7{/}Y_oj(lp-K|!XL~=SW#8vl]<;4eBrQ-O(@' );
define( 'LOGGED_IN_SALT',   'CIup;;[tZs0pY%H0ZUXsO~Dl*Z+j&lBi:e(>D3?C@R P*Xr,T!0x6xbLaTw:)@b<' );
define( 'NONCE_SALT',       'L32#oAb={O+w${IY*0G#VHfj7P=Xyim*PMs9eeG uwWQ0.DBQC?S$-y,MwOVX:X]' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
