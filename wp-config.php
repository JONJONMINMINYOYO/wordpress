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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wd-php' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'asd123' );

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
define( 'AUTH_KEY',         '$;G]}(9+M>ZK6m>,o)=b.OLn<^gn8<9QO5g*!Q/nT)sIS5RnZ-mn>y>jhr4)U9G+' );
define( 'SECURE_AUTH_KEY',  '(O~(G+(y$5wa!Xu^&0>.;`)KR$|9$>%,a@zt9yQbN%$c$1L8$CI?y|,ww%[V&;1x' );
define( 'LOGGED_IN_KEY',    'AFP:Q;NDCm*& w#j9:fH et zT^-idM19?&ssP?r!O94/`CGaTv/]LsAq[-UemOY' );
define( 'NONCE_KEY',        'kC 8 `:zyb(/,5sDZ9zNdSiUK(!0%F<0z_7 Y|YF{!4ZK~+@7TQwvpAi b8u:nJ:' );
define( 'AUTH_SALT',        '!9=_A3$9_U,?[ezk4m>_u xSf4I[;x+roR=V[Ssa={E&,yX&CU,:UcNL7FqD/<(n' );
define( 'SECURE_AUTH_SALT', 'bpm)a%n`@{ExUfO-`oVgMQGV*mWYX~)GBeGr2qFXfN3Jk$8=h##}ue >nIGR 3pO' );
define( 'LOGGED_IN_SALT',   'Z6dEAV;[1+#LmQ{No)Vi{?7B0ix%;u>#%+eoNbu<&bunhU_4Fjd@(K@Q6IP!~K__' );
define( 'NONCE_SALT',       'lza}o*V}VQ.hD<WPj+]bMvrg20z1}`^zzRB}J(UV$V0uuH5t(7Er7A>^Vt#?MJf^' );

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
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
