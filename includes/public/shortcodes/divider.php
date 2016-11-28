<?php
/**
 * Cherry Divider Shortcode.
 *
 * @package    Cherry_Site_Shortcodes
 * @subpackage Shortcodes
 * @author     Cherry Team
 * @copyright  Copyright (c) 2012 - 2016, Cherry Team
 * @link       http://www.cherryframework.com/
 * @license    http://www.gnu.org/licenses/gpl-3.0.en.html
 */

/**
 * Class for Divider shortcode.
 *
 * @since 1.0.0
 */
class Cherry_Divider_Shortcode extends Cherry_Main_Shortcode {

	/**
	 * A reference to an instance of this class.
	 *
	 * @since 1.0.0
	 * @var object
	 */
	private static $instance = null;

	/**
	 * Constructor method.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->name = 'divider';

		parent::__construct();
	}

	/**
	 * The shortcode callback function.
	 *
	 * @since  1.0.0
	 * @param  array  $atts
	 * @param  string $content
	 * @param  string $shortcode
	 * @return string
	 */
	public function do_shortcode( $atts, $content = null, $shortcode ) {

		// Set up the default arguments.
		$defaults = array(
			'id'             => uniqid(),
			'width'          => '',
			'height'         => '',
			'style'          => '',
			'color'          => '',
			'opacity'        => '100',
			'padding_top'    => '',
			'padding_bottom' => '',
			'class'          => '',
		);

		$atts       = $this->shortcode_atts( $defaults, $atts );
		$css_prefix = $this->get_css_prefix();

		$result = sprintf(
			'<div id="%1$s" class="%2$s %3$s"><span class="%2$s__item"></span></div>',
			esc_attr( $css_prefix . 'divider-'. $atts['id'] ),
			Cherry_Site_Tools::esc_class( array( 'divider' ), $atts ),
			esc_attr( $atts['class'] )
		);

		$this->generate_dynamic_styles( $atts );

		return apply_filters( 'cherry_shortcode_result', $result, $atts, $shortcode );
	}

	/**
	 * Generate dynamic CSS styles for shortcode instance.
	 *
	 * @since  1.0.0
	 * @param  array $atts
	 * @return void
	 */
	public function generate_dynamic_styles( $atts ) {
		$css_prefix = $this->get_css_prefix();
		$divider_styles = array();
		$divider_line_styles = array();

		if ( ! empty( $atts['padding_top'] ) ) {
			$divider_styles['padding-top'] = $atts['padding_top'];
		}

		if ( ! empty( $atts['padding_bottom'] ) ) {
			$divider_styles['padding-bottom'] = $atts['padding_bottom'];
		}

		if ( ! empty( $divider_styles ) && is_array( $divider_styles ) ) {
			cherry_site_shortcodes()->dynamic_css->add_style(
				esc_attr( '#' . $css_prefix . 'divider-'. $atts['id'] ),
				$divider_styles
			);
		}

		if ( ! empty( $atts['width'] ) ) {
			$divider_line_styles['width'] = $atts['width'];
		}

		if ( ! empty( $atts['style'] ) ) {
			$divider_line_styles['border-top-style'] = $atts['style'];
		}

		if ( ! empty( $atts['height'] ) ) {
			$divider_line_styles['border-top-width'] = $atts['height'];
		}

		if ( ! empty( $atts['color'] ) ) {
			$rgb = Cherry_Site_Tools::hex_to_rgb( $atts['color'] );
			$opacity = intval( $atts['opacity'] ) / 100;
			$divider_line_styles['border-top-color'] = sprintf( 'rgba(%1$s, %2$s, %3$s, %4$s);', $rgb[0], $rgb[1], $rgb[2], $opacity );
		}

		if ( ! empty( $divider_line_styles ) && is_array( $divider_line_styles ) ) {
			cherry_site_shortcodes()->dynamic_css->add_style(
				esc_attr( '#' .$css_prefix . 'divider-'. $atts['id'] . ' .'. $css_prefix .'divider__item' ),
				$divider_line_styles
			);
		}

	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 * @return object
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}
}

Cherry_Divider_Shortcode::get_instance();