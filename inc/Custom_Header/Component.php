<?php
/**
 * WP_Rig\WP_Rig\Custom_Header\Component class
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig\Custom_Header;

use WP_Rig\WP_Rig\Component_Interface;
use WP_Rig\WP_Rig\Templating_Component_Interface;
use function WP_Rig\WP_Rig\wp_rig;
use function add_action;
use function add_theme_support;
use function apply_filters;
use function get_header_textcolor;
use function get_theme_support;
use function display_header_text;
use function esc_attr;
use function esc_url;
use function get_header_image;

/**
 * Class for adding custom header support.
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 */
class Component implements Component_Interface, Templating_Component_Interface {

	/**
	 * Gets the unique identifier for the theme component.
	 *
	 * @return string Component slug.
	 */
	public function get_slug() : string {
		return 'custom_header';
	}

	/**
	 * Adds the action and filter hooks to integrate with WordPress.
	 */
	public function initialize() {
		add_action( 'after_setup_theme', array( $this, 'action_add_custom_header_support' ) );
	}

	/**
	 * Adds support for the Custom Logo feature.
	 */
	public function action_add_custom_header_support() {
		add_theme_support(
			'custom-header',
			apply_filters(
				'wp_rig_custom_header_args',
				array(
					'default-image'      => '',
					'default-text-color' => '000000',
					'width'              => 1600,
					'height'             => 250,
					'flex-height'        => true,
					'wp-head-callback'   => array( $this, 'wp_head_callback' ),
				)
			)
		);
	}

	/**
	 * Outputs extra styles for the custom header, if necessary.
	 */
	public function wp_head_callback() {
		$header_text_color = get_header_textcolor();

		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		if ( ! display_header_text() ) {
			echo '<style type="text/css">.site-title, .site-description { position: absolute; clip: rect(1px, 1px, 1px, 1px); }</style>';
			return;
		}

		echo '<style type="text/css">.site-title a, .site-description { color: #' . esc_attr( $header_text_color ) . '; }</style>';
	}

	/**
	 * Outputs the necessary inline style elements when a custom header image is available.
	 */
	public function inline_header_image() {
		if ( ! has_header_image() ) {
			return;
		}

		echo 'style="background-image: url(' . esc_url( get_header_image() ) . ')"';
	}

	/**
	 * Gets template tags to expose as methods on the Template_Tags class instance, accessible through `wp_rig()`.
	 *
	 * @return array Associative array of $method_name => $callback_info pairs. Each $callback_info must either be
	 *               a callable or an array with key 'callable'. This approach is used to reserve the possibility of
	 *               adding support for further arguments in the future.
	 */
	public function template_tags() : array {
		return array(
			'inline_header_image' => array( $this, 'inline_header_image' ),
		);
	}
}
