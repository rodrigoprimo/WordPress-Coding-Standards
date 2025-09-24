<?php

// Test cases that should return false

/* testStandaloneVariable */ $var1;
$result = /* testVariableAssignment */ $var2;
some_function( /* testOtherFunctionCall */ $var3 );
// Variable in first parameter of array_key_exists (key parameter, not array parameter)
array_key_exists( /* testArrayKeyExistsFirstParam */ $key, $array );
// Variable in first parameter of key_exists (key parameter, not array parameter)
key_exists( /* testKeyExistsFirstParam */ $key, $array );
other_function( /* testDifferentFunctionCall */ $var6 );
// isset/empty are not the last parenthesis owner - nested function call
isset( some_function( /* testNestedInIsset */ $var7 ) );
empty( get_option( /* testNestedInEmpty */ $var8 ) );
// Fully qualified namespaced calls (different function names)
\MyNamespace\array_key_exists( 'key', /* testNamespacedArrayKeyExists */ $array );

// Test cases that should return true

// Variables inside isset() - isset is last parenthesis owner
isset( /* testIssetSingleParam */ $var1 );
isset( /* testIssetFirstOfTwo */ $var2, /* testIssetSecondOfTwo */ $var3 );
isset( /* testIssetArrayAccess */ $var4['key'] );

// Variables inside empty() - empty is last parenthesis owner
empty( /* testEmptySingleParam */ $var5 );
empty( /* testEmptyArrayAccess */ $var6['key'] );

// Variables inside array_key_exists() - second parameter (array parameter)
array_key_exists( 'key', /* testArrayKeyExistsSecondParam */ $array1 );
array_key_exists( $key, /* testArrayKeyExistsSecondParamVariable */ $array2 );
array_key_exists( 'nested', /* testArrayKeyExistsNestedArray */ $array3['subarray'] );

// Variables inside key_exists() - second parameter (array parameter)
key_exists( 'key', /* testKeyExistsSecondParam */ $array4 );
key_exists( $key, /* testKeyExistsSecondParamVariable */ $array5 );

// Global namespaced calls (leading backslash)
\array_key_exists( 'key', /* testFullyQualifiedArrayKeyExists */ $global_array );
\key_exists( 'key', /* testFullyQualifiedKeyExists */ $global_array2 );

// These should return FALSE with default $global_function = true
namespace\array_key_exists( 'key', /* testNamespaceRelativeArrayKeyExists */ $ns_array );
namespace\key_exists( 'key', /* testNamespaceRelativeKeyExists */ $ns_array2 );
MyNamespace\array_key_exists( 'key', /* testPartiallyQualifiedArrayKeyExists */ $partial_array );
MyNamespace\key_exists( 'key', /* testPartiallyQualifiedKeyExists */ $partial_array2 );

// More complex array access in second parameter
array_key_exists( 'key', /* testArrayKeyExistsComplexNestedArray */ $complex['nested']['array'] );
key_exists( 'key', /* testKeyExistsComplexNestedArray */ $complex2['nested']['array'] );

// Variables that are the entire second parameter expression
array_key_exists( 'key', /* testArrayKeyExistsSimpleVariable */ $simple_var );
