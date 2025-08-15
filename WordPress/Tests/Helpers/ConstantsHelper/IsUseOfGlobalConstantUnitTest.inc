<?php

/*
 * The below should NOT be recognized as use of a global constant.
 */

/* testVariableAssignment */ $a = 'foo';
/* testNamespaceDeclaration */ namespace PHP_OS;
/* testUseStatement */ use PHP_OS\Ns\SomeClass;
class MyClass extends /* testClassExtends */ PHP_OS {}
class AnotherClass implements /* testClassImplements */ PHP_OS {}
$obj = new /* testInstantiation */ PHP_OS();
function /* testFunctionDeclaration */ PHP_OS() {}
if ( $a instanceof /* testInstanceof */ PHP_OS ) {}
class /* testClassDeclaration */ PHP_OS {
	/* testTraitUseDeclaration */
	use PHP_OS {
		/* testTraitAdaptationAsLeft */
		PHP_OS::myMethod insteadof MyTrait;
		/* testTraitAdaptationAsRight */
		MyTrait::anotherMethod insteadof PHP_OS;
	}
}
goto /* testGotoLabel */ PHP_OS;
interface /* testInterfaceDeclaration */ PHP_OS {}
trait /* testTraitDeclaration */ PHP_OS {}
/* testEnumDeclaration */ enum PHP_OS: string {}
/* testClassConstantAccess */ MyClass::PHP_OS;
/* testObjectPropertyAccess */ $obj->PHP_OS;
/* testNullsafeObjectPropertyAccess */ $obj?->PHP_OS;
class YetAnotherClass {
	use MyTrait {
		/* testTraitMethodAliasPrivate */
		foo as private PHP_OS;
		/* testTraitMethodAliasProtected */
		bar as protected PHP_OS;
		/* testTraitMethodAliasPublic */
		baz as public PHP_OS;
	}
}
/* testFullyQualifiedNamespacedConstant */ \My\Ns\PHP_OS;
/* testPartiallyQualifiedNamespacedConstant */ My\Ns\PHP_OS;
/* testNamespaceRelativeConstant */ namespace\Ns\PHP_OS;
class Foo {
	/* testClassConstantDeclaration */ const PHP_OS = 1;
}
/* testUseConstStatementWithAlias */use const SomeNamespace\PHP_OS as EOL;
/* testUseConstStatementAliasTarget */use const ABC as PHP_OS;
/* testUseConstStatementGrouped */use const SomeNamespace\{PHP_OS, PHP_VERSION_ID};

/*
 * The below should be recognized as use of a global constant.
 */

/* testEchoStatement */
echo PHP_OS;

/* testEchoStatementFullyQualified */
echo \PHP_OS;

$folder = basename( /* testFunctionParameter */ PHP_OS );

/* testIncludeExpression */
include PHP_OS . '/js/myfile.js';

/* testUseConstStatement */
use const PHP_OS as SSP;

/* testSwitchCondition */
switch( PHP_OS ) {
	/* testCaseCondition */
	case PHP_OS:
		break;
}

/* testConstDeclaration */
const PHP_OS = 'something';

/* testArrayAssignment */
$array[PHP_OS] = 'something';

/* testConstDeclarationInList */
const ABC = '123',
	DEF = '456',
	PHP_OS = 'something',
	GHI = 789;
