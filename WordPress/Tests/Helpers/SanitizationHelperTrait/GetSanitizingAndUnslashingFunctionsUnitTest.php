<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress\Tests\Helpers\SanitizationHelperTrait;

use PHPUnit\Framework\TestCase;
use WordPressCS\WordPress\Helpers\SanitizationHelperTrait;

/**
 * Tests for the `SanitizationHelperTrait::get_sanitizing_and_unslashing_functions()` utility method.
 *
 * @since 3.3.0
 *
 * @covers \WordPressCS\WordPress\Helpers\SanitizationHelperTrait::get_sanitizing_and_unslashing_functions()
 */
final class GetSanitizingAndUnslashingFunctionsUnitTest extends TestCase {

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
		self::$testClass = new class() {
			use SanitizationHelperTrait;
		};
	}

	/**
	 * Test that get_sanitizing_and_unslashing_functions() returns an array.
	 *
	 * @return void
	 */
	public function testGetSanitizingAndUnslashingFunctionsReturnsArray() {
		$result = self::$testClass->get_sanitizing_and_unslashing_functions();
		$this->assertIsArray( $result );
	}

	/**
	 * Test that get_sanitizing_and_unslashing_functions() returns known unslashing sanitizing functions.
	 *
	 * @return void
	 */
	public function testGetSanitizingAndUnslashingFunctionsContainsKnownFunctions() {
		$result = self::$testClass->get_sanitizing_and_unslashing_functions();

		// Test known unslashing sanitizing functions.
		$this->assertArrayHasKey( 'absint', $result );
		$this->assertArrayHasKey( 'intval', $result );
		$this->assertArrayHasKey( 'floatval', $result );
		$this->assertArrayHasKey( 'sanitize_key', $result );
	}

	/**
	 * Test that get_sanitizing_and_unslashing_functions() does not contain regular sanitizing functions.
	 *
	 * @return void
	 */
	public function testGetSanitizingAndUnslashingFunctionsDoesNotContainRegularSanitizingFunctions() {
		$result = self::$testClass->get_sanitizing_and_unslashing_functions();

		// These should be in the regular sanitizing list, not the unslashing list.
		$this->assertArrayNotHasKey( 'sanitize_text_field', $result );
		$this->assertArrayNotHasKey( 'wp_kses_post', $result );
	}
}
