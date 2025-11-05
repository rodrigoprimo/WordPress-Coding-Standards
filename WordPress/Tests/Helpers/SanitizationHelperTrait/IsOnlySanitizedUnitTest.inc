<?php

/*
 * Test cases that should NOT be considered ONLY sanitized.
 */

// Variable not sanitized at all.
/* testNotSanitizedEcho */ echo $_POST['foo'];

// Nested in multiple parentheses (more than just the sanitizing function).
/* testNestedInMultipleFunctions */ sanitize_text_field( strtolower( $_POST['name'] ) );

// Unslashed function, not sanitized.
/* testOnlyUnslashed */ wp_unslash( $_POST['content'] );

/*
 * Test cases that SHOULD be considered ONLY sanitized.
 */

// Simple sanitization.
/* testSimpleSanitization */ sanitize_text_field( $_POST['name'] );

// Unslashing sanitizing function.
/* testUnslashingSanitizingFunction */ absint( $_POST['id'] );

// Safe casted (not in a function, so technically ONLY casted).
/* testIntCast */ (int) $_POST['count'];
/* testBoolCast */ (bool) $_GET['flag'];
