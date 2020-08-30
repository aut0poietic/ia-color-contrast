/**
 * Color Contrast Control for WordPress Customizer
 *
 * This script file is enqueued by `class-ia-color-contrast-customize-control.php`.
 *
 * Only the `update` function is considered public and is called from the `content_template` method of the
 * IA_Color_Contrast_Customize_Control class.
 *
 * Much of the code here came from / adapted from https://dev.to/alvaromontoro/building-your-own-color-contrast-checker-4j7o
 * "Building your own color contrast checker" by Alvaro Montoro @alvaro_montoro
 * As indicated in the article, the rgbToHex method originated from Tim Down on StackOverflow
 * https://stackoverflow.com/questions/5623838/rgb-to-hex-and-hex-to-rgb/5624139#5624139
 *
 * @global global wp
 */
var __ = wp.i18n.__;

var __ia = {
	colorContrast : {
		prefix : 'customize-control-',

		update : function( bg, fg, data ) {
			var ratio = this.__getRatio( bg, fg );
			var el = document.querySelector( '#' + this.prefix + data.id + ' .color-contrast-customize-ui' );
			if ( ! el ) {
				return;
			}

			this.__updateWCAGLevel(
				el.querySelector( '.wcag-aa.large' ),
				__('WCAG Level AA for large text.', 'ia-color-contrast'),
				ratio,
				1 / 3,
			);

			this.__updateWCAGLevel(
				el.querySelector( '.wcag-aa.regular' ),
				__('WCAG Level AA for regular text.', 'ia-color-contrast'),
				ratio,
				1 / 4.5,
			);

			this.__updateWCAGLevel(
				el.querySelector( '.wcag-aaa.large' ),
				__('WCAG Level AAA for large text.', 'ia-color-contrast'),
				ratio,
				1 / 4.5,
			);

			this.__updateWCAGLevel(
				el.querySelector( '.wcag-aaa.regular' ),
				__('WCAG Level AAA for regular text.', 'ia-color-contrast'),
				ratio,
				1 / 7,
			);
		},

		__updateWCAGLevel : function( el, label, ratio, minRatio ) {
			if ( el ) {
				var hasOKContrast = ratio < minRatio;
				el.classList.remove( 'pass', 'fail' );
				el.classList.add( hasOKContrast ? 'pass' : 'fail' );
				el.setAttribute( 'aria-label', ( hasOKContrast ? 'Passes ' : 'Fails ' ) + label );
			}
		},

		__hexToRgb : function hexToRgb( hex ) {
			var shorthandRegex = /^#?([a-f\d])([a-f\d])([a-f\d])$/i;
			hex = hex.replace( shorthandRegex, function( m, r, g, b ) {
				return r + r + g + g + b + b;
			} );
			var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec( hex );
			return result ? {
				r : parseInt( result[ 1 ], 16 ),
				g : parseInt( result[ 2 ], 16 ),
				b : parseInt( result[ 3 ], 16 ),
			} : null;
		},

		__getLuminance : function( r, g, b ) {
			var a = [ r, g, b ].map( function( v ) {
				v /= 255;
				return v <= 0.03928
					? v / 12.92
					: Math.pow( ( v + 0.055 ) / 1.055, 2.4 );
			} );
			return a[ 0 ] * 0.2126 + a[ 1 ] * 0.7152 + a[ 2 ] * 0.0722;
		},

		__getRatio : function( bg, fg ) {
			var fgRGB = this.__hexToRgb( fg );
			var bgRGB = this.__hexToRgb( bg );
			var fgLum = this.__getLuminance( fgRGB.r, fgRGB.g, fgRGB.b );
			var bgLum = this.__getLuminance( bgRGB.r, bgRGB.g, bgRGB.b );
			return fgLum > bgLum
				? ( ( bgLum + 0.05 ) / ( fgLum + 0.05 ) )
				: ( ( fgLum + 0.05 ) / ( bgLum + 0.05 ) );
		},
	},
};
