<?php
define('WP_HOME','http://joberli.ru');
define('WP_SITEURL','http://joberli.ru');
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
define('DB_NAME', 'a0217392_jobru');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'sINF<rjN6t<`ml#Q:*T)-JJf=On~#$YkCY!,?4eo~}b^W& !&jXDy4Z;c7%vH.{*');
define('SECURE_AUTH_KEY',  'z)aNq.Q _?uzT{S*l=Xgx{k7+73.27F>2A[/r}fnHe&EMtla,!}p4$^oct/YlSqr');
define('LOGGED_IN_KEY',    'zrlsg:zO,2+k.&f(*7,ZG;5j%F+M#ft%[q`=.CqCTFlaRhF1k<C,>u@UZtCp:4c+');
define('NONCE_KEY',        ',r7me>L ^ybJ4q(%*$/xY.H`x|8TBf:k1Jy2n~Wnk p[2BV3uj6-M?%uM27sIl?4');
define('AUTH_SALT',        '6 AjR,)i]SK J<1_nsgbs~ew+x[d[ntte>^2CPqDQ=Pceo~mYr3S9$8 dJQYKCGi');
define('SECURE_AUTH_SALT', 'M lG`>|.%gv[d*8PM;5/=_aco:!{*/cG0=-_p+Hnn@+6[Ji3<dx5X{$NlOgen]5Z');
define('LOGGED_IN_SALT',   'Ug!v/T-1E&ejc/9P;d7:AZ_R(1ATqM:RhTeg-FmUFg$Mmb=ZM.P.8}^M75Z;Y4rU');
define('NONCE_SALT',       'AJLWQs<TMot8|GKy>vV/P@McD/HC[0yti~cckST:zV;H_O^+/U[Y.(zKw:sVKhn=');

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
