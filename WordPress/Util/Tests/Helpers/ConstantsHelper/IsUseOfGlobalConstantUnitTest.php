<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress\Util\Tests\Helpers\ConstantsHelper;

use PHPCSUtils\BackCompat\Helper;
use PHPCSUtils\Tokens\Collections;
use WordPressCS\WordPress\Helpers\ConstantsHelper;
use PHPCSUtils\TestUtils\UtilityMethodTestCase;

/**
 * Tests for the `ConstantsHelper::is_use_of_global_constant()` utility method.
 *
 * @since 3.3.0
 *
 * @covers \WordPressCS\WordPress\Helpers\ConstantsHelper::is_use_of_global_constant()
 */
final class IsUseOfGlobalConstantUnitTest extends UtilityMethodTestCase {

	/**
	 * Test is_use_of_global_constant() returns false if the token does not exist.
	 *
	 * @return void
	 */
	public function testIsUseOfGlobalConstantReturnFalseIfTokenDoesntExist() {
		$this->assertFalse(
			ConstantsHelper::is_use_of_global_constant(
				self::$phpcsFile,
				-1
			)
		);
	}

	/**
	 * Test is_use_of_global_constant() returns false for non-constant contexts.
	 *
	 * @dataProvider dataIsUseOfGlobalConstantShouldReturnFalse
	 *
	 * @param string      $commentString The comment which prefaces the target token in the test file.
	 * @param int         $tokenType The token type to use for the target token.
	 * @param string|null $tokenContent The token content to use for the target token.
	 *
	 * @return void
	 */
	public function testIsUseOfGlobalConstantShouldReturnFalse( $commentString, $tokenType = null, $tokenContent = null ) {
		if ( null === $tokenType ) {
			$tokenType = Collections::nameTokens();

			$isPhpcs3 = version_compare( Helper::getVersion(), '3.99.99', '<=' );

			if ( null === $tokenContent || $isPhpcs3 ) {
				$tokenContent = 'PHP_OS';
			}
		}

		$stackPtr = $this->getTargetToken( $commentString, $tokenType, $tokenContent );
		$this->assertFalse( ConstantsHelper::is_use_of_global_constant( self::$phpcsFile, $stackPtr ) );
	}

	/**
	 * Data provider.
	 *
	 * @return array
	 * @see testIsUseOfGlobalConstantShouldReturnFalse()
	 */
	public static function dataIsUseOfGlobalConstantShouldReturnFalse() {
		return array(
			array( '/* test return false 1 */', \T_VARIABLE ),
			array( '/* test return false 2 */' ),
			array( '/* test return false 3 */', null, 'PHP_OS\Ns\SomeClass' ),
			array( '/* test return false 4 */' ),
			array( '/* test return false 5 */' ),
			array( '/* test return false 6 */' ),
			array( '/* test return false 7 */' ),
			array( '/* test return false 8 */' ),
			array( '/* test return false 9 */' ),
			array( '/* test return false 10 */' ),
			array( '/* test return false 11 */' ),
			array( '/* test return false 12 */' ),
			array( '/* test return false 13 */' ),
			array( '/* test return false 14 */' ),
			array( '/* test return false 15 */' ),
			array( '/* test return false 16 */' ),
			array( '/* test return false 17 */' ),
			array( '/* test return false 18 */' ),
			array( '/* test return false 19 */' ),
			array( '/* test return false 20 */' ),
			array( '/* test return false 21 */' ),
			array( '/* test return false 22 */' ),
			array( '/* test return false 23 */', null, '\My\Ns\PHP_OS' ),
			array( '/* test return false 24 */', null, 'My\Ns\PHP_OS' ),
			array( '/* test return false 25 */', null, 'namespace\Ns\PHP_OS' ),
			array( '/* test return false 26 */' ),
			array( '/* test return false 27 */', null, 'SomeNamespace\PHP_OS' ),
			array( '/* test return false 28 */' ),
			array( '/* test return false 29 */' ),
		);
	}

	/**
	 * Test is_use_of_global_constant() returns true for use of global constants.
	 *
	 * @dataProvider dataIsUseOfGlobalConstantShouldReturnTrue
	 *
	 * @param string      $commentString The comment which prefaces the target token in the test file.
	 * @param string|null $tokenContent The token content to use for the target token.
	 *
	 * @return void
	 */
	public function testIsUseOfGlobalConstantShouldReturnTrue( $commentString, $tokenContent = null ) {
		$isPhpcs3 = version_compare( Helper::getVersion(), '3.99.99', '<=' );

		if ( null === $tokenContent || $isPhpcs3 ) {
			$tokenContent = 'PHP_OS';
		}

		$tokenTypes = array(
			\T_STRING               => \T_STRING,
			\T_NAME_FULLY_QUALIFIED => \T_NAME_FULLY_QUALIFIED,
		);

		$stackPtr = $this->getTargetToken( $commentString, $tokenTypes, $tokenContent );
		$this->assertTrue( ConstantsHelper::is_use_of_global_constant( self::$phpcsFile, $stackPtr ) );
	}

	/**
	 * Data provider.
	 *
	 * @return array
	 * @see testIsUseOfGlobalConstantShouldReturnTrue()
	 */
	public static function dataIsUseOfGlobalConstantShouldReturnTrue() {
		return array(
			array( '/* test return true 1 */' ),
			array( '/* test return true 2 */', '\PHP_OS' ),
			array( '/* test return true 3 */' ),
			array( '/* test return true 4 */' ),
			array( '/* test return true 5 */' ),
			array( '/* test return true 6 */' ),
			array( '/* test return true 7 */' ),
			array( '/* test return true 8 */' ),
			array( '/* test return true 9 */' ),
			array( '/* test return true 10 */' ),
		);
	}
}
