<?php

/**
 * Sanitize anything
 *
 * @link 		https://www.slushman.com
 * @since 		1.0.0
 * @package 	CaseStudies\Includes
 * @author 		Slushman <chris@slushman.com>
 */

namespace CaseStudies\Includes;

class Sanitize {

	/**
	 * Class constructor.
	 *
	 * @since 		1.0.0
	 */
	public function __construct() {} // __construct()

	/**
	 * Returns sanitized data.
	 *
	 * @since 		1.0.0
	 * @param 		mixed 		$data 		The data to sanitize.
	 * @param 		string  	$type 		The data type.
	 * @return 		mixed 					The sanitized data.
	 */
	public function clean( $data, $type ) {

		$check = '';

		if ( empty( $type ) ) {

			$check = new WP_Error( 'forgot_type', __( 'Specify the data type to sanitize.', 'case-studies' ) );

		}

		if ( is_wp_error( $check ) ) {

			wp_die( $check->get_error_message(), __( 'Forgot data type', 'case-studies' ) );

		}

		/**
		 * The case_studies_pre_sanitize filter.
		 * Add additional santization before the default sanitization.
		 *
		 * @param 		string 		$sanitized 		Empty.
		 * @param 		mixed 		$data 			The data passed in.
		 * @param 		string 		$type 			The data type.
		 */
		$sanitized = apply_filters( 'case_studies_pre_sanitize', '', $data, $type );

		switch ( $type ) {

			case 'radio'			:
			case 'select'			: $sanitized = $this->sanitize_random( $data ); break;

			case 'date'				:
			case 'datetime'			:
			case 'datetime-local'	:
			case 'time'				:
			case 'week'				: $sanitized = $this->sanitize_times( $data ); break;

			case 'number'			:
			case 'range'			: $sanitized = $this->sanitize_number_or_range( $data ); break;

			case 'hidden'			:
			case 'month'			:
			case 'image' 			:
			case 'text'				: $sanitized = sanitize_text_field( $data ); break;

			case 'checkbox'			: $sanitized = $this->sanitize_checkbox( $data ); break;
			case 'color' 			: $sanitized = $this->sanitize_color( $data ); break;
			case 'editor' 			: $sanitized = wp_kses_post( $data ); break;
			case 'email'			: $sanitized = sanitize_email( $data ); break;
			case 'file'				: $sanitized = esc_url_raw( $data ); break;
			case 'tel'				: $sanitized = $this->sanitize_phone( $data ); break;
			case 'textarea'			: $sanitized = esc_textarea( $data ); break;
			case 'url'				: $sanitized = esc_url_raw( $data ); break;

		} // switch

		/**
		 * The case_studies_post_sanitize filter.
		 * Add additional santization after the default sanitization.
		 *
		 * @param 		mixed 		$sanitized 		The sanitized data.
		 * @param 		mixed 		$data 			The data passed in.
		 * @param 		string 		$type 			The data type.
		 */
		$sanitized = apply_filters( 'case_studies_post_sanitize', $sanitized, $data, $type );

		return $sanitized;

	} // clean()

	/**
	 * Returns $alpha if its value is between 0 and 1 and it is numeric.
	 * Otherwise returns FALSE.
	 *
	 * @exits 		If $alpha is empty.
	 * @exits 		If $alpha is not numeric.
	 * @exits 		If $alpha is less than 0.
	 * @exits 		If $alpha is greater than 1.
	 * @since 		1.0.1
	 * @param 		float 		$alpha 		The alpha value.
	 * @return 		float|bool 				Returns $alpha or FALSE.
	 */
	public function check_alpha( $alpha ) {

		if ( ! isset( $alpha ) ) { return FALSE; }
		if ( ! is_string( $alpha ) ) { return FALSE; }
		if ( ! is_numeric( $alpha ) ) { return FALSE; }
		if ( 0 > $alpha ) { return FALSE; }
		if ( 1 < $alpha ) { return FALSE; }

		return $alpha;

	} // check_alpha()

	/**
	 * Returns $hue if its value is between 0 and 360 and is numeric.
	 * Otherwise returns FALSE.
	 *
	 * @exits 		If $hue is empty.
	 * @exits 		If $hue is less than 0.
	 * @exits 		If $hue is greater than 360.
	 * @since 		1.0.1
	 * @param 		int 		$hue 		The hue value.
	 * @return 		int|bool 				Returns $hue or FALSE.
	 */
	public function check_hue( $hue ) {

		if ( ! isset( $hue ) ) { return FALSE; }
		if ( ! is_string( $hue ) ) { return FALSE; }
		if ( ! is_numeric( $hue ) ) { return FALSE; }

		$hue = intval( $hue );

		if ( 0 > $hue ) { return FALSE; }
		if ( 360 < $hue ) { return FALSE; }

		return $hue;

	} // check_hue()

