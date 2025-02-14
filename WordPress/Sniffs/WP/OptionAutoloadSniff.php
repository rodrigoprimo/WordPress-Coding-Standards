<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress\Sniffs\WP;

use PHP_CodeSniffer\Util\Tokens;
use PHPCSUtils\Utils\Arrays;
use PHPCSUtils\Tokens\Collections;
use PHPCSUtils\Utils\PassedParameters;
use PHPCSUtils\Utils\TextStrings;
use WordPressCS\WordPress\AbstractFunctionParameterSniff;

/**
 * Warns when calls to [add|update]_option() are missing the `$autoload` param or contain an invalid, internal or deprecated value.
 *
 * @link https://github.com/WordPress/WordPress-Coding-Standards/issues/2473
 *
 * @since 3.2.0
 */
final class OptionAutoloadSniff extends AbstractFunctionParameterSniff {

	/**
	 * The phrase to use for the metric recorded by this sniff.
	 *
	 * @var string
	 */
	const METRIC_NAME = 'Value of the `$autoload` parameter in the option functions';

	/**
	 * List of valid values for the `$autoload` parameter in the add_option() and update_option()
	 * functions.
	 *
	 * @since 3.2.0
	 *
	 * @var string[]
	 */
	protected static $valid_values_add_and_update = array( 'true', 'false', 'null' );

	/**
	 * List of valid values for the `$autoload` parameter in the wp_set_options_autoload(),
	 * wp_set_option_autoload(), and wp_set_option_autoload_values() functions.
	 *
	 * @since 3.2.0
	 *
	 * @var string[]
	 */
	protected static $valid_values_other_functions = array( 'true', 'false' );

	/**
	 * List of deprecated values for the `$autoload` parameter.
	 *
	 * @since 3.2.0
	 *
	 * @var string[]
	 */
	protected static $deprecated_values = array( 'yes', 'no' );

	/**
	 * Internal-use only values for `$autoload` that cannot be fixed automatically by the sniff.
	 *
	 * @since 3.2.0
	 *
	 * @var string[]
	 */
	protected static $internal_values_non_fixable = array( 'auto', 'auto-on', 'auto-off' );

	/**
	 * Internal-use only values for `$autoload` that can be fixed automatically by the sniff.
	 *
	 * @since 3.2.0
	 *
	 * @var string[]
	 */
	protected static $internal_values_fixable = array( 'on', 'off' );

	/**
	 * List of replacements for fixable values.
	 *
	 * @since 3.2.0
	 *
	 * @var string[]
	 */
	protected static $fixable_values = array(
		'yes' => 'true',
		'no'  => 'false',
		'on'  => 'true',
		'off' => 'false',
	);

	/**
	 * List of functions for which the `$autoload` parameter is optional.
	 *
	 * @since 3.2.0
	 *
	 * @var string[]
	 */
	protected static $autoload_is_optional = array( 'add_option', 'update_option' );

	/**
	 * The group name for this group of functions.
	 *
	 * @since 3.2.0
	 *
	 * @var string
	 */
	protected $group_name = 'option_autoload';

	/**
	 * List of functions this sniff should examine.
	 *
	 * @link https://developer.wordpress.org/reference/functions/add_option/
	 * @link https://developer.wordpress.org/reference/functions/update_option/
	 *
	 * @since 3.2.0
	 *
	 * @var array<string, array<string, string|int>> Key is the function name, value is an array
	 *                                               containing the name and the position of the
	 *                                               autoload parameter.
	 */
	protected $target_functions = array(
		'add_option'                    => array(
			'param_name' => 'autoload',
			'position'   => 4,
		),
		'update_option'                 => array(
			'param_name' => 'autoload',
			'position'   => 3,
		),
		'wp_set_options_autoload'       => array(
			'param_name' => 'autoload',
			'position'   => 2,
		),
		'wp_set_option_autoload'        => array(
			'param_name' => 'autoload',
			'position'   => 2,
		),
		// Special case as it takes an array of option names and autoload values as the first param.
		'wp_set_option_autoload_values' => array(
			'param_name' => 'options',
			'position'   => 1,
		),
	);

