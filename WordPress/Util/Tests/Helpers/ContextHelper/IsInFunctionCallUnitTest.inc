<?php

/*
 * Make sure that tokens inside a function call are correctly identified using the default values
 * for the optional parameters (`$global_function = true` and `$allow_nested = false`).
 *
 * The below should *NOT* be recognized as inside a function call.
 */

$a = /* test return false 1 */ 'foo';
another_function( /* test return false 2 */ $a );
MyNamespace\my_function( /* test return false 3 */ $a );
\MyNamespace\my_function( /* test return false 4 */ $a );
namespace\MyNamespace\my_function( /* test return false 5 */ $a );
my_function( another_function( /* test return false 6 */ $a ) );
$anon_func = function() {
    /* test return false 7 */ $a = 'foo';
};

/*
 * Make sure that tokens inside a function call are correctly identified using the default values
 * for the optional parameters (`$global_function = true` and `$allow_nested = false`).
 *
 * The below should be recognized as inside a function call.
 */

/* test function call 1 */ my_function( /* test inside function pointer 1 */ $a );
/* test function call 2 */ MY_FUNCTION( /* test inside function pointer 2 */ $a );
/* test function call 3 */ \my_function( /* test inside function pointer 3 */ $a );

/*
 * Make sure that tokens inside a function call are correctly identified when `$global_function` is
 * set to false.
 *
 * The below should be recognized as inside a function call.
 */

/* test function call 4 */ my_function( /* test inside function pointer 4 */ $a );
/* test function call 5 */ MY_FUNCTION( /* test inside function pointer 5 */ $a );
/* test function call 6 */ \my_function( /* test inside function pointer 6 */ $a );
MyNamespace\/* test function call 7 */my_function( /* test inside function pointer 7 */ $a );
\MyNamespace\/* test function call 8 */my_function( /* test inside function pointer 8 */ $a );
namespace\MyNamespace\/* test function call 9 */my_function( /* test inside function pointer 9 */ $a );
MyClass::/* test function call 10 */my_function( /* test inside function pointer 10 */ $a );
/* test function call 11 */ $obj->my_function( /* test inside function pointer 11 */ $a );
/* test function call 12 */ $obj?->my_function( /* test inside function pointer 12 */ $a );

/*
 * Make sure that tokens inside a function call are correctly identified when `$allow_nested` is
 * set to true.
 *
 * The below should be recognized as inside a function call.
 */
/* test function call 13 */ my_function( another_function( /* test inside function pointer 13 */ $a ) );
