<?php

/*
 * The below should NOT be recognized as namespaced tokens by ContextHelper::is_token_namespaced().
 */

/* test return false 1 */ my_function();
/* test return false 2 */ \my_function();
/* test return false 3 */ MyClass::my_static_method();
/* test return false 4 */ $var = new \MyClass();
/* test return false 5 */ $const = MY_CONSTANT;
/* test return false 6 */ $const = \MY_CONSTANT;

/*
 * The below should be recognized as namespaced tokens by ContextHelper::is_token_namespaced().
 */

/* test return true 1 */ MyNamespace\my_function();
/* test return true 2 */ \MyNamespace\my_function();
/* test return true 3 */ namespace\my_function(); // False positive if the file is not namespaced.
/* test return true 4 */ $var = new MyNamespace\MyClass();
/* test return true 5 */ $const = MyNamespace\MY_CONSTANT;
