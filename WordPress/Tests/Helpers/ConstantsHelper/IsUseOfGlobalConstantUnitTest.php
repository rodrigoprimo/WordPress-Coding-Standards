<?php
/**
 * WordPress Coding Standard.
 *
 * @package WPCS\WordPressCodingStandards
 * @link    https://github.com/WordPress/WordPress-Coding-Standards
 * @license https://opensource.org/licenses/MIT MIT
 */

namespace WordPressCS\WordPress\Tests\Helpers\ConstantsHelper;

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
	 * Test is_use_of_global_constant().
	 *
	 * @dataProvider dataIsUseOfGlobalConstant
	 *
	 * @param string      $testMarker     The comment which prefaces the target token in the test file.
	 * @param bool        $expectedResult The expected return value.
	 * @param int|null    $tokenType      Optional. The token type to use for the target token.
	 * @param string|null $tokenContent   Optional. The token content to use for the target token.
	 *
	 * @return void
	 */
	public function testIsUseOfGlobalConstant( $testMarker, $expectedResult, $tokenType = null, $tokenContent = null ) {
		if ( null === $tokenType ) {
			$tokenType = Collections::nameTokens();

			$isPhpcs3 = version_compare( Helper::getVersion(), '3.99.99', '<=' );

			if ( null === $tokenContent || $isPhpcs3 ) {
				$tokenContent = 'PHP_OS';
			}
		}

		if ( true === $expectedResult ) {
			// For true cases, we need to handle both T_STRING and T_NAME_FULLY_QUALIFIED.
			$tokenType = array(
				\T_STRING               => \T_STRING,
				\T_NAME_FULLY_QUALIFIED => \T_NAME_FULLY_QUALIFIED,
			);
		}

		$stackPtr = $this->getTargetToken( $testMarker, $tokenType, $tokenContent );
		$result   = ConstantsHelper::is_use_of_global_constant( self::$phpcsFile, $stackPtr );

		$this->assertSame( $expectedResult, $result, "Failed for: $testMarker" );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string, bool|int|string>>
	 * @see testIsUseOfGlobalConstant()
	 */
	public static function dataIsUseOfGlobalConstant() {
		return array(
			'variable_assignment' => array(
				'testMarker'     => '/* testVariableAssignment */',
				'expectedResult' => false,
				'tokenType'      => \T_VARIABLE,
			),
			'namespace_declaration' => array(
				'testMarker'     => '/* testNamespaceDeclaration */',
				'expectedResult' => false,
			),
			'use_statement' => array(
				'testMarker'     => '/* testUseStatement */',
				'expectedResult' => false,
				'tokenType'      => null,
				'tokenContent'   => 'PHP_OS\Ns\SomeClass',
			),
			'class_extends' => array(
				'testMarker'     => '/* testClassExtends */',
				'expectedResult' => false,
			),
			'class_implements' => array(
				'testMarker'     => '/* testClassImplements */',
				'expectedResult' => false,
			),
			'instantiation' => array(
				'testMarker'     => '/* testInstantiation */',
				'expectedResult' => false,
			),
			'function_declaration' => array(
				'testMarker'     => '/* testFunctionDeclaration */',
				'expectedResult' => false,
			),
			'instanceof' => array(
				'testMarker'     => '/* testInstanceof */',
				'expectedResult' => false,
			),
			'class_declaration' => array(
				'testMarker'     => '/* testClassDeclaration */',
				'expectedResult' => false,
			),
			'trait_use_declaration' => array(
				'testMarker'     => '/* testTraitUseDeclaration */',
				'expectedResult' => false,
			),
			'trait_adaptation_as_left' => array(
				'testMarker'     => '/* testTraitAdaptationAsLeft */',
				'expectedResult' => false,
			),
			'trait_adaptation_as_right' => array(
				'testMarker'     => '/* testTraitAdaptationAsRight */',
				'expectedResult' => false,
			),
			'goto_label' => array(
				'testMarker'     => '/* testGotoLabel */',
				'expectedResult' => false,
			),
			'interface_declaration' => array(
				'testMarker'     => '/* testInterfaceDeclaration */',
				'expectedResult' => false,
			),
			'trait_declaration' => array(
				'testMarker'     => '/* testTraitDeclaration */',
				'expectedResult' => false,
			),
			'enum_declaration' => array(
				'testMarker'     => '/* testEnumDeclaration */',
				'expectedResult' => false,
			),
			'class_constant_access' => array(
				'testMarker'     => '/* testClassConstantAccess */',
				'expectedResult' => false,
			),
			'object_property_access' => array(
				'testMarker'     => '/* testObjectPropertyAccess */',
				'expectedResult' => false,
			),
			'nullsafe_object_property_access' => array(
				'testMarker'     => '/* testNullsafeObjectPropertyAccess */',
				'expectedResult' => false,
			),
			'trait_method_alias_private' => array(
				'testMarker'     => '/* testTraitMethodAliasPrivate */',
				'expectedResult' => false,
			),
			'trait_method_alias_protected' => array(
				'testMarker'     => '/* testTraitMethodAliasProtected */',
				'expectedResult' => false,
			),
			'trait_method_alias_public' => array(
				'testMarker'     => '/* testTraitMethodAliasPublic */',
				'expectedResult' => false,
			),
			'fully_qualified_namespaced_constant' => array(
				'testMarker'     => '/* testFullyQualifiedNamespacedConstant */',
				'expectedResult' => false,
				'tokenType'      => null,
				'tokenContent'   => '\My\Ns\PHP_OS',
			),
			'partially_qualified_namespaced_constant' => array(
				'testMarker'     => '/* testPartiallyQualifiedNamespacedConstant */',
				'expectedResult' => false,
				'tokenType'      => null,
				'tokenContent'   => 'My\Ns\PHP_OS',
			),
			'namespace_relative_constant' => array(
				'testMarker'     => '/* testNamespaceRelativeConstant */',
				'expectedResult' => false,
				'tokenType'      => null,
				'tokenContent'   => 'namespace\Ns\PHP_OS',
			),
			'class_constant_declaration' => array(
				'testMarker'     => '/* testClassConstantDeclaration */',
				'expectedResult' => false,
			),
			'use_const_statement_with_alias' => array(
				'testMarker'     => '/* testUseConstStatementWithAlias */',
				'expectedResult' => false,
				'tokenType'      => null,
				'tokenContent'   => 'SomeNamespace\PHP_OS',
			),
			'use_const_statement_alias_target' => array(
				'testMarker'     => '/* testUseConstStatementAliasTarget */',
				'expectedResult' => false,
			),
			'use_const_statement_grouped' => array(
				'testMarker'     => '/* testUseConstStatementGrouped */',
				'expectedResult' => false,
			),
			'echo_statement' => array(
				'testMarker'     => '/* testEchoStatement */',
				'expectedResult' => true,
			),
			'echo_statement_fully_qualified' => array(
				'testMarker'     => '/* testEchoStatementFullyQualified */',
				'expectedResult' => true,
				'tokenType'      => null,
				'tokenContent'   => '\PHP_OS',
			),
			'function_parameter' => array(
				'testMarker'     => '/* testFunctionParameter */',
				'expectedResult' => true,
			),
			'include_expression' => array(
				'testMarker'     => '/* testIncludeExpression */',
				'expectedResult' => true,
			),
			'use_const_statement' => array(
				'testMarker'     => '/* testUseConstStatement */',
				'expectedResult' => true,
			),
			'switch_condition' => array(
				'testMarker'     => '/* testSwitchCondition */',
				'expectedResult' => true,
			),
			'case_condition' => array(
				'testMarker'     => '/* testCaseCondition */',
				'expectedResult' => true,
			),
			'const_declaration' => array(
				'testMarker'     => '/* testConstDeclaration */',
				'expectedResult' => true,
			),
			'array_assignment' => array(
				'testMarker'     => '/* testArrayAssignment */',
				'expectedResult' => true,
			),
			'const_declaration_in_list' => array(
				'testMarker'     => '/* testConstDeclarationInList */',
				'expectedResult' => true,
			),
		);
	}
}