	/**
	 * Returns $check if its value is between 0 and 100 and it contains '%'.
	 * Otherwise returns FALSE.
	 *
	 * @exits 		If $check is empty.
	 * @exits 		If $check does not contain '%'.
	 * @exits 		If $hue is less than 0.
	 * @exits 		If $hue is greater than 100.
	 * @since 		1.0.1
	 * @param 		string 		$check 		The light or saturation value.
	 * @return 		int|bool 				Returns $number_only or FALSE.
	 */
	public function check_light_or_saturation( $check ) {

		if ( empty( $check ) ) { return FALSE; }
		if ( ! is_string( $check ) ) { return FALSE; }
		if ( false === strpos( $check, '%' ) ) { return FALSE; }

		$number_only = substr( $check, 0, -1 );
		$int = intval( $number_only );

		if ( 0 > $int ) { return FALSE; }
		if ( 100 < $int ) { return FALSE; }

		return $int;

	} // check_light_or_saturation()

	/**
	 * Returns $check if its value is between 0 and 255 and its a numeric string.
	 * Otherwise returns FALSE.
	 *
	 * @exits 		If $check is empty.
	 * @exits 		If $check is not an integer.
	 * @exits 		If $check is less than 0.
	 * @exits 		If $check is greater than 255.
	 * @since 		1.0.1
	 * @param 		int 		$check 		The hue value.
	 * @return 		int|bool 				Returns $check or FALSE.
	 */
	public function check_rgb_value( $check ) {

		if ( ! isset( $check ) ) { return FALSE; }
		if ( ! is_string( $check ) ) { return FALSE; }
		if ( ! is_numeric( $check ) ) { return FALSE; }

		$int = intval( $check );

		if ( 0 > $int ) { return FALSE; }
		if ( 255 < $int ) { return FALSE; }

		return $int;

	} // check_rgb_value()

	/**
	 * Returns a 1 or 0 based on the $data.
	 *
	 * @exits 		If $data exists.
	 * @since 		1.0.1
	 * @param 		mixed 		$data 		The checkbox value.
	 * @return 		int 					1 if $data exists, otherwise 0.
	 */
	public function sanitize_checkbox( $data ) {

		if ( $data ) { return 1; }

		return 0;

	} // sanitize_checkbox()

	/**
	 * Determines the type of color value and returns the result
	 * from the appropriate sanitization method.
	 *
	 * @exits 		If $color is empty.
	 * @since 		1.0.0
	 * @param 		string 		$color 		The color string.
	 * @return 		string 					The sanitized color string.
	 */
	public function sanitize_color( $color  ) {

		if ( empty( $color ) ) { return FALSE; }

		$four = substr( $color, 0, 4 );

		switch ( $four ) {

			case 'rgba': return $this->sanitize_rgba_color( $color ); break;
			case 'hsla': return $this->sanitize_hsla_color( $color ); break;
			case 'rgb(': return $this->sanitize_rgb_color( $color ); break;
			case 'hsl(': return $this->sanitize_hsl_color( $color ); break;
			default : return sanitize_hex_color( $color ); break;

		}

	} // sanitize_color()

	/**
	 * Validates the input is a hex color.
	 *
	 * Based on the WP Core Customizer function sanitize_hex_color().
	 *
	 * @exits 		If $color is empty.
	 * @exits 		If $color is not a string.
	 * @since 		1.0.0
	 * @see 		https://developer.wordpress.org/reference/functions/sanitize_hex_color/
	 * @param 		string 		$color 			The hex color string
	 * @return 		string 						The sanitized hex color string
	 */
	public function sanitize_hex_color( $color ) {

		if ( empty( $color ) ) { return FALSE; }
		if ( ! is_string( $color ) ) { return FALSE; }

		$color = trim( $color );

		if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {

			return $color;

		}

		return FALSE;

	} // sanitize_hex_color()

