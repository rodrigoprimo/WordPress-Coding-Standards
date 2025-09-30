<?php

// Test cases that should return false

some_function( /* testOtherFunctionCall */ $var1 );
$result = /* testVariableAssignment */ $var2;
// Variable not in array comparison function
other_function( /* testDifferentFunctionCall */ $var3 );
// Namespaced function call (not global)
MyNamespace\in_array( /* testPartiallyQualifiedInArray */ $needle, $haystack );
// Fully qualified namespaced function call
\MyNamespace\array_search( /* testFullyQualifiedNamespacedArraySearch */ $needle, $haystack );
// Method call (object operator)
$obj->in_array( /* testObjectMethodInArray */ $needle, $haystack );
// Static method call
ArrayHelper::in_array( /* testStaticMethodInArray */ $needle, $haystack );
// array_keys without filter_value parameter
array_keys( /* testArrayKeysFirstParamOnly */ $array );
// array_keys with wrong parameter name (should be filter_value)
array_keys( array: /* testArrayKeysWrongNamedParam */ $array, search_value: 'value', strict: true );
// Relative namespace function call
namespace\in_array( /* testNamespaceRelativeInArray */ $needle, $haystack );

// Test cases that should return true

// Basic in_array usage
in_array( /* testInArrayBasic */ $needle, $haystack );
in_array( /* testInArrayWithStrict */ $needle, $haystack, true );

// Basic array_search usage
array_search( /* testArraySearchBasic */ $needle, $haystack );
array_search( /* testArraySearchWithStrict */ $needle, $haystack, true );

// array_keys with filter_value parameter (second parameter)
array_keys( $array, /* testArrayKeysWithFilterValue */ $filter_value );
array_keys( $array, /* testArrayKeysWithFilterValueAndStrict */ $filter_value, true );

// array_keys with named parameters
array_keys( array: $array, filter_value: /* testArrayKeysNamedParams */ $search_value );
array_keys( array: $array, filter_value: /* testArrayKeysNamedParamsWithStrict */ $search_value, strict: true );

// Case insensitive function names
IN_ARRAY( /* testInArrayUppercase */ $needle, $haystack );
Array_Search( /* testArraySearchMixedCase */ $needle, $haystack );
ARRAY_KEYS( $array, /* testArrayKeysUppercase */ $filter_value );

// Fully qualified global function calls
\in_array( /* testInArrayFullyQualified */ $needle, $haystack );
\array_search( /* testArraySearchFullyQualified */ $needle, $haystack );
\array_keys( $array, /* testArrayKeysFullyQualified */ $filter_value );

// Complex expressions as parameters
in_array( /* testInArrayObjectProperty */ $obj->property, $haystack );
array_search( /* testArraySearchArrayAccess */ $array['key'], $haystack );
array_keys( $data, /* testArrayKeysFunctionCall */ get_value() );

// Multiple variables in the same function call
in_array( /* testInArrayFirstParam */ $needle1, $haystack );
in_array( $needle2, /* testInArraySecondParam */ $haystack );

// Nested array access
array_keys( /* testArrayKeysNestedArrayAccess */ $nested['array']['data'], $filter );
