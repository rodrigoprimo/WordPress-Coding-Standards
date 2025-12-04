<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress\Tests\Helpers\SanitizationHelperTrait;

use PHP_CodeSniffer\Files\File;
use PHPCSUtils\BackCompat\Helper;
use PHPCSUtils\TestUtils\UtilityMethodTestCase;
use WordPressCS\WordPress\Helpers\SanitizationHelperTrait;

/**
 * Tests for the `SanitizationHelperTrait::is_sanitized()` utility method.
 *
 * @since 3.3.0
 *
 * @covers \WordPressCS\WordPress\Helpers\SanitizationHelperTrait::is_sanitized()
 */
final class IsSanitizedUnitTest extends UtilityMethodTestCase {

	/**
	 * Test class using the SanitizationHelperTrait for testing purposes.
	 *
	 * @var object
	 */
	private static $testClass;

	/**
	 * Set up the test class.
	 *
	 * @beforeClass
	 *
	 * @return void
	 */
	public static function setUpBeforeClass(): void {
		parent::setUpBeforeClass();

		self::$testClass = new class() {
			use SanitizationHelperTrait;

			/**
			 * Wrapper for is_sanitized() for testing purposes.
			 *
			 * @param \PHP_CodeSniffer\Files\File $phpcsFile        The file being scanned.
			 * @param int                         $stackPtr         The index of the token in the stack.
			 * @param callable|null               $unslash_callback Optional. Callback for unslashing issues.
			 *
			 * @return bool Whether the token is being sanitized.
			 */
			public function test_is_sanitized( File $phpcsFile, $stackPtr, $unslash_callback = null ) {
				return $this->is_sanitized( $phpcsFile, $stackPtr, $unslash_callback );
			}
		};
	}