	/**
	 * Sanitizes HSL color values.
	 *
	 * Checks if the color contains "hsl(". Returns if not.
	 * Then trims out extra space and remove the hsl( at the beginning
	 * and ) at the end.
	 * Creates an array from the remainder.
	 * Checks each value individually.
	 * 		$hue must be between 0 and 360.
	 *   	$sat must contain "%" and the rest must be between 0 and 100.
	 *   	$light must contain "%" and the rest must be between 0 and 100.
	 *
	 * @exits 		If $color is empty.
	 * @exits 		If $color does not contain "hsl(".
	 * @exits 		If $h, $s, or $l are FALSE.
	 * @since 		1.0.0
	 * @param 		string 		$color 				HSL color string.
	 * @return 		string|bool 					Sanitized HSLA color string, otherwise FALSE.
	 */
	public function sanitize_hsl_color( $color ) {

		if ( empty( $color ) ) { return FALSE; }
		if ( false === strpos( $color, 'hsl(' ) ) { return FALSE; }

		$color 						= str_replace( ' ', '', $color );
		$sub 						= substr( $color, 4, -1 );
		$subarray 					= explode( ',', $sub );
		list( $hue, $sat, $light ) 	= $subarray;

		$h = $s = $l = '';

		$h = $this->check_hue( $hue );
		if ( ! $h ) { return FALSE; }

		$s = $this->check_light_or_saturation( $sat );
		if ( ! $s ) { return FALSE; }

		$l = $this->check_light_or_saturation( $light );
		if ( ! $l ) { return FALSE; }

		return 'hsl(' . $h . ',' . $s . '%,' . $l . '%)';

	} // sanitize_hsl_color()

	/**
	 * Sanitizes HSLA color values.
	 *
	 * Checks if the color contains "hsla". Returns if not.
	 * Then trims out extra space and remove the hsla( at the beginning
	 * and ) at the end.
	 * Creates an array from the remainder.
	 * Checks each value individually.
	 * 		$hue must be between 0 and 360.
	 *   	$sat must contain "%" and the rest must be between 0 and 100.
	 *   	$light must contain "%" and the rest must be between 0 and 100.
	 *   	$alpha must be between 0 and 1.
	 *
	 * @exits 		If $color is empty.
	 * @exits 		If $color does not contain 'hsla'.
	 * @exits 		If $h, $s, $l, or $a are FALSE.
	 * @since 		1.0.0
	 * @param 		string 		$color 				HSLA color string.
	 * @return 		string|bool 					Sanitized HSLA color string, otherwise FALSE.
	 */
	public function sanitize_hsla_color( $color ) {

		if ( empty( $color ) ) { return FALSE; }
		if ( false === strpos( $color, 'hsla' ) ) { return FALSE; }

		$nospaces 							= str_replace( ' ', '', $color );
		$sub 								= substr( $nospaces, 5, -1 );
		$subarray 							= explode( ',', $sub );
		list( $hue, $sat, $light, $alpha ) 	= $subarray;

		$h = $s = $l = $a = '';

		$h = $this->check_hue( $hue );
		if ( FALSE === $h ) { return FALSE; }

		$s = $this->check_light_or_saturation( $sat );
		if ( ! $s ) { return FALSE; }

		$l = $this->check_light_or_saturation( $light );
		if ( ! $l ) { return FALSE; }

		$a = $this->check_alpha( $alpha );
		if ( ! $a ) { return FALSE; }

		return 'hsla(' . $h . ',' . $s . '%,' . $l . '%,' . $a . ')';

	} // sanitize_hsla_color()

	/**
	 * Returns the integer value of $data if its set and numeric.
	 *
	 * @exits 		If $data is not set.
	 * @exits 		If $data is not numeric.
	 * @param 		mixed 		$data 		Data
	 * @return 		int|bool 				The integer value of $data or FALSE.
	 */
	public function sanitize_number_or_range( $data ) {

		if ( ! isset( $data ) ) { return FALSE; }
		if ( ! is_numeric( $data ) ) { return FALSE; }

		return intval( $data );

	} // sanitize_number_or_range()

	/**
	 * Sanitizes RGB color values.
	 *
	 * @exits 		If $color is empty.
	 * @exits 		If $color does not contain 'rgb()'.
	 * @exits 		If $r, $g, or $b are FALSE.
	 * @since 		1.0.0
	 * @see 		https://github.com/aristath/ornea/blob/master/inc/kirki/includes/class-kirki-sanitize.php
	 * @param 		string 		$color 		RGB color string.
	 * @return 		string 					Sanitized RGB color string.
	 */
	public function sanitize_rgb_color( $color ) {

		if ( empty( $color ) ) { return FALSE; }
		if ( false === strpos( $color, 'rgb(' ) ) { return FALSE; }

		$color 						= str_replace( ' ', '', $color );
		$sub 						= substr( $color, 4, -1 );
		$subarray 					= explode( ',', $sub );
		list( $red, $green, $blue ) = $subarray;

		$r = $this->check_rgb_value( $red );
		if ( ! $r ) { return FALSE; }

		$g = $this->check_rgb_value( $green );
		if ( ! $g ) { return FALSE; }

		$b = $this->check_rgb_value( $blue );
		if ( ! $b ) { return FALSE; }

		return 'rgb(' . $r . ',' . $g . ',' . $b . ')';

	} // sanitize_rgb_color()

