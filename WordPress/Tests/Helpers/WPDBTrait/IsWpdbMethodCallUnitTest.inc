<?php

/*
 * Test cases that should NOT be recognized as WPDB method calls.
 */

// Not a WPDB variable.
/* testNotWpdbVariable */ $db->prepare( 'SELECT * FROM table' );
/* testNotWpdbClass */ DB::esc_like( $find );

// WPDB variable but not a method call.
/* testWpdbNotMethodCall */ $wpdb;
/* testWpdbArrayAccess */ $wpdb['key'];
/* testWpdbAssignment */ $wpdb = new wpdb();

// Property access (not method calls).
/* testPropertyAccess */ echo $wpdb->num_queries;

// Function calls, not object method calls.
/* testFunctionCall */ $result = wpdb( 'SELECT * FROM table' );

/* testNamespacedWpdb */ MyNamespace\wpdb::esc_like( $find );
/* testFullyQualifiedNamespacedWpdb */ \MyNamespace\wpdb::esc_like( $find );
/* testNamespaceRelativeWpdb */ namespace\wpdb::esc_like( $find ); // The sniff should start flagging this once it can resolve relative namespaces.

// WPDB method calls but not target methods.
/* testNotTargetMethod */ $wpdb->insert( 'table', array( 'name' => 'value' ) );

/*
 * Test cases that should be recognized as WPDB method calls.
 */

/* testWpdbPrepare */ $wpdb->prepare( 'SELECT * FROM table WHERE id = %d', $id );
/* testWpdbPrepareWithVariable */ $wpdb->prepare( $sql );
/* testWpdbPrepareWithWhitespace */ $wpdb  ->  prepare( 'SELECT * FROM table' );
/* testWpdbPrepareStaticWithComments */ $wpdb /* comment */ :: /* comment */ prepare( 'SELECT * FROM table WHERE id = %d', $id );
/* testWpdbEscLikeUnqualifiedClass */ wpdb::esc_like( $find );
/* testWpdbEscLikeFullyQualifiedGlobal */ \wpdb::esc_like( $find );