	/**
	 * Test is_sanitized().
	 *
	 * @dataProvider dataIsSanitized
	 *
	 * @param string $testMarker     The comment which prefaces the target token in the test file.
	 * @param bool   $expectedResult The expected return value.
	 *
	 * @return void
	 */
	public function testIsSanitized( $testMarker, $expectedResult ) {
		$stackPtr = $this->getTargetToken( $testMarker, \T_VARIABLE );
		$result   = self::$testClass->test_is_sanitized(
			self::$phpcsFile,
			$stackPtr
		);

		$this->assertSame( $expectedResult, $result, "Failed for: $testMarker" );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string, bool|string>>
	 * @see testIsSanitized()
	 */
	public static function dataIsSanitized() {
		$phpcs_version = Helper::getVersion();
		$is_phpcs_4    = version_compare( $phpcs_version, '3.99.99', '>' );

		return array(
			'not_sanitized_echo'                       => array(
				'testMarker'     => '/* testNotSanitizedEcho */',
				'expectedResult' => false,
			),
			'not_sanitized_assignment'                 => array(
				'testMarker'     => '/* testNotSanitizedAssignment */',
				'expectedResult' => false,
			),
			'non_sanitizing_function'                  => array(
				'testMarker'     => '/* testNonSanitizingFunction */',
				'expectedResult' => false,
			),
			'only_unslashed'                           => array(
				'testMarker'     => '/* testOnlyUnslashed */',
				'expectedResult' => false,
			),
			'namespaced_sanitizing_function'           => array(
				'testMarker'     => '/* testNamespacedSanitizingFunction */',
				'expectedResult' => false,
			),
			'fully_qualified_namespaced_function'      => array(
				'testMarker'     => '/* testFullyQualifiedNamespacedFunction */',
				'expectedResult' => false,
			),
			'namespace_relative_function'              => array(
				'testMarker'     => '/* testNamespaceRelativeFunction */',
				'expectedResult' => false,
			),
			'method_call'                              => array(
				'testMarker'     => '/* testMethodCall */',
				'expectedResult' => false,
			),
			'static_method_call'                       => array(
				'testMarker'     => '/* testStaticMethodCall */',
				'expectedResult' => false,
			),
			'namespaced_array_map'                     => array(
				'testMarker'     => '/* testNamespacedArrayMap */',
				'expectedResult' => false,
			),
			'fully_qualified_namespaced_array_map'     => array(
				'testMarker'     => '/* testFullyQualifiedNamespacedArrayMap */',
				'expectedResult' => false,
			),
			'namespace_relative_array_map'             => array(
				'testMarker'     => '/* testNamespaceRelativeArrayMap */',
				'expectedResult' => false,
			),
			'namespaced_unslash_and_sanitize'          => array(
				'testMarker'     => '/* testNamespacedUnslashAndSanitize */',
				'expectedResult' => false,
			),
			'fully_qualified_namespaced_unslash_and_sanitize' => array(
				'testMarker'     => '/* testFullyQualifiedNamespacedUnslashAndSanitize */',
				'expectedResult' => false,
			),
			'namespace_relative_unslash_and_sanitize'  => array(
				'testMarker'     => '/* testNamespaceRelativeUnslashAndSanitize */',
				'expectedResult' => false,
			),
			'sanitize_text_field'                      => array(
				'testMarker'     => '/* testSanitizeTextField */',
				'expectedResult' => true,
			),
			'absint_sanitizing'                        => array(
				'testMarker'     => '/* testAbsintSanitizing */',
				'expectedResult' => true,
			),
			'wp_kses_post'                             => array(
				'testMarker'     => '/* testWpKsesPost */',
				'expectedResult' => true,
			),
			'unslashed_then_sanitized'                 => array(
				'testMarker'     => '/* testUnslashedThenSanitized */',
				'expectedResult' => true,
			),
			'fully_qualified_unslash_then_sanitized'   => array(
				'testMarker'     => '/* testFullyQualifiedUnslashThenSanitized */',
				'expectedResult' => true,
			),

			// These are false positives in PHPCS 3.x. See: https://github.com/WordPress/WordPress-Coding-Standards/issues/2665.
			'namespaced_unslash_but_still_sanitized_1' => array(
				'testMarker'     => '/* testNamespacedUnslashButStillSanitized1 */',
				'expectedResult' => ( true === $is_phpcs_4 ) ? false : true,
			),
			'namespaced_unslash_but_still_sanitized_2' => array(
				'testMarker'     => '/* testNamespacedUnslashButStillSanitized2 */',
				'expectedResult' => ( true === $is_phpcs_4 ) ? false : true,
			),
			'namespaced_unslash_but_still_sanitized_3' => array(
				'testMarker'     => '/* testNamespacedUnslashButStillSanitized3 */',
				'expectedResult' => ( true === $is_phpcs_4 ) ? false : true,
			),

			'int_cast'                                 => array(
				'testMarker'     => '/* testIntCast */',
				'expectedResult' => true,
			),
			'bool_cast'                                => array(
				'testMarker'     => '/* testBoolCast */',
				'expectedResult' => true,
			),
			'in_unset'                                 => array(
				'testMarker'     => '/* testInUnset */',
				'expectedResult' => true,
			),
			'fully_qualified_global_sanitize'          => array(
				'testMarker'     => '/* testFullyQualifiedGlobalSanitize */',
				'expectedResult' => true,
			),
			'with_whitespace_and_comments'             => array(
				'testMarker'     => '/* testWithWhitespaceAndComments */',
				'expectedResult' => true,
			),
			'array_map_with_callback'                  => array(
				'testMarker'     => '/* testArrayMapWithCallback */',
				'expectedResult' => true,
			),
			'fully_qualified_array_map'                => array(
				'testMarker'     => '/* testFullyQualifiedArrayMap */',
				'expectedResult' => true,
			),
			'fully_qualified_absint'                   => array(
				'testMarker'     => '/* testFullyQualifiedAbsint */',
				'expectedResult' => true,
			),
			'nested_sanitizing'                        => array(
				'testMarker'     => '/* testNestedSanitizing */',
				'expectedResult' => true,
			),
		);
	}
}