	/**
	 * Sanitizes RGBA color values.
	 *
	 * @exits 		If $color is empty.
	 * @exits 		If $color does not contain 'rgba'.
	 * @exits 		If $r, $g, $b, or $a are FALSE.
	 * @since 		1.0.0
	 * @param 		string 		$color 		RGBA color string.
	 * @return 		string 					Sanitized RGBA color string.
	 */
	public function sanitize_rgba_color( $color ) {

		if ( empty( $color ) ) { return FALSE; }
		if ( false === strpos( $color, 'rgba' ) ) { return FALSE; }

		$color 								= str_replace( ' ', '', $color );
		$sub 								= substr( $color, 5, -1 );
		$subarray 							= explode( ',', $sub );
		list( $red, $green, $blue, $alpha ) = $subarray;

		$r = $this->check_rgb_value( $red );
		if ( ! $r ) { return FALSE; }

		$g = $this->check_rgb_value( $green );
		if ( ! $g ) { return FALSE; }

		$b = $this->check_rgb_value( $blue );
		if ( ! $b ) { return FALSE; }

		$a = $this->check_alpha( $alpha );
		if ( ! $a ) { return FALSE; }

		return 'rgba(' . $r . ',' . $g . ',' . $b . ',' . $a . ')';

	} // sanitize_rgba_color()

	/**
	 * Validates a phone number
	 *
	 * @exits 		If $phone is empty.
	 * @since		1.0.0
	 * @link		http://jrtashjian.com/2009/03/code-snippet-validate-a-phone-number/
	 * @param 		string 			$phone				A phone number string
	 * @return		string|bool		$phone|FALSE		Returns the valid phone number, FALSE if not
	 */
	public function sanitize_phone( $phone ) {

		if ( empty( $phone ) ) { return FALSE; }

		if ( preg_match( '/^[+]?([\d]{0,3})?[\(\.\-\s]?([\d]{3})[\)\.\-\s]*([\d]{3})[\.\-\s]?([\d]{4})$/', $phone ) ) {

			return trim( $phone );

		} // $phone validation

		return FALSE;

	} // sanitize_phone()

	/**
	 * Performs general cleaning functions on data
	 *
	 * @exits 		If $input is empty.
	 * @since 		1.0.0
	 * @param 		mixed 	$input 		Data to be cleaned
	 * @return 		mixed 	$return 	The cleaned data
	 */
	public function sanitize_random( $input ) {

		if ( empty( $input ) ) { return ''; }

		$one	= trim( $input );
		$two	= stripslashes( $one );
		$return	= htmlspecialchars( $two );

		return $return;

	} // sanitize_random()

	/**
	 * Returns the string as a Unix timestamp.
	 *
	 * @exits 		If $data is empty.
	 * @since 		1.0.1
	 * @param 		string 		$data 		The time string.
	 * @return 		string 					A Unix timestamp.
	 */
	public function sanitize_times( $data ) {

		if ( empty( $data ) ) { return FALSE; }

		$trim = trim( $data );

		return strtotime( $trim );

	} // sanitize_times()

	/**
	 * Checks a date against a format to ensure its validity
	 *
	 * @since 		1.0.0
	 * @link 		http://www.php.net/manual/en/function.checkdate.php
	 * @param  		string 		$date   		The date as collected from the form field
	 * @param  		string 		$format 		The format to check the date against
	 * @return 		string 		A validated, formatted date
	 */
	public function validate_date( $date, $format = 'Y-m-d H:i:s' ) {

		$version = explode( '.', phpversion() );

		if ( ( (int) $version[0] >= 5 && (int) $version[1] >= 2 && (int) $version[2] > 17 ) ) {

			$d = DateTime::createFromFormat( $format, $date );

		} else {

			$d = new DateTime( date( $format, strtotime( $date ) ) );

		}

		return $d && $d->format( $format ) == $date;

	} // validate_date()

} // class
