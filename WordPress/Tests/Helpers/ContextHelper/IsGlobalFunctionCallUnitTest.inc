<?php

/*
 * The below should be recognized as a call to the global target function.
 */

/* testLowercaseName */
valid_function( $param );

/* testUppercaseName */
VALID_FUNCTION();

/* testFullyQualifiedGlobal */
\valid_function( $param );

/*
 * The below should NOT be recognized as a call to the global target function
 */

/* testDifferentFunction */
other_function( $param );

/* testNotAFunctionCall */
$x = VALID_FUNCTION;

/* testObjectMethod */
$obj->valid_function( $param );

/* testNullsafeObjectMethod */
$obj?->valid_function( $param );

/* testStaticMethod */
MyClass::valid_function( $param );

/* testNamespacedFunction */
MyNamespace\valid_function( $param );

/* testFullyQualifiedNamespacedFunction */
\MyNamespace\valid_function( $param );

/* testNamespaceRelativeFunction */
namespace\valid_function( $param ); // The method should start recognizing this as a valid function call once it can resolve relative namespaces since this test file is not namespaced.

/* testNamespaceRelativeSubFunction */
namespace\Sub\valid_function( $param );

/* testFunctionDeclaration */
function valid_function() {}

/* testFunctionDeclarationByReference */
function &valid_function() {}

/* testObjectInstantiation */
new valid_function();
