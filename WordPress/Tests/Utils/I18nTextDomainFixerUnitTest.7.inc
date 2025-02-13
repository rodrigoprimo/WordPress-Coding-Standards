<?php

// phpcs:set WordPress.Utils.I18nTextDomainFixer old_text_domain
// phpcs:set WordPress.Utils.I18nTextDomainFixer new_text_domain my-text-domain

/*
 * Test that AbstractFunctionParameterSniff does not treat first class callables and function
 * imports as a function call without parameters. This test is added here as there are no dedicated
 * tests for the WPCS abstract classes. The WPCS abstract classes will be replaced with PHPCSUtils
 * similar classes in the future, so it is not worth creating dedicated tests at this point.
 */

use function __;
use function __ as my_function;
add_action('my_action', __(...));
