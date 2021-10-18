<?php
/**
 * Registers instances where we will override default WP Core behavior.
 *
 * @package WordPress
 * @subpackage WPThemeScaffold
 */

namespace WPThemeScaffold\Theme;

/**
 * Kick if off.
 */
class Cleanup_Core_Assets {

	/**
	 * A constructor.
	 *
	 * @link https://developer.wordpress.org/reference/hooks/after_setup_theme/
	 */
	public function __construct() {
		// Remove the Emoji detection script.
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );

		// Remove inline Emoji detection script.
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );

		// Remove Emoji-related styles from front end and back end.
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );

		// Remove Emoji-to-static-img conversion.
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

		\add_filter( 'tiny_mce_plugins', [ __CLASS__, 'disable_emojis_tinymce' ] );
		\add_filter( 'wp_resource_hints', [ __CLASS__, 'disable_emoji_dns_prefetch' ], 10, 2 );

		// Remove WordPress generator meta.
		remove_action( 'wp_head', 'wp_generator' );
		// Remove Windows Live Writer manifest link.
		remove_action( 'wp_head', 'wlwmanifest_link' );
		// Remove the link to Really Simple Discovery service endpoint.
		remove_action( 'wp_head', 'rsd_link' );
	}

	/**
	 * Filter function used to remove the TinyMCE emoji plugin.
	 *
	 * @link https://developer.wordpress.org/reference/hooks/tiny_mce_plugins/
	 *
	 * @param  array $plugins An array of default TinyMCE plugins.
	 * @return array          An array of TinyMCE plugins, without wpemoji.
	 */
	public static function disable_emojis_tinymce( $plugins ) {
		if ( is_array( $plugins ) && in_array( 'wpemoji', $plugins, true ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		}

		return $plugins;
	}

	/**
	 * Remove emoji CDN hostname from DNS prefetching hints.
	 *
	 * @link https://developer.wordpress.org/reference/hooks/emoji_svg_url/
	 *
	 * @param  array  $urls          URLs to print for resource hints.
	 * @param  string $relation_type The relation type the URLs are printed for.
	 * @return array                 Difference betwen the two arrays.
	 */
	public static function disable_emoji_dns_prefetch( $urls, $relation_type ) {
		if ( 'dns-prefetch' === $relation_type ) {
			/** This filter is documented in wp-includes/formatting.php */
			$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );

			$urls = array_values( array_diff( $urls, array( $emoji_svg_url ) ) );
		}

		return $urls;
	}
}
