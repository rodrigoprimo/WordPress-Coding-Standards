<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress\Tests\Helpers\SanitizationHelperTrait;

use PHPCSUtils\TestUtils\UtilityMethodTestCase;
use WordPressCS\WordPress\Helpers\SanitizationHelperTrait;

/**
 * Tests for the `SanitizationHelperTrait::is_only_sanitized()` utility method.
 *
 * @since 3.4.0
 *
 * @covers \WordPressCS\WordPress\Helpers\SanitizationHelperTrait::is_only_sanitized
 */
final class IsOnlySanitizedUnitTest extends UtilityMethodTestCase {

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
		};
	}

	/**
	 * Test is_only_sanitized() returns false if the token does not exist.
	 *
	 * @return void
	 */
	public function testIsOnlySanitizedReturnsFalseIfTokenDoesNotExist() {
		$this->assertFalse( self::$testClass->is_only_sanitized( self::$phpcsFile, -1 ) );
	}

	/**
	 * Test is_only_sanitized().
	 *
	 * @dataProvider dataIsOnlySanitized
	 *
	 * @param string $testMarker     The comment which prefaces the target token in the test file.
	 * @param bool   $expectedResult The expected return value.
	 *
	 * @return void
	 */
	public function testIsOnlySanitized( $testMarker, $expectedResult ) {
		$stackPtr = $this->getTargetToken( $testMarker, \T_VARIABLE );
		$result   = self::$testClass->is_only_sanitized(
			self::$phpcsFile,
			$stackPtr
		);

		$this->assertSame( $expectedResult, $result, "Failed for: $testMarker" );
	}

	/**
	 * Data provider.
	 *
	 * @see testIsOnlySanitized()
	 *
	 * @return array<string, array<string, bool|string>>
	 */
	public static function dataIsOnlySanitized() {
		return array(
			'not_sanitized_echo'             => array(
				'testMarker'     => '/* testNotSanitizedEcho */',
				'expectedResult' => false,
			),
			'nested_in_multiple_functions'   => array(
				'testMarker'     => '/* testNestedInMultipleFunctions */',
				'expectedResult' => false,
			),
			'only_unslashed'                 => array(
				'testMarker'     => '/* testOnlyUnslashed */',
				'expectedResult' => false,
			),
			'simple_sanitization'            => array(
				'testMarker'     => '/* testSimpleSanitization */',
				'expectedResult' => true,
			),
			'unslashing_sanitizing_function' => array(
				'testMarker'     => '/* testUnslashingSanitizingFunction */',
				'expectedResult' => true,
			),
			'int_cast'                       => array(
				'testMarker'     => '/* testIntCast */',
				'expectedResult' => true,
			),
			'bool_cast'                      => array(
				'testMarker'     => '/* testBoolCast */',
				'expectedResult' => true,
			),
		);
	}
}
