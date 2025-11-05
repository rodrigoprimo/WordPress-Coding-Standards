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
 * Tests for the `SanitizationHelperTrait::get_sanitizing_functions()` utility method.
 *
 * @since 3.3.0
 *
 * @covers \WordPressCS\WordPress\Helpers\SanitizationHelperTrait::get_sanitizing_functions()
 */
final class GetSanitizingFunctionsUnitTest extends TestCase {

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
	 * Test that get_sanitizing_functions() returns an array.
	 *
	 * @return void
	 */
	public function testGetSanitizingFunctionsReturnsArray() {
		$result = self::$testClass->get_sanitizing_functions();
		$this->assertIsArray( $result );
	}

	/**
	 * Test that get_sanitizing_functions() returns known sanitizing functions.
	 *
	 * @return void
	 */
	public function testGetSanitizingFunctionsContainsKnownFunctions() {
		$result = self::$testClass->get_sanitizing_functions();

		// Test a few known sanitizing functions.
		$this->assertArrayHasKey( 'sanitize_text_field', $result );
		$this->assertArrayHasKey( 'sanitize_email', $result );
		$this->assertArrayHasKey( 'wp_kses_post', $result );
		$this->assertArrayHasKey( 'esc_url_raw', $result );
	}

	/**
	 * Test that get_sanitizing_functions() does not contain unslashing functions.
	 *
	 * @return void
	 */
	public function testGetSanitizingFunctionsDoesNotContainUnslashingFunctions() {
		$result = self::$testClass->get_sanitizing_functions();

		// These should be in the unslashing list, not the regular sanitizing list.
		$this->assertArrayNotHasKey( 'absint', $result );
		$this->assertArrayNotHasKey( 'intval', $result );
		$this->assertArrayNotHasKey( 'floatval', $result );
	}
}
