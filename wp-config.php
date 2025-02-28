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
define( 'DB_NAME', 'miTienda' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

if ( !defined('WP_CLI') ) {
    define( 'WP_SITEURL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
    define( 'WP_HOME',    $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
}



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
define( 'AUTH_KEY',         'lKiIRpuUiMfkEb6j7z32NzqDdd875eUrTdNUXYwr9IhvI9LWqsTz6OEHOLjEpPE7' );
define( 'SECURE_AUTH_KEY',  '2ajvOd4IyGoZZewzOn8D5a9MqJAnrvDDL12CFEixw0Hbg9F9pb0aNr7eOEdtKSyz' );
define( 'LOGGED_IN_KEY',    'wvqnSIAN5D3XpYB0YIun6AD2WHo96AE5JNZcGzycKADTEBfWMq1wGGlWEfKX2kp3' );
define( 'NONCE_KEY',        '8w8MeHzwFdy7XzckGDW6DCYv77oC22gNHVdjl54JK9F3GHdISxcaGzf5U5hL0gIJ' );
define( 'AUTH_SALT',        'UpZ6t0D3bIhHPtfjfXjmFXblAA8wFHasJUCu46mgBYu4yrlyAoMgNqcDVPTJtgCX' );
define( 'SECURE_AUTH_SALT', 'RrALIQVBXvYhytsq5jstrGksUKJjAopKOj4gLODptBUVv1SZZtBJt7BYaJAEdSrl' );
define( 'LOGGED_IN_SALT',   'rQOMDiZYfNXXIFOZvAyBgxHxuWXsbMChkmzZN5Hdkdf1oNvIfSMDBTv7jTX2AQZV' );
define( 'NONCE_SALT',       '3U0VFq1pwOPxmvKLakw9t29yv8hqw4zPEwvratntvuSI992nHFs3TeDhtp8F2EY2' );
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true); // Guarda los errores en wp-content/debug.log
define('WP_DEBUG_DISPLAY', false); // No muestra los errores en el navegador

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
/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
