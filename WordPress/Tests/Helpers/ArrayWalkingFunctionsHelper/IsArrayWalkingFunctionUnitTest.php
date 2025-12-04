<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress\Tests\Helpers\ArrayWalkingFunctionsHelper;

use PHPUnit\Framework\TestCase;
use WordPressCS\WordPress\Helpers\ArrayWalkingFunctionsHelper;

/**
 * Tests for the `ArrayWalkingFunctionsHelper::is_array_walking_function()` method.
 *
 * @since 3.3.0
 *
 * @covers \WordPressCS\WordPress\Helpers\ArrayWalkingFunctionsHelper::is_array_walking_function()
 */
final class IsArrayWalkingFunctionUnitTest extends TestCase {

	/**
	 * Test is_array_walking_function().
	 *
	 * @dataProvider dataIsArrayWalkingFunction
	 *
	 * @param string $functionName   The function name to test.
	 * @param bool   $expectedResult The expected return value.
	 *
	 * @return void
	 */
	public function testIsArrayWalkingFunction( $functionName, $expectedResult ) {
		$result = ArrayWalkingFunctionsHelper::is_array_walking_function( $functionName );
		$this->assertSame( $expectedResult, $result, "Failed for function: $functionName" );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string, bool|string>>
	 * @see testIsArrayWalkingFunction()
	 */
	public static function dataIsArrayWalkingFunction() {
		return array(
			'array_map'           => array(
				'functionName'   => 'array_map',
				'expectedResult' => true,
			),
			'array_map_uppercase' => array(
				'functionName'   => 'ARRAY_MAP',
				'expectedResult' => true,
			),
			'fq_array_map'        => array(
				'functionName'   => '\array_map',
				'expectedResult' => true,
			),
			'array_filter'        => array(
				'functionName'   => 'array_filter',
				'expectedResult' => false,
			),
			'partially_qualified' => array(
				'functionName'   => 'MyNamespace\array_map',
				'expectedResult' => false,
			),
			'fq_namespaced'       => array(
				'functionName'   => '\MyNamespace\array_map',
				'expectedResult' => false,
			),
			'namespace_relative'  => array(
				'functionName'   => 'namespace\array_map',
				'expectedResult' => false,
			),
		);
	}
}
