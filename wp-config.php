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
define('DB_NAME', 'SG');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         'k/=7cM~#L$V2QM)ZN:pTt+)w<)91`*@|,}5E/5H,YiK`}7De{Xc|~`?&$om)|QHU');
define('SECURE_AUTH_KEY',  'MB#Ylw6Yt^Q.|er_}XI}x XN7u[)ZjXl:G@P$rXnU?=%k7pz-UX%XH>mwZVQ!{/$');
define('LOGGED_IN_KEY',    'P)k&STCeHM%xFw&dC-gyIYkYr$-kV+}CXg`!`TT,r$KqOw-KL_$]$ vX;-AV+0+J');
define('NONCE_KEY',        '+xLWGA3T:FPKh_|Z?8vg.P R1]USKCTnBd_sZYF)8n(>GRj3l~Yx[^mO{bS|7?FU');
define('AUTH_SALT',        '0BA3~H:c&YrXg<!2VqGpEts/t=?wG6%r&F60$ER>=<pnj-=1%uG16[Kjj8/9vAx(');
define('SECURE_AUTH_SALT', 'YEjaBk{+Y;qV{-lCnyy`PN:t>DU,HRc}GAZDOg5$<h~v<DpxI|2*$EGD56Ac-46R');
define('LOGGED_IN_SALT',   'K GjfZUvZW1;a)|TOl}{*ZP)uZkTYBO(1B1(VJ9vY@h[Nf*be% x3JqT7UOAvVrq');
define('NONCE_SALT',       '|2-;{[D^>7fh7K(+<{}1?DG~?duYND%AgE3. l%+nfzj!b&]%9u`PX@.xW,.?Z{x');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', true);

define('WP_MEMORY_LIMIT', '512M'); // WooCommerce sites need this for some reason

define('DISALLOW_FILE_EDIT', true); // Theme and plugin editor

define('WP_POST_REVISIONS', 30);


/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
