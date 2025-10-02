<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress\Tests\Helpers\WPDBTrait;

use PHP_CodeSniffer\Files\File;
use PHPCSUtils\BackCompat\Helper;
use WordPressCS\WordPress\Helpers\WPDBTrait;
use PHPCSUtils\TestUtils\UtilityMethodTestCase;

/**
 * Tests for the `WPDBTrait::is_wpdb_method_call()` utility method.
 *
 * @since 3.3.0
 *
 * @covers \WordPressCS\WordPress\Helpers\WPDBTrait::is_wpdb_method_call()
 */
final class IsWpdbMethodCallUnitTest extends UtilityMethodTestCase {

	/**
	 * Test class using the WPDBTrait for testing purposes.
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
			use WPDBTrait;

			/**
			 * Stack pointer to the method name.
			 *
			 * @var int
			 */
			public $methodPtr;

			/**
			 * Stack pointer to the opening parenthesis of the method call.
			 *
			 * @var int
			 */
			public $i;

			/**
			 * Stack pointer to the end of the first parameter.
			 *
			 * @var int
			 */
			public $end;

			/**
			 * Wrapper for is_wpdb_method_call() for testing purposes.
			 *
			 * @param \PHP_CodeSniffer\Files\File $phpcsFile      The file being scanned.
			 * @param int                         $stackPtr       The index of the $wpdb variable or wpdb class name token.
			 * @param array                       $target_methods Array of methods. Key(s) should be method name
			 *                                                    in lowercase.
			 *
			 * @return bool Whether this is a $wpdb method call.
			 */
			public function test_is_wpdb_method_call( File $phpcsFile, $stackPtr, array $target_methods ) {
				return $this->is_wpdb_method_call( $phpcsFile, $stackPtr, $target_methods );
			}
		};
	}

	/**
	 * Test is_wpdb_method_call().
	 *
	 * @dataProvider dataIsWpdbMethodCall
	 *
	 * @param string      $testMarker     The comment which prefaces the target token in the test file.
	 * @param bool        $expectedResult The expected return value.
	 * @param int|string  $tokenType      The token type to search for.
	 * @param string|null $tokenContent   The token content to search for (if applicable).
	 *
	 * @return void
	 */
	public function testIsWpdbMethodCall( $testMarker, $expectedResult, $tokenType, $tokenContent = null ) {
		$stackPtr = $this->getTargetToken( $testMarker, $tokenType, $tokenContent );
		$result   = self::$testClass->test_is_wpdb_method_call(
			self::$phpcsFile,
			$stackPtr,
			array(
				'prepare'  => true,
				'esc_like' => true,
			)
		);

		$this->assertSame( $expectedResult, $result, "Failed for: $testMarker" );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string, bool|int|string|null>>
	 * @see testIsWpdbMethodCall()
	 */
	public static function dataIsWpdbMethodCall() {
		$isPhpcs3     = version_compare( Helper::getVersion(), '3.99.99', '<=' );
		$tokenContent = null;

		if ( $isPhpcs3 ) {
			$tokenContent = 'wpdb';
		}

		return array(
			'not_wpdb_variable' => array(
				'testMarker'     => '/* testNotWpdbVariable */',
				'expectedResult' => false,
				'tokenType'      => \T_VARIABLE,
			),
			'not_wpdb_class' => array(
				'testMarker'     => '/* testNotWpdbClass */',
				'expectedResult' => false,
				'tokenType'      => \T_STRING,
			),
			'wpdb_not_method_call' => array(
				'testMarker'     => '/* testWpdbNotMethodCall */',
				'expectedResult' => false,
				'tokenType'      => \T_VARIABLE,
			),
			'wpdb_array_access' => array(
				'testMarker'     => '/* testWpdbArrayAccess */',
				'expectedResult' => false,
				'tokenType'      => \T_VARIABLE,
			),
			'wpdb_assignment' => array(
				'testMarker'     => '/* testWpdbAssignment */',
				'expectedResult' => false,
				'tokenType'      => \T_VARIABLE,
			),
			'property_access' => array(
				'testMarker'     => '/* testPropertyAccess */',
				'expectedResult' => false,
				'tokenType'      => \T_VARIABLE,
			),
			'function_call' => array(
				'testMarker'     => '/* testFunctionCall */',
				'expectedResult' => false,
				'tokenType'      => \T_STRING,
			),
			'namespaced_wpdb' => array(
				'testMarker'     => '/* testNamespacedWpdb */',
				'expectedResult' => false,
				'tokenType'      => $isPhpcs3 ? \T_STRING : \T_NAME_QUALIFIED,
				'tokenContent'   => $tokenContent,
			),
			'fully_qualified_namespaced_wpdb' => array(
				'testMarker'     => '/* testFullyQualifiedNamespacedWpdb */',
				'expectedResult' => false,
				'tokenType'      => $isPhpcs3 ? \T_STRING : \T_NAME_FULLY_QUALIFIED,
				'tokenContent'   => $tokenContent,
			),
			'namespace_relative_wpdb' => array(
				'testMarker'     => '/* testNamespaceRelativeWpdb */',
				'expectedResult' => false,
				'tokenType'      => $isPhpcs3 ? \T_STRING : \T_NAME_RELATIVE,
				'tokenContent'   => $tokenContent,
			),
			'not_target_method' => array(
				'testMarker'     => '/* testNotTargetMethod */',
				'expectedResult' => false,
				'tokenType'      => \T_VARIABLE,
			),
			'wpdb_prepare' => array(
				'testMarker'     => '/* testWpdbPrepare */',
				'expectedResult' => true,
				'tokenType'      => \T_VARIABLE,
			),
			'wpdb_prepare_with_variable' => array(
				'testMarker'     => '/* testWpdbPrepareWithVariable */',
				'expectedResult' => true,
				'tokenType'      => \T_VARIABLE,
			),
			'wpdb_prepare_with_whitespace' => array(
				'testMarker'     => '/* testWpdbPrepareWithWhitespace */',
				'expectedResult' => true,
				'tokenType'      => \T_VARIABLE,
			),
			'wpdb_prepare_static_with_comments' => array(
				'testMarker'     => '/* testWpdbPrepareStaticWithComments */',
				'expectedResult' => true,
				'tokenType'      => \T_VARIABLE,
			),
			'wpdb_esc_like_unqualified_class' => array(
				'testMarker'     => '/* testWpdbEscLikeUnqualifiedClass */',
				'expectedResult' => true,
				'tokenType'      => \T_STRING,
			),
			'wpdb_esc_like_fully_qualified_global' => array(
				'testMarker'     => '/* testWpdbEscLikeFullyQualifiedGlobal */',
				'expectedResult' => true,
				'tokenType'      => $isPhpcs3 ? \T_STRING : \T_NAME_FULLY_QUALIFIED,
			),
		);
	}
}
