<?php
/**
 * Register, deregister, enqueue, dequeue your
 * styles, scripts and other assets.
 *
 * @package WordPress
 * @subpackage WPThemeScaffold
 *
 * @author Rareview <hello@rareview.com>
 */

namespace WPThemeScaffold\Theme;

/**
 * Hook it up!
 */
class Asset_Pipeline {

	/**
	 * A constructor.
	 */
	public function __construct() {
		// https://developer.wordpress.org/reference/hooks/wp_enqueue_scripts/.
		\add_action( 'wp_enqueue_scripts', [ __CLASS__, 'frontend' ] );
		// https://make.wordpress.org/core/2021/07/01/block-styles-loading-enhancements-in-wordpress-5-8/.
		\add_filter( 'should_load_separate_core_block_assets', '__return_true' );
		// https://make.wordpress.org/core/2021/07/01/block-styles-loading-enhancements-in-wordpress-5-8/#inlining-small-assets.
		\add_filter( 'styles_inline_size_limit', '__return_zero' );
		// Selectively enqueue WP Admin styles.
		\add_action( 'admin_enqueue_scripts', [ __CLASS__, 'admin' ] );
	}

	/**
	 * Enqueue front end styles.
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
	 *
	 * @return void
	 */
	public static function frontend() {

		\wp_enqueue_style(
			'theme-frontend',
			get_template_directory_uri() . '/dist/frontend-css.css',
			[],
			WPTHEMESCAFFOLD_THEME_VERSION,
		);

		\wp_enqueue_script(
			'theme-frontend',
			get_template_directory_uri() . '/dist/frontend-js.js',
			[],
			WPTHEMESCAFFOLD_THEME_VERSION,
			true
		);

		/**
		 * Dequeue (remove) jQuery from front end, unless the user is logged in
		 * as some items in the admin bar require it.
		 */
		if ( ! is_admin() && ! is_user_logged_in() ) {
			wp_deregister_script( 'jquery' );

			/**
			 * We often use Query Monitor. If we are, then this
			 * tell it to not look for jQuery as a dependency.
			 * https://querymonitor.com/docs/configuration-constants/
			 */
			if ( defined( 'QM_NO_JQUERY' ) ) {
				define( 'QM_NO_JQUERY', true );
			}
		}

		// Remove Dashicons if user is not logged in.
		if ( ! is_user_logged_in() ) {
			wp_deregister_style( 'dashicons' );
		}

		// Unregister WP core block styles.
		wp_deregister_style( 'wp-block-group' );

		if ( defined( 'WP_DEBUG_DISPLAY' ) ) {
			\wp_enqueue_style(
				'theme-debug',
				get_template_directory_uri() . '/dist/debug-css.css',
				[],
				WPTHEMESCAFFOLD_THEME_VERSION,
			);
		}
	}

	/**
	 * Enqueue WP Admin scripts, but be mindful of where you enqueue them.
	 *
	 * @link https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/
	 *
	 * @param string $hook The current admin page.
	 *
	 * @return void
	 */
	public static function admin( $hook ) {
		if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
			return;
		}

		\wp_enqueue_style(
			'theme-admin-styles',
			get_template_directory_uri() . '/dist/admin-css.css',
			[],
			WPTHEMESCAFFOLD_THEME_VERSION,
		);
	}

}
