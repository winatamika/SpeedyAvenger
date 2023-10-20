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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'speedyav_dbjan');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'j8oknsy004xbdaruhqhsvpweugjosji5mhjqp5r0bxjzawkm0syjamy1uawmcuwk');
define('SECURE_AUTH_KEY',  'g46ykhbqv52pcq21bh3rmwknmrypqfvfaukbtcql71g1gl69enbxqgs9kpmuka1n');
define('LOGGED_IN_KEY',    '1ncxd6sgnswf4qepna0o0chmo1yz7j0m244t10w6cwpx17y8khkjnjxwxe2v5afd');
define('NONCE_KEY',        'hcdapdgihxpjqo1evixzmpbtihkub9n30joa0q8wxxec1dhuvppqfz5yytdhd4ez');
define('AUTH_SALT',        'ddbpborgjbr10ap6ved0igloz49f6tfbqk3rxm0qsm8mzry7wgxvcemyc0bekhhd');
define('SECURE_AUTH_SALT', 'wrrkweofzeg81al5diz5zrqderxwvt7nfggjc3hua078ec0rtp21ojphhzl1yksn');
define('LOGGED_IN_SALT',   't8udajq9icwqw5kflo2siby9edfx5tiwpbyid3a8a4i8yg2mhtv7f2eahqgxhdb8');
define('NONCE_SALT',       'jy1zpv1qumhanlp10vavyddrjcpnks1lipwib0ua3cwtrjn1geozisxoatdpmcvh');

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
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
//define ('WPLANG', '');
define ('WPLANG', 'id_ID');
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
