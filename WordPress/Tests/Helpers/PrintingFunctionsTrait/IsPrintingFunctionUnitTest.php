<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress\Tests\Helpers\PrintingFunctionsTrait;

use PHPUnit\Framework\TestCase;
use WordPressCS\WordPress\Helpers\PrintingFunctionsTrait;

/**
 * Tests for the `PrintingFunctionsTrait::is_printing_function()` method.
 *
 * @since 3.3.0
 *
 * @covers \WordPressCS\WordPress\Helpers\PrintingFunctionsTrait::is_printing_function()
 */
final class IsPrintingFunctionUnitTest extends TestCase {

	/**
	 * Test class using the PrintingFunctionsTrait for testing purposes.
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
		self::$testClass = new class() {
			use PrintingFunctionsTrait;
		};
	}

	/**
	 * Test is_printing_function().
	 *
	 * @dataProvider dataIsPrintingFunction
	 *
	 * @param string $functionName   The function name to test.
	 * @param bool   $expectedResult The expected return value.
	 *
	 * @return void
	 */
	public function testIsPrintingFunction( $functionName, $expectedResult ) {
		$result = self::$testClass->is_printing_function( $functionName );
		$this->assertSame( $expectedResult, $result, "Failed for function: $functionName" );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string, bool|string>>
	 * @see testIsPrintingFunction()
	 */
	public static function dataIsPrintingFunction() {
		return array(
			'printf'              => array(
				'functionName'   => 'printf',
				'expectedResult' => true,
			),
			'printf_uppercase'    => array(
				'functionName'   => 'PRINTF',
				'expectedResult' => true,
			),
			'fq_printf'           => array(
				'functionName'   => '\printf',
				'expectedResult' => true,
			),
			'echo'                => array(
				'functionName'   => 'echo',
				'expectedResult' => false,
			),
			'partially_qualified' => array(
				'functionName'   => 'MyNamespace\printf',
				'expectedResult' => false,
			),
			'fq_namespaced'       => array(
				'functionName'   => '\MyNamespace\printf',
				'expectedResult' => false,
			),
			'namespace_relative'  => array(
				'functionName'   => 'namespace\printf',
				'expectedResult' => false,
			),
		);
	}
}
