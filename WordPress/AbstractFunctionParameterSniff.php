<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress;

use PHP_CodeSniffer\Util\Tokens;
use PHPCSUtils\Utils\PassedParameters;
use WordPressCS\WordPress\AbstractFunctionRestrictionsSniff;

/**
 * Advises about parameters used in function calls.
 *
 * @since 0.11.0
 */
abstract class AbstractFunctionParameterSniff extends AbstractFunctionRestrictionsSniff {

	/**
	 * The group name for this group of functions.
	 *
	 * Intended to be overruled in the child class.
	 *
	 * @var string
	 */
	protected $group_name = 'restricted_parameters';

	/**
	 * Functions this sniff is looking for. Should be defined in the child class.
	 *
	 * @var array The only requirement for this array is that the top level
	 *            array keys are the names of the functions you're looking for.
	 *            Other than that, the array can have arbitrary content
	 *            depending on your needs.
	 */
	protected $target_functions = array();

	/**
	 * Groups of functions to restrict.
	 *
	 * @return array
	 */
	public function getGroups() {
		if ( empty( $this->target_functions ) ) {
			return array();
		}

		return array(
			$this->group_name => array(
				'functions' => array_keys( $this->target_functions ),
			),
		);
	}

	/**
	 * Process a matched token.
	 *
	 * @param int    $stackPtr        The position of the current token in the stack.
	 * @param string $group_name      The name of the group which was matched.
	 * @param string $matched_content The token content (function name) which was matched
	 *                                in lowercase.
	 *
	 * @return int|void Integer stack pointer to skip forward or void to continue
	 *                  normal file processing.
	 */
	public function process_matched_token( $stackPtr, $group_name, $matched_content ) {

		$parameters = PassedParameters::getParameters( $this->phpcsFile, $stackPtr );

		if ( empty( $parameters ) ) {
			return $this->process_no_parameters( $stackPtr, $group_name, $matched_content );
		} else {
			return $this->process_parameters( $stackPtr, $group_name, $matched_content, $parameters );
		}
	}

	/**
	 * Verify if the current token is a function call. Behaves like the parent method, except that
	 * it returns false if there is no opening parenthesis after the function name (likely a
	 * function import) or if it is a first class callable.
	 *
	 * @param int $stackPtr The position of the current token in the stack.
	 *
	 * @return bool
	 */
	public function is_targetted_token( $stackPtr ) {
		if ( ! parent::is_targetted_token( $stackPtr ) ) {
			return false;
		}

		$next = $this->phpcsFile->findNext( Tokens::$emptyTokens, ( $stackPtr + 1 ), null, true );

		// Not a function call (likely a function import).
		if ( \T_OPEN_PARENTHESIS !== $this->tokens[ $next ]['code'] ) {
			return false;
		}

		// First class callable.
		$firstNonEmpty = $this->phpcsFile->findNext( Tokens::$emptyTokens, ( $next + 1 ), null, true );
		if ( $firstNonEmpty && \T_ELLIPSIS === $this->tokens[ $firstNonEmpty ]['code'] ) {
			$secondNonEmpty = $this->phpcsFile->findNext( Tokens::$emptyTokens, ( $firstNonEmpty + 1 ), null, true );
			if ( ! $secondNonEmpty || \T_CLOSE_PARENTHESIS === $this->tokens[ $secondNonEmpty ]['code'] ) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Process the parameters of a matched function.
	 *
	 * This method has to be made concrete in child classes.
	 *
	 * @param int    $stackPtr        The position of the current token in the stack.
	 * @param string $group_name      The name of the group which was matched.
	 * @param string $matched_content The token content (function name) which was matched
	 *                                in lowercase.
	 * @param array  $parameters      Array with information about the parameters.
	 *
	 * @return int|void Integer stack pointer to skip forward or void to continue
	 *                  normal file processing.
	 */
	abstract public function process_parameters( $stackPtr, $group_name, $matched_content, $parameters );

	/**
	 * Process the function if no parameters were found.
	 *
	 * Defaults to doing nothing. Can be overloaded in child classes to handle functions
	 * were parameters are expected, but none found.
	 *
	 * @param int    $stackPtr        The position of the current token in the stack.
	 * @param string $group_name      The name of the group which was matched.
	 * @param string $matched_content The token content (function name) which was matched
	 *                                in lowercase.
	 *
	 * @return int|void Integer stack pointer to skip forward or void to continue
	 *                  normal file processing.
	 */
	public function process_no_parameters( $stackPtr, $group_name, $matched_content ) {}
}
