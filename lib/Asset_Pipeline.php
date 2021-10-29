<?php
/**
 * Register, deregister, enqueue, dequeue your
 * styles, scripts and other assets.
 *
 * @package WordPress
 * @subpackage WPThemeScaffold
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
		// Selectively enqueue WP Admin styles.
		\add_action( 'admin_enqueue_scripts', [ __CLASS__, 'admin' ] );
		// Inline the theme's fonts in block editor.
		\add_action( 'admin_init', [ __CLASS__, 'block_editor_inline_fonts' ] );
	}

	/**
	 * Enqueue front end styles.
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
	 *
	 * @return void
	 */
	public static function frontend() {
		// Register style.
		\wp_register_style(
			'theme-frontend',
			'',
			'',
			WPTHEMESCAFFOLD_THEME_VERSION,
		);

		// Add styles inline.
		\wp_add_inline_style(
			'theme-frontend',
			self::get_font_face_styles(),
		);

		// Add metadata to stylesheet.
		\wp_style_add_data(
			'theme-frontend',
			'path',
			get_template_directory_uri() . '/dist/frontend-css.css',
		);

		// Enqueue style.
		\wp_enqueue_style(
			'theme-frontend',
		);

		// Enqueue script.
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

		if ( defined( 'WP_DEBUG_DISPLAY' ) && true === WP_DEBUG_DISPLAY ) {
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

	/**
	 * Inline the theme's fonts in the block editor.
	 *
	 * @return void
	 */
	public static function block_editor_inline_fonts() {
		wp_add_inline_style(
			'wp-block-library',
			self::get_font_face_styles()
		);
	}

	/**
	 * Get font face styles.
	 *
	 * @return string
	 */
	public static function get_font_face_styles() {
		return "
		/* libre-franklin-200 - latin */
		@font-face {
			font-display: swap;
			font-family: 'Libre Franklin';
			font-style: normal;
			font-weight: 200;
			src: url('" . get_theme_file_uri( 'dist/fonts/Libre_Franklin/libre-franklin-v7-latin-200.woff2' ) . "') format('woff2');
		}
		/* libre-franklin-regular - latin */
		@font-face {
			font-display: swap;
			font-family: 'Libre Franklin';
			font-style: normal;
			font-weight: 400;
			src: url('" . get_theme_file_uri( 'dist/fonts/Libre_Franklin/libre-franklin-v7-latin-regular.woff2' ) . "') format('woff2');
		}
		/* libre-franklin-700 - latin */
		@font-face {
			font-display: swap;
			font-family: 'Libre Franklin';
			font-style: normal;
			font-weight: 700;
			src: url('" . get_theme_file_uri( 'dist/fonts/Libre_Franklin/libre-franklin-v7-latin-700.woff2' ) . "') format('woff2');
		}
		";
	}
}
