<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress\Util\Tests\Helpers\ContextHelper;

use PHPCSUtils\Tokens\Collections;
use WordPressCS\WordPress\Helpers\ContextHelper;
use PHPCSUtils\TestUtils\UtilityMethodTestCase;

/**
 * Tests for the `ContextHelper::is_token_namespaced()` utility method.
 *
 * @since 3.3.0
 *
 * @covers \WordPressCS\WordPress\Helpers\ContextHelper::is_token_namespaced()
 */
final class IsTokenNamespacedUnitTest extends UtilityMethodTestCase {

	/**
	 * Test is_token_namespaced() returns false if the token does not exist.
	 *
	 * @return void
	 */
	public function testIsTokenNamespacedReturnFalseIfTokenDoesntExist() {
		$this->assertFalse( ContextHelper::is_token_namespaced( self::$phpcsFile, -1 ) );
	}

	/**
	 * Test is_token_namespaced() returns false for non-namespaced contexts.
	 *
	 * @dataProvider dataIsTokenNamespacedShouldReturnFalse
	 *
	 * @param string $commentString The comment which prefaces the target token in the test file.
	 * @param string $tokenContent  The token content to use for the target token.
	 *
	 * @return void
	 */
	public function testIsTokenNamespacedShouldReturnFalse( $commentString, $tokenContent ) {
		$stackPtr = $this->getTargetToken( $commentString, Collections::nameTokens(), $tokenContent );
		$this->assertFalse( ContextHelper::is_token_namespaced( self::$phpcsFile, $stackPtr ) );
	}

	/**
	 * Data provider.
	 *
	 * @return array
	 * @see testIsTokenNamespacedShouldReturnFalse()
	 */
	public static function dataIsTokenNamespacedShouldReturnFalse() {
		return array(
			array( '/* test return false 1 */', 'my_function' ),
			array( '/* test return false 2 */', 'my_function' ),
			array( '/* test return false 3 */', 'MyClass' ),
			array( '/* test return false 4 */', 'MyClass' ),
			array( '/* test return false 5 */', 'MY_CONSTANT' ),
			array( '/* test return false 6 */', 'MY_CONSTANT' ),
		);
	}

	/**
	 * Test is_token_namespaced() returns true for namespaced contexts.
	 *
	 * @dataProvider dataIsTokenNamespacedShouldReturnTrue
	 *
	 * @param string $commentString The comment which prefaces the target token in the test file.
	 * @param string $tokenContent  The token content to use for the target token.
	 *
	 * @return void
	 */
	public function testIsTokenNamespacedShouldReturnTrue( $commentString, $tokenContent ) {
		$stackPtr = $this->getTargetToken( $commentString, Collections::nameTokens(), $tokenContent );
		$this->assertTrue( ContextHelper::is_token_namespaced( self::$phpcsFile, $stackPtr ) );
	}

	/**
	 * Data provider.
	 *
	 * @return array
	 * @see testIsTokenNamespacedShouldReturnTrue()
	 */
	public static function dataIsTokenNamespacedShouldReturnTrue() {
		return array(
			array( '/* test return true 1 */', 'my_function' ),
			array( '/* test return true 2 */', 'my_function' ),
			array( '/* test return true 3 */', 'my_function' ),
			array( '/* test return true 4 */', 'MyClass' ),
			array( '/* test return true 5 */', 'MY_CONSTANT' ),
		);
	}
}
