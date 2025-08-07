<?php

/*
 * The below should NOT be recognized as a $wpdb method call.
 */

/* testNotWpdbVariable */
$db->prepare( 'SELECT * FROM table' );
/* testNotWpdbClass */
DB::esc_like( $find );
$array[] = /* testWpdbNotMethodCall */ $wpdb;

// Note: testPropertyAccessOpenParen points to the semicolon, not a parenthesis, as this is a property access. I'm inclined to think this is a bug and the method should not set $this->i in this case.
/* testPropertyAccess */
echo $wpdb->num_queries /* testPropertyAccessOpenParen */ ;

/* testFunctionCall */
$result = wpdb( 'SELECT * FROM table' );
/* testNotTargetMethod */
$wpdb->insert /* testNotTargetMethodOpenParen */ ( 'table', array( 'name' => 'value' ) );
/* testUppercaseWpdbVariable */
$WPDB->prepare( 'SELECT * FROM table' );

// Bug: the method should probably bail early when the token after the object operator is not T_STRING.
/* testVariableMethodCall */
$wpdb->$prepare /* testVariableMethodCallOpenParen */ ( 'SELECT * FROM table' );

/* testPartiallyQualified */
MyNamespace\wpdb::esc_like /* testPartiallyQualifiedOpenParen */ ( $find );
/* testFullyQualifiedNamespaced */
\MyNamespace\wpdb::esc_like /* testFullyQualifiedNamespacedOpenParen */ ( $find );
/* testNamespaceRelative */
namespace\wpdb::esc_like /* testNamespaceRelativeOpenParen */ ( $find ); // The method should start recognizing this as a WPDB method call once it can resolve relative namespaces.
/* testNamespaceRelativeSub */
namespace\Sub\wpdb::esc_like /* testNamespaceRelativeSubOpenParen */ ( $find );
my_function( /* testNotStringOrVariable */ )->prepare /* testNotStringOrVariableOpenParen */ ( 'SELECT * FROM table' );

/*
 * The below should be recognized as a $wpdb method call.
 */

/* testObjectOperator */
$wpdb->prepare /* testObjectOperatorOpenParen */ ( 'SELECT * FROM table WHERE id = %d', $id );
/* testNullsafeObjectOperator */
$wpdb?->PREPARE /* testNullsafeObjectOperatorOpenParen */ ( 'SELECT * FROM table WHERE id = %d', $id );
/* testUnqualifiedClassUppercase */
WPDB::esc_like /* testUnqualifiedClassUppercaseOpenParen */ ( $find );
/* testUnqualifiedClassLowercase */
wpdb::esc_like /* testUnqualifiedClassLowercaseOpenParen */ ( $find );
/* testFullyQualifiedGlobalLowercase */
\wpdb::esc_like /* testFullyQualifiedGlobalLowercaseOpenParen */ ( $find );
/* testFullyQualifiedGlobalUppercase */
\WPDB /* comment */ :: /* comment */ esc_like /* testFullyQualifiedGlobalUppercaseOpenParen */ ( $find );
