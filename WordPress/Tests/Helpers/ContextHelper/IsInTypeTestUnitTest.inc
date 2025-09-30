<?php

// Test cases that should return false

some_function( /* testOtherFunctionCall */ $var1 );
$result = /* testVariableAssignment */ $var2;
// Variable not in type test function
other_function( /* testDifferentFunctionCall */ $var3 );
// Namespaced function call (not global)
MyNamespace\is_numeric( /* testPartiallyQualifiedIsNumeric */ $value );
// Fully qualified namespaced function call
\MyNamespace\is_array( /* testFullyQualifiedNamespacedIsArray */ $data );
// Method call (object operator)
$obj->is_string( /* testObjectMethodIsString */ $value );
// Static method call
TypeChecker::is_int( /* testStaticMethodIsInt */ $value );
// Function that is not a type test
strlen( /* testNonTypeTestFunction */ $string );
// Relative namespace function call
namespace\is_bool( /* testNamespaceRelativeIsBool */ $value );
// Custom function with similar name
my_is_numeric( /* testCustomFunctionSimilarName */ $value );

// Test cases that should return true

// Basic type test functions
is_array( /* testIsArray */ $data );
is_bool( /* testIsBool */ $flag );
is_callable( /* testIsCallable */ $callback );
is_countable( /* testIsCountable */ $items );
is_double( /* testIsDouble */ $number );
is_float( /* testIsFloat */ $decimal );
is_int( /* testIsInt */ $count );
is_integer( /* testIsInteger */ $id );
is_iterable( /* testIsIterable */ $collection );
is_long( /* testIsLong */ $timestamp );
is_null( /* testIsNull */ $optional );
is_numeric( /* testIsNumeric */ $value );
is_object( /* testIsObject */ $instance );
is_real( /* testIsReal */ $coefficient );
is_resource( /* testIsResource */ $handle );
is_scalar( /* testIsScalar */ $primitive );
is_string( /* testIsString */ $text );

// Case insensitive function names
IS_ARRAY( /* testIsArrayUppercase */ $data );
Is_Bool( /* testIsBoolMixedCase */ $flag );
IS_NUMERIC( /* testIsNumericUppercase */ $value );

// Fully qualified global function calls
\is_array( /* testIsArrayFullyQualified */ $data );
\is_string( /* testIsStringFullyQualified */ $text );
\is_numeric( /* testIsNumericFullyQualified */ $value );

// Complex expressions as parameters
is_array( /* testIsArrayObjectProperty */ $obj->property );
is_string( /* testIsStringArrayAccess */ $array['key'] );
is_numeric( /* testIsNumericFunctionCall */ get_value() );

// Multiple variables in the same function call (though type test functions typically have one param)
is_callable( /* testIsCallableWithSecondParam */ $callback, false );

// Nested array/object access
is_array( /* testIsArrayNestedArrayAccess */ $nested['data']['items'] );
is_object( /* testIsObjectObjectProperty */ $config->settings );
