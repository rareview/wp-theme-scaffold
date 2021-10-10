<?php
/**
 * Main file for the theme.
 *
 * @package WordPress
 * @subpackage WPThemeScaffold
 *
 * @author Rareview <hello@rareview.com>
 */

// Useful global constants.
define( 'WPTHEMESCAFFOLD_THEME_VERSION', '0.1.0' );
define( 'WPTHEMESCAFFOLD_THEME_TEMPLATE_URL', get_template_directory_uri() );
define( 'WPTHEMESCAFFOLD_THEME_PATH', get_template_directory() . '/' );

// Require Composer autoloader if it exists.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require_once __DIR__ . '/vendor/autoload.php';
}

new WPThemeScaffold\Theme\Theme_Setup();

/**
 * Custom template tags for the theme.
 */
require_once get_parent_theme_file_path( 'lib/Template_Tags.php' );