	/**
	 * Process the parameters of a matched function.
	 *
	 * @since 3.2.0
	 *
	 * @param int    $stackPtr      The position of the current token in the stack.
	 * @param string $group_name    The name of the group which was matched.
	 * @param string $function_name The token content (function name) which was matched
	 *                              in lowercase.
	 * @param array  $parameters    Array with information about the parameters.
	 *
	 * @return void
	 */
	public function process_parameters( $stackPtr, $group_name, $function_name, $parameters ) {
		$function_info = $this->target_functions[ $function_name ];

		$target_param = PassedParameters::getParameterFromStack(
			$parameters,
			$function_info['position'],
			$function_info['param_name']
		);

		if ( ! is_array( $target_param ) ) {
			$this->maybe_display_missing_autoload_warning( $stackPtr, $function_name );
			return;
		}

		if ( 'wp_set_option_autoload_values' === $function_name ) {
			$this->handle_wp_set_option_autoload_values( $target_param, $stackPtr );
			return;
		}

		$this->check_autoload_value( $target_param, $function_name );
	}

	/**
	 * Process the function if no parameters were found.
	 *
	 * @since 3.2.0
	 *
	 * @param int    $stackPtr      The position of the current token in the stack.
	 * @param string $group_name    The name of the group which was matched.
	 * @param string $function_name The token content (function name) which was matched
	 *                              in lowercase.
	 *
	 * @return void
	 */
	public function process_no_parameters( $stackPtr, $group_name, $function_name ) {
		$this->maybe_display_missing_autoload_warning( $stackPtr, $function_name );
	}

	/**
	 * Handle the `wp_set_option_autoload_values()` function. It requires special treatment as it
	 * takes an array of option names and autoload values instead of the autoload value of a single
	 * option as a separate parameter.
	 *
	 * @since 3.2.0
	 *
	 * @param array $options_param Options parameter information.
	 * @param int   $stackPtr      The position of the current token in the stack.
	 *
	 * @return void
	 */
	protected function handle_wp_set_option_autoload_values( array $options_param, $stackPtr ) {
		$array_token = $this->phpcsFile->findNext(
			Tokens::$emptyTokens,
			$options_param['start'],
			$options_param['end'],
			true
		);

		if ( false === isset( Collections::arrayOpenTokensBC()[ $this->tokens[ $array_token ]['code'] ] ) ) {
			// Bail if the first non-empty token in the parameter is not an array opener as this
			// means it is not possible to determine the option names and autoload values passed to
			// wp_set_option_autoload_values().
			return;
		}

		$options = PassedParameters::getParameters( $this->phpcsFile, $array_token );

		if ( empty( $options ) ) {
			// Bail if the array is empty.
			return;
		}

		foreach ( $options as $array_item ) {
			$double_arrow_pointer = Arrays::getDoubleArrowPtr( $this->phpcsFile, $array_item['start'], $array_item['end'] );

			if ( false === $double_arrow_pointer ) {
				$start = $array_item['start'];
				$clean = $array_item['clean'];
			} else {
				$array_item_parts = explode( '=>', $array_item['clean'] );
				$start            = $double_arrow_pointer + 1;
				$clean            = trim( $array_item_parts[1] );
			}

			$array_value_info = array(
				'start' => $start,
				'end'   => $array_item['end'],
				'clean' => $clean,
			);

			$this->check_autoload_value( $array_value_info, 'wp_set_option_autoload_values' );
		}
	}

	/**
	 * Adds a PHPCS warning to be used when autoload information is missing. Autoload information is
	 * an array of option names and autoload values in the case of `wp_set_option_autoload_values()`
	 * and a separate `$autoload` parameter in the case of the other functions.
	 *
	 * @since 3.2.0
	 *
	 * @param int    $stackPtr      The position of the current token in the stack.
	 * @param string $function_name The name of the function being checked.
	 *
	 * @return void
	 */
	protected function maybe_display_missing_autoload_warning( $stackPtr, $function_name ) {
		$this->phpcsFile->recordMetric( $stackPtr, self::METRIC_NAME, 'param missing' );

		// Only display a warning for the functions in which the `$autoload` parameter is optional.
		if ( in_array( $function_name, self::$autoload_is_optional, true ) ) {
			$this->phpcsFile->addWarning(
				'It is recommended to always pass the `$autoload` parameter when using %s() function.',
				$stackPtr,
				'Missing',
				array( $this->tokens[ $stackPtr ]['content'] )
			);
		}
	}

