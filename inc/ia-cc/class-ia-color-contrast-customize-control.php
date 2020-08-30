<?php
/**
 * Color Contrast Control for WordPress Customizer
 *
 * @package ia
 *
 * Plugin Name: Color Contrast Control for WordPress Customizer
 * Plugin URI:  https://github.com/aut0poietic/ia-color-contrast
 * Description: Adds a custom control that can be used to insert a contrast check for a color pair in the WordPress Customizer.
 * Author: Jer Brand - @aut0poietic
 * Version: 1.0.0
 * Author URI: https://irresponsibleart.com
 * GitHub Plugin URI: https://github.com/aut0poietic/ia-color-contrast
 * GitHub Branch: primary
 * License: GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 */
if ( class_exists( 'WP_Customize_Control' ) ) {
	class IA_Color_Contrast_Customize_Control extends \WP_Customize_Control {
		public $type = 'color-contrast';

		public function enqueue() {
			wp_enqueue_style(
				'ia-color-contrast-styles',
				get_theme_file_uri( 'inc/ia-cc/ia-color-contrast-customize-control.css' )
			);
			wp_enqueue_script(
				'ia-color-contrast-scripts',
				get_theme_file_uri( 'inc/ia-cc/ia-color-contrast-customize-control.js' ),
				array( 'customize-controls', 'wp-i18n' )
			);
			wp_set_script_translations( 'ia-color-contrast-scripts', 'ia-color-contrast' );
		}

		/**
		 * JSON Data sent to the javascript template created in content_template() as `data`.
		 */
		public function to_json() {
			parent::to_json();
			$this->json['id'] = $this->id;
		}

		/**
		 * PHP-based HTML Output
		 * Because we are using JavaScript-only templating via `content_template()`
		 * this method must be overridden, but output nothing.
		 */
		public function render_content() {
			//noop
		}

		public function content_template() {
			?>
			<#
			var background = '#fff';
			var foreground = '#000';
			if ( Array.isArray( data.settings ) && data.settings.length >=2 ) {
				wp.customize( data.settings[ 0 ], function( setting ) {
					background = setting.get() ;
					setting.bind( function( to ){
						background = to;
						__ia.colorContrast.update(background, foreground, data);
					});
				} );
				wp.customize( data.settings[ 1 ], function( setting ) {
					foreground =  setting.get();
						setting.bind( function( to ){
						foreground = to;
						__ia.colorContrast.update(background, foreground, data);
					});
				} );
				setTimeout( function() {
					__ia.colorContrast.update(background, foreground, data);
				}, 10);
			} #>
			<div class="color-contrast-customize-ui">
				<div class="color-contrast-customize-ui-results">
					<div class="wcag wcag-aa large">
						<svg class="pass" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 18">
							<path fill="#075c00" d="M24 3.5a1.4 1.4 0 01-.4 1l-13.4 13a1.5 1.5 0 01-2 0L.3 10A1.5 1.5 0 010 9a1.4 1.4 0 01.4-1l2.1-2a1.5 1.5 0 011-.5 1.5 1.5 0 011 .4l4.7 4.5L19.4.4a1.5 1.5 0 012 0l2.2 2a1.4 1.4 0 01.4 1z" />
						</svg>
						<svg class="fail" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
							<path fill="#960d0d" d="M20.5 12a8.4 8.4 0 00-1.4-4.6L7.4 19.1A8.5 8.5 0 0020.5 12zM4.9 16.6L16.7 5A8.3 8.3 0 0012 3.5a8.5 8.5 0 00-7.1 13.1zM24 12A12 12 0 1112 0a12 12 0 0112 12z" />
						</svg>
						<?php _e("AA Large", 'ia-color-contrast') ; ?>
					</div>
					<div class="wcag wcag-aa regular">
						<svg class="pass" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 18">
							<path fill="#075c00" d="M24 3.5a1.4 1.4 0 01-.4 1l-13.4 13a1.5 1.5 0 01-2 0L.3 10A1.5 1.5 0 010 9a1.4 1.4 0 01.4-1l2.1-2a1.5 1.5 0 011-.5 1.5 1.5 0 011 .4l4.7 4.5L19.4.4a1.5 1.5 0 012 0l2.2 2a1.4 1.4 0 01.4 1z" />
						</svg>
						<svg class="fail" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
							<path fill="#960d0d" d="M20.5 12a8.4 8.4 0 00-1.4-4.6L7.4 19.1A8.5 8.5 0 0020.5 12zM4.9 16.6L16.7 5A8.3 8.3 0 0012 3.5a8.5 8.5 0 00-7.1 13.1zM24 12A12 12 0 1112 0a12 12 0 0112 12z" />
						</svg>
						<?php _e("AA", 'ia-color-contrast') ; ?>
					</div>
					<div class="wcag wcag-aaa large">
						<svg class="pass" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 18">
							<path fill="#075c00" d="M24 3.5a1.4 1.4 0 01-.4 1l-13.4 13a1.5 1.5 0 01-2 0L.3 10A1.5 1.5 0 010 9a1.4 1.4 0 01.4-1l2.1-2a1.5 1.5 0 011-.5 1.5 1.5 0 011 .4l4.7 4.5L19.4.4a1.5 1.5 0 012 0l2.2 2a1.4 1.4 0 01.4 1z" />
						</svg>
						<svg class="fail" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
							<path fill="#960d0d" d="M20.5 12a8.4 8.4 0 00-1.4-4.6L7.4 19.1A8.5 8.5 0 0020.5 12zM4.9 16.6L16.7 5A8.3 8.3 0 0012 3.5a8.5 8.5 0 00-7.1 13.1zM24 12A12 12 0 1112 0a12 12 0 0112 12z" />
						</svg>
						<?php _e("AAA Large", 'ia-color-contrast') ; ?>
					</div>
					<div class="wcag wcag-aaa regular">
						<svg class="pass" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 18">
							<path fill="#075c00" d="M24 3.5a1.4 1.4 0 01-.4 1l-13.4 13a1.5 1.5 0 01-2 0L.3 10A1.5 1.5 0 010 9a1.4 1.4 0 01.4-1l2.1-2a1.5 1.5 0 011-.5 1.5 1.5 0 011 .4l4.7 4.5L19.4.4a1.5 1.5 0 012 0l2.2 2a1.4 1.4 0 01.4 1z" />
						</svg>
						<svg class="fail" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
							<path fill="#960d0d" d="M20.5 12a8.4 8.4 0 00-1.4-4.6L7.4 19.1A8.5 8.5 0 0020.5 12zM4.9 16.6L16.7 5A8.3 8.3 0 0012 3.5a8.5 8.5 0 00-7.1 13.1zM24 12A12 12 0 1112 0a12 12 0 0112 12z" />
						</svg>
						<?php _e("AAA", 'ia-color-contrast') ; ?>
					</div>
				</div>
			</div>
			<?php
		}
	}
}
/**
 * @param WP_Customize_Manager $wp_customize
 */
function ia_color_contrast_customize_control_register( $wp_customize ) {
	$wp_customize->register_control_type( 'IA_Color_Contrast_Customize_Control' );
}

add_action( 'customize_register', 'ia_color_contrast_customize_control_register' );
