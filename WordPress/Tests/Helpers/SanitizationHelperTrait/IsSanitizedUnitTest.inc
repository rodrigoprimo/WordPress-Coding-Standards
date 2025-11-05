<?php

/*
 * Test cases that should NOT be considered sanitized.
 */

// Variable not sanitized at all.
/* testNotSanitizedEcho */ echo $_POST['foo'];

// Variable not in any function.
/* testNotSanitizedAssignment */ $var = $_GET['bar'];

// Variable in non-sanitizing function.
/* testNonSanitizingFunction */ strtolower( $_POST['name'] );

// Only unslashed, not sanitized.
/* testOnlyUnslashed */ wp_unslash( $_POST['content'] );

// Namespaced sanitizing function (not a global function).
/* testNamespacedSanitizingFunction */ MyNamespace\sanitize_text_field( $_POST['title'] );

// Fully qualified namespaced function (not a global function).
/* testFullyQualifiedNamespacedFunction */ \MyNamespace\sanitize_text_field( $_POST['title'] );

// Namespace keyword relative function (not a global function).
/* testNamespaceRelativeFunction */ namespace\sanitize_text_field( $_POST['title'] );

// Method call (not a global function).
/* testMethodCall */ $obj->sanitize_text_field( $_POST['title'] );

// Static method call (not a global function).
/* testStaticMethodCall */ MyClass::sanitize_text_field( $_POST['title'] );

// Array walking function - namespaced (not a global function).
/* testNamespacedArrayMap */ MyNamespace\array_map( 'sanitize_text_field', $_POST['items'] );

// Array walking function - fully qualified namespaced (not a global function).
/* testFullyQualifiedNamespacedArrayMap */ \MyNamespace\array_map( 'sanitize_text_field', $_POST['items'] );

// Array walking function - namespace keyword relative (not a global function).
/* testNamespaceRelativeArrayMap */ namespace\array_map( 'sanitize_text_field', $_POST['items'] );

// Unslashing + sanitizing function - namespaced (not a global function).
/* testNamespacedUnslashAndSanitize */ MyNamespace\absint( $_POST['id'] );

// Unslashing + sanitizing function - fully qualified namespaced (not a global function).
/* testFullyQualifiedNamespacedUnslashAndSanitize */ \MyNamespace\absint( $_POST['id'] );

// Unslashing + sanitizing function - namespace keyword relative (not a global function).
/* testNamespaceRelativeUnslashAndSanitize */ namespace\absint( $_POST['id'] );

/*
 * Test cases that SHOULD be considered sanitized.
 */

// Sanitized with sanitize_text_field.
/* testSanitizeTextField */ sanitize_text_field( $_POST['name'] );

// Sanitized with absint (unslashing sanitizing function).
/* testAbsintSanitizing */ absint( $_POST['id'] );

// Sanitized with wp_kses_post.
/* testWpKsesPost */ wp_kses_post( $_POST['content'] );

// Unslashed then sanitized.
/* testUnslashedThenSanitized */ sanitize_text_field( wp_unslash( $_POST['name'] ) );

// Unslashed with fully qualified global function then sanitized.
/* testFullyQualifiedUnslashThenSanitized */ sanitize_text_field( \wp_unslash( $_POST['name'] ) );

/*
 * Namespaced inner function call where the base function name matches an unslashing function.
 *
 * Note: These are false positives in PHPCS 3.x. They should return `false` (not sanitized) since the inner
 * function is namespaced (not a global unslashing function), so `is_in_function_call()` should not continue
 * to the outer parentheses. Due to the bug described in
 * https://github.com/WordPress/WordPress-Coding-Standards/issues/2665, `is_sanitized()` incorrectly returns `true`.
 * This issue only affects PHPCS 3.x and does not happen in PHPCS 4.x.
 */
/* testNamespacedUnslashButStillSanitized1 */ sanitize_text_field( MyNamespace\wp_unslash( $_POST['foo'] ) );
/* testNamespacedUnslashButStillSanitized2 */ sanitize_text_field( \MyNamespace\wp_unslash( $_POST['foo'] ) );
/* testNamespacedUnslashButStillSanitized3 */ sanitize_text_field( namespace\wp_unslash( $_POST['foo'] ) );

// Safe casted.
/* testIntCast */ (int) $_POST['count'];
/* testBoolCast */ (bool) $_GET['flag'];

// Used in unset().
/* testInUnset */ unset( $_POST['temp'] );

// Fully qualified global function call.
/* testFullyQualifiedGlobalSanitize */ \sanitize_text_field( $_POST['name'] );

// With whitespace and comments.
/* testWithWhitespaceAndComments */ sanitize_email  (  $_POST /* comment */ ['email'] );

// Array walking function with callback.
/* testArrayMapWithCallback */ array_map( 'sanitize_text_field', $_POST['items'] );

// Array walking function - fully qualified global.
/* testFullyQualifiedArrayMap */ \array_map( 'sanitize_text_field', $_POST['items'] );

// Unslashing + sanitizing function.
/* testFullyQualifiedAbsint */ \absint( $_POST['id'] );

// Nested sanitizing functions.
/* testNestedSanitizing */ sanitize_key( sanitize_text_field( $_POST['key'] ) );
