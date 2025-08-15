<?php

/*
 * The below should NOT be recognized as use of a global constant.
 */

/* test return false 1 */ $a = 'foo';
/* test return false 2 */ namespace PHP_OS;
/* test return false 3 */ use PHP_OS\Ns\SomeClass;
class MyClass extends /* test return false 4 */ PHP_OS {}
class AnotherClass implements /* test return false 5 */ PHP_OS {}
$obj = new /* test return false 6 */ PHP_OS();
function /* test return false 7 */ PHP_OS() {}
if ( $a instanceof /* test return false 8 */ PHP_OS ) {}
class /* test return false 9 */ PHP_OS {
    /* test return false 10 */
    use PHP_OS {
        /* test return false 11 */
        PHP_OS::myMethod insteadof MyTrait;
        /* test return false 12 */
        MyTrait::anotherMethod insteadof PHP_OS;
    }
}
goto /* test return false 13 */ PHP_OS;
interface /* test return false 14 */ PHP_OS {}
trait /* test return false 15 */ PHP_OS {}
/* test return false 16 */ enum PHP_OS: string {}
/* test return false 17 */ MyClass::PHP_OS;
/* test return false 18 */ $obj->PHP_OS;
/* test return false 19 */ $obj?->PHP_OS;
class YetAnotherClass {
    use MyTrait {
        /* test return false 20 */
        foo as private PHP_OS;
        /* test return false 21 */
        bar as protected PHP_OS;
        /* test return false 22 */
        baz as public PHP_OS;
    }
}
/* test return false 23 */ \My\Ns\PHP_OS;
/* test return false 24 */ My\Ns\PHP_OS;
/* test return false 25 */ namespace\Ns\PHP_OS;
class Foo {
    /* test return false 26 */ const PHP_OS = 1;
}
/* test return false 27 */use const SomeNamespace\PHP_OS as EOL;
/* test return false 28 */use const ABC as PHP_OS;
/* test return false 29 */use const SomeNamespace\{PHP_OS, PHP_VERSION_ID};

/*
 * The below should be recognized as use of a global constant.
 */

/* test return true 1 */
echo PHP_OS;

/* test return true 2 */
echo \PHP_OS;

$folder = basename( /* test return true 3 */ PHP_OS );

/* test return true 4 */
include PHP_OS . '/js/myfile.js';

/* test return true 5 */
use const PHP_OS as SSP;

/* test return true 6 */
switch( PHP_OS ) {
    /* test return true 7 */
    case PHP_OS:
        break;
}

/* test return true 8 */
const PHP_OS = 'something';

/* test return true 9 */
$array[PHP_OS] = 'something';

/* test return true 10 */
const ABC = '123',
    DEF = '456',
    PHP_OS = 'something',
    GHI = 789;
