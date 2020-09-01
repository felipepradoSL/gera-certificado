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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'spx143667409096' );

/** MySQL database username */
define( 'DB_USER', 'spx143667409096' );

/** MySQL database password */
define( 'DB_PASSWORD', 'c,PpQJ2HBo' );

/** MySQL hostname */
define( 'DB_HOST', 'spx143667409096.db.43667409.fb9.hostedresource.net:3309' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '@b)X5S2ELXsJ@GGN&m8E' );
define( 'SECURE_AUTH_KEY',  'wFwkUCWW/=x)5mI@2U d' );
define( 'LOGGED_IN_KEY',    'T$jM-B/psbnTa&PJ/EaR' );
define( 'NONCE_KEY',        'r8Cg z4 gP&qw_pEME6L' );
define( 'AUTH_SALT',        'g55kwJgbD9Y&U$1#rb&z' );
define( 'SECURE_AUTH_SALT', 'IO8CZakq+F1*2Kw*nEL_' );
define( 'LOGGED_IN_SALT',   '29KM7W4=g7m!0qQmY2g1' );
define( 'NONCE_SALT',       'JkZ%MMO+F+CGLj*anb7P' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_jh277tsxsv_';

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );
//define( 'WP_CACHE', true );
require_once( dirname( __FILE__ ) . '/gd-config.php' );
define( 'FS_METHOD', 'direct' );
define( 'FS_CHMOD_DIR', (0705 & ~ umask()) );
define( 'FS_CHMOD_FILE', (0604 & ~ umask()) );


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';