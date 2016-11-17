<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */


define('WP_HOME','http://kcsm.mx/');
define('WP_SITEURL','http://kcsm.mx/'); 


// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'kcsmmx5_wp-kcsm2015');

/** MySQL database username */
define('DB_USER', 'kcsmmx5_wp2015kC');

/** MySQL database password */
define('DB_PASSWORD', 'kCsMwp2015');

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
define('AUTH_KEY',         'CC7ZEBRk9Z71KK2Y77IkW3YqrKskpSQlQ2INZhFbTrrVHJiY7m99SpIl3TTeQ2hx');
define('SECURE_AUTH_KEY',  'j6LW1MVGFcjHjeYVlz0uJdw57rLY7c8wYtdfARdzuRAX2FAHxOtneOPH6rfzL3ah');
define('LOGGED_IN_KEY',    'UHiTh3bbUh3DATxfJp5c1C23corNK19tPQxvIYp6F2fwzK2f3aCZLQzd9MwRfisK');
define('NONCE_KEY',        '8RTTmAgSnfFopnZyU173Uij8JT84WES2a75gELMpkUKzTzbZjABjm8BIUUWqA2lP');
define('AUTH_SALT',        'Uu1dTLw8pVJv6fYKPMJsrve1XonMrGsWqUd0RKGgPxDOUaJZjDKtK6fvSSnIQD4r');
define('SECURE_AUTH_SALT', 'JfC3LwNRCHMmVWv4Smuf5C3kYMs4qyhP4gUJB4X20M1rxtbzaZBts5JtkqPkXeV3');
define('LOGGED_IN_SALT',   'mpXlq4MX41OSB9HlETsRXifdga8FcAWNmtEfgrA181bzSATpW2lq6XZQMVGnxrpg');
define('NONCE_SALT',       'nlnyh6SmFOTW1JzIkJwwGtFbsbFZZcdFqr6fTQcuLbtDli6ctJjZOrPvbqfEp7Mm');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', 'es_ES');

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