	/**
	 * Check the autoload value for possible violations.
	 *
	 * @since 3.2.0
	 *
	 * @param array  $autoload_info Information about the autoload value (start and end tokens and
	 *                              the clean and raw value).
	 * @param string $function_name The name of the function being checked.
	 *
	 * @return void
	 */
	protected function check_autoload_value( array $autoload_info, $function_name ) {
		// Find the first and second param non-empty tokens (the second token might not exist).
		$param_first_token  = $this->phpcsFile->findNext(
			Tokens::$emptyTokens,
			$autoload_info['start'],
			( $autoload_info['end'] + 1 ),
			true
		);
		$param_second_token = $this->phpcsFile->findNext(
			Tokens::$emptyTokens,
			$param_first_token + 1,
			( $autoload_info['end'] + 1 ),
			true
		);

		$normalized_value = strtolower( $autoload_info['clean'] );

		if ( T_NS_SEPARATOR === $this->tokens[ $param_first_token ]['code']
			&& $param_second_token
			&& in_array( strtolower( $this->tokens[ $param_second_token ]['content'] ), self::$valid_values_add_and_update, true )
		) {
			// Ensure the sniff handles correctly `true`, `false` and `null` when they are
			// namespaced (preceded by a backslash).
			$param_first_token  = $param_second_token;
			$param_second_token = false;
			$normalized_value   = substr( $normalized_value, 1 );
		}

		if ( in_array( $function_name, self::$autoload_is_optional, true ) ) {
			$valid_values = self::$valid_values_add_and_update;
		} else {
			$valid_values = self::$valid_values_other_functions;
		}

		if ( in_array( $normalized_value, $valid_values, true ) ) {
			$this->phpcsFile->recordMetric( $param_first_token, self::METRIC_NAME, $normalized_value );
			return;
		}

		if ( in_array( $this->tokens[ $param_first_token ]['code'], array( T_VARIABLE, T_STRING ), true )
			&& 'null' !== strtolower( $this->tokens[ $param_first_token ]['content'] )
		) {
			// Bail early if the first non-empty token in the parameter is T_VARIABLE or T_STRING as
			// this means it is not possible to determine the value.
			$this->phpcsFile->recordMetric( $param_first_token, self::METRIC_NAME, 'undetermined value' );
			return;
		}

		if ( $param_second_token
			&& ! in_array( $this->tokens[ $param_first_token ]['code'], array( T_ARRAY, T_OPEN_SHORT_ARRAY ), true )
		) {
			// Bail early if the parameter has two or more non-empty tokens and the second token is
			// not an array opener as this means an undetermined param value or a value that is not
			// easy to determine.
			$this->phpcsFile->recordMetric( $param_first_token, self::METRIC_NAME, 'undetermined value' );
			return;
		}

		$autoload_value = TextStrings::stripQuotes( $autoload_info['clean'] );

		$known_discouraged_values = array_merge( self::$deprecated_values, self::$internal_values_non_fixable, self::$internal_values_fixable );

		if ( in_array( $autoload_value, $known_discouraged_values, true ) ) {
			$metric_value = $autoload_value;
		} else {
			$metric_value = 'other value';
		}

		$this->phpcsFile->recordMetric( $param_first_token, self::METRIC_NAME, $metric_value );

		if ( in_array( $autoload_value, self::$deprecated_values, true ) ) {
			$message    = 'The use of `%s` as the value of the `$autoload` parameter is deprecated. Use `%s` instead.';
			$error_code = 'Deprecated';
			$data       = array( $autoload_info['clean'], self::$fixable_values[ $autoload_value ] );
		} elseif ( in_array( $autoload_value, self::$internal_values_fixable, true ) ) {
			$message    = 'The use of `%s` as the value of the `$autoload` parameter is discouraged. Use `%s` instead.';
			$error_code = 'InternalUseOnly';
			$data       = array( $autoload_info['clean'], self::$fixable_values[ $autoload_value ] );
		} elseif ( in_array( $autoload_value, self::$internal_values_non_fixable, true ) ) {
			$message    = 'The use of `%s` as the value of the `$autoload` parameter is discouraged.';
			$error_code = 'InternalUseOnly';
			$data       = array( $autoload_info['clean'] );
		} else {
			$valid_values        = array_map(
				function ( $value ) {
					return '`' . $value . '`';
				},
				$valid_values
			);
			$valid_values_string = implode( ', ', $valid_values );
			$valid_values_string = substr_replace( $valid_values_string, ' or', strrpos( $valid_values_string, ',' ), 1 );
			$message             = 'The use of `%s` as the value of the `$autoload` parameter is invalid. Use %s instead.';
			$error_code          = 'InvalidValue';
			$data                = array( $autoload_info['clean'], $valid_values_string );
		}

		if ( in_array( $autoload_value, array_keys( self::$fixable_values ), true ) ) {
			$fix = $this->phpcsFile->addFixableWarning(
				$message,
				$param_first_token,
				$error_code,
				$data
			);

			if ( $fix ) {
				$this->phpcsFile->fixer->replaceToken( $param_first_token, self::$fixable_values[ $autoload_value ] );
			}

			return;
		}

		$this->phpcsFile->addWarning(
			$message,
			$param_first_token,
			$error_code,
			$data
		);
	}
}
