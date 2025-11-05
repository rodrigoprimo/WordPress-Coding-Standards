<?php

/*
 * Test cases that should NOT be considered validated.
 */

// Variable not validated at all.
/* testNotValidatedEcho */ echo $_POST['foo'];

// Variable not in any validation context.
/* testNotValidatedAssignment */ $var = $_GET['bar'];

// Namespaced array_key_exists (not a global function).
/* testNamespacedArrayKeyExists */ if ( MyNamespace\array_key_exists( 'key', $_POST ) ) {
	echo $_POST['key'];
}

// Fully qualified namespaced array_key_exists.
/* testFullyQualifiedNamespacedArrayKeyExists */ if ( \MyNamespace\array_key_exists( 'key2', $_POST ) ) {
	echo $_POST['key2'];
}

// Relative namespace array_key_exists.
/* testNamespaceRelativeArrayKeyExists */ if ( namespace\array_key_exists( 'key3', $_POST ) ) {
	echo $_POST['key3'];
}

// Method call (not global function).
/* testMethodCall */ if ( $obj->array_key_exists( 'key4', $_POST ) ) {
	echo $_POST['key4'];
}

// Static method call.
/* testStaticMethodCall */ if ( MyClass::array_key_exists( 'key5', $_POST ) ) {
	echo $_POST['key5'];
}

// Namespaced key_exists.
/* testNamespacedKeyExists */ if ( MyNamespace\key_exists( 'key6', $_POST ) ) {
	echo $_POST['key6'];
}

/*
 * Test cases that SHOULD be considered validated.
 */

// Validated with isset().
/* testValidatedWithIsset */ if ( isset( $_POST['name'] ) ) {
	echo $_POST['name'];
}

// Validated with empty().
/* testValidatedWithEmpty */ if ( empty( $_GET['id'] ) ) {
	echo $_GET['id'];
}

// Validated with array_key_exists().
/* testValidatedWithArrayKeyExists */ if ( array_key_exists( 'key', $_POST ) ) {
	echo $_POST['key'];
}

// Validated with fully qualified array_key_exists().
/* testFullyQualifiedArrayKeyExists */ if ( \array_key_exists( 'key2', $_POST ) ) {
	echo $_POST['key2'];
}

// Validated with key_exists() alias.
/* testValidatedWithKeyExists */ if ( key_exists( 'key3', $_POST ) ) {
	echo $_POST['key3'];
}

// Validated with fully qualified key_exists().
/* testFullyQualifiedKeyExists */ if ( \key_exists( 'key4', $_POST ) ) {
	echo $_POST['key4'];
}

// Validated with null coalesce operator.
$_GET['value'] ?? 'default';
/* testValidatedWithNullCoalesce */ echo $_GET['value'];

// Multi-level array access validated.
/* testMultiLevelIsset */ if ( isset( $_POST['foo']['bar'] ) ) {
	echo $_POST['foo']['bar'];
}

// Multi-level with array_key_exists on outer key.
/* testMultiLevelArrayKeyExists */ if ( array_key_exists( 'foo', $_POST ) && isset( $_POST['foo']['bar'] ) ) {
	echo $_POST['foo']['bar'];
}
