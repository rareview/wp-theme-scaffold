<?php
/**
 * Basic theme setup routines.
 *
 * @package WordPress
 * @subpackage WPThemeScaffold
 *
 * @author Rareview <hello@rareview.com>
 */

namespace WPThemeScaffold\Theme;

/**
 * WordPress add_theme_support()
 */
class Theme_Setup {

	/**
	 * A constructor.
	 *
	 * @link https://developer.wordpress.org/reference/hooks/after_setup_theme/
	 */
	public function __construct() {
		\add_action( 'after_setup_theme', [ __CLASS__, 'supports' ] );
	}

	/**
	 * All the theme supports.
	 * These have the potential to all be moved in to theme.json at some point.
	 * See Gutenberg Issue: https://github.com/WordPress/gutenberg/issues/26901
	 *
	 * @link https://developer.wordpress.org/reference/functions/add_theme_support/
	 *
	 * @return void
	 */
	public static function supports() {

		// Add support for post thumbnails.
		// https://developer.wordpress.org/reference/functions/add_theme_support/#post-thumbnails.
		\add_theme_support( 'post-thumbnails' );

		// Enable aspect ration embed support.
		// https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#responsive-embedded-content.
		\add_theme_support( 'responsive-embeds' );

		// Enable our usage of custom Block Editor styles.
		// https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#editor-styles
		\add_theme_support( 'editor-styles' );

		// Set target for Block Editor styles.
		// https://developer.wordpress.org/block-editor/how-to-guides/themes/theme-support/#enqueuing-the-editor-style
		\add_editor_style( 'editor.css' );

		// Remove WP core's block patterns.
		\remove_theme_support( 'core-block-patterns' );
	}
}
