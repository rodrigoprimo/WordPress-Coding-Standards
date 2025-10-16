<?php

esc_html( 'text' );
esc_html( $var );

esc_html( 'text', 'domain' ); // Warning.
esc_html( $foo, $bar ); // Warning.
esc_attr(
	'text', // Some comment.
	MY_DOMAIN // More comment.
); // Warning.

/*
 * Safeguard correct handling of all types of namespaced function calls.
 */
\esc_attr( 'text', 'domain' );
MyNamespace\esc_attr( 'text', 'domain' );
\MyNamespace\esc_attr( 'text', 'domain' );
namespace\esc_attr( 'text', 'domain' ); // The sniff should start flagging this once it can resolve relative namespaces.
