<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress\Tests\Helpers\ArrayWalkingFunctionsHelper;

use PHPCSUtils\TestUtils\UtilityMethodTestCase;
use WordPressCS\WordPress\Helpers\ArrayWalkingFunctionsHelper;

/**
 * Tests for the `ArrayWalkingFunctionsHelper::get_callback_parameter()` method.
 *
 * @since 3.3.0
 *
 * @covers \WordPressCS\WordPress\Helpers\ArrayWalkingFunctionsHelper::get_callback_parameter()
 */
final class GetCallbackParameterUnitTest extends UtilityMethodTestCase {

	/**
	 * Test get_callback_parameter() returns the callback parameter info.
	 *
	 * @dataProvider dataGetCallbackParameter
	 *
	 * @param string      $testMarker      The comment which prefaces the target token in the test file.
	 * @param string      $expectedContent The expected content of the callback parameter.
	 * @param string|bool $expectedResult  Whether a result is expected or false.
	 *
	 * @return void
	 */
	public function testGetCallbackParameter( $testMarker, $expectedContent, $expectedResult = true ) {
		$stackPtr = $this->getTargetToken( $testMarker, array( \T_STRING, \T_NAME_FULLY_QUALIFIED ) );
		$result   = ArrayWalkingFunctionsHelper::get_callback_parameter( self::$phpcsFile, $stackPtr );

		if ( false === $expectedResult ) {
			$this->assertFalse( $result, "Expected false for: $testMarker" );
		} else {
			$this->assertIsArray( $result, "Expected array result for: $testMarker" );
			$this->assertArrayHasKey( 'clean', $result, "Result should have 'clean' key for: $testMarker" );
			$this->assertSame( $expectedContent, $result['clean'], "Callback content mismatch for: $testMarker" );
		}
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string, string|bool>>
	 * @see testGetCallbackParameter()
	 */
	public static function dataGetCallbackParameter() {
		return array(
			'array_map_with_callback' => array(
				'testMarker'      => '/* testArrayMapWithCallback */',
				'expectedContent' => "'sanitize_text_field'",
			),
			'array_map_with_callback_fully_qualified' => array(
				'testMarker'      => '/* testArrayMapWithCallbackFullyQualified */',
				'expectedContent' => "'esc_html'",
			),
			'map_deep_with_callback' => array(
				'testMarker'      => '/* testMapDeepWithCallback */',
				'expectedContent' => "'sanitize_text_field'",
			),
			'map_deep_with_callback_fully_qualified' => array(
				'testMarker'      => '/* testMapDeepWithCallbackFullyQualified */',
				'expectedContent' => "'esc_attr'",
			),
			'array_map_single_argument' => array(
				'testMarker'      => '/* testArrayMapNoCallback */',
				'expectedContent' => '$array',
			),
			'not_array_walking_function' => array(
				'testMarker'      => '/* testNotArrayWalkingFunction */',
				'expectedContent' => '',
				'expectedResult'  => false,
			),
			'array_map_with_closure_callback' => array(
				'testMarker'      => '/* testArrayMapWithClosureCallback */',
				'expectedContent' => 'function( $item ) { return sanitize_text_field( $item ); }',
			),
			'array_map_with_arrow_function_callback' => array(
				'testMarker'      => '/* testArrayMapWithArrowFunctionCallback */',
				'expectedContent' => 'fn( $item ) => esc_html( $item )',
			),
		);
	}
}
