<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress\Tests\Helpers\WPHookHelper;

use PHPUnit\Framework\TestCase;
use WordPressCS\WordPress\Helpers\WPHookHelper;

/**
 * Tests for the `WPHookHelper::get_hook_name_param()` method.
 *
 * @since 3.3.0
 *
 * @covers \WordPressCS\WordPress\Helpers\WPHookHelper::get_hook_name_param()
 */
final class GetHookNameParamUnitTest extends TestCase {

	/**
	 * Test get_hook_name_param().
	 *
	 * @dataProvider dataGetHookNameParam
	 *
	 * @param string $functionName   The function name to test.
	 * @param bool   $expectedResult Whether the function should be recognized.
	 *
	 * @return void
	 */
	public function testGetHookNameParam( $functionName, $expectedResult ) {
		$result = WPHookHelper::get_hook_name_param( $functionName, array( 1 => array( 'raw' => 'test' ) ) );
		$this->assertSame( $expectedResult, \is_array( $result ), "Failed for function: $functionName" );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string, bool|string>>
	 * @see testGetHookNameParam()
	 */
	public static function dataGetHookNameParam() {
		return array(
			'do_action'             => array(
				'functionName'   => 'do_action',
				'expectedResult' => true,
			),
			'do_action_uppercase'   => array(
				'functionName'   => 'DO_ACTION',
				'expectedResult' => true,
			),
			'fq_do_action'          => array(
				'functionName'   => '\do_action',
				'expectedResult' => true,
			),
			'function_not_targeted' => array(
				'functionName'   => 'function_not_targeted',
				'expectedResult' => false,
			),
			'partially_qualified'   => array(
				'functionName'   => 'MyNamespace\do_action',
				'expectedResult' => false,
			),
			'fq_namespaced'         => array(
				'functionName'   => '\MyNamespace\do_action',
				'expectedResult' => false,
			),
			'namespace_relative'    => array(
				'functionName'   => 'namespace\do_action',
				'expectedResult' => false,
			),
		);
	}
}
