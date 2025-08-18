<?php

/*
 * The below should NOT be recognized as namespaced tokens by ContextHelper::is_token_namespaced().
 */

/* testUnqualifiedFunction */ my_function();
/* testFullyQualifiedFunction */ \my_function();
/* testUnqualifiedClass */ MyClass::my_static_method();
/* testFullyQualifiedClass */ $var = new \MyClass();
/* testUnqualifiedConstant */ $const = MY_CONSTANT;
/* testFullyQualifiedConstant */ $const = \MY_CONSTANT;

/*
 * The below should be recognized as namespaced tokens by ContextHelper::is_token_namespaced().
 */

/* testPartiallyQualifiedFunction */ MyNamespace\my_function();
/* testFullyQualifiedNamespacedFunction */ \MyNamespace\my_function();
/* testNamespaceRelativeFunction */ namespace\my_function(); // False positive if the file is not namespaced.
/* testPartiallyQualifiedClass */ $var = new MyNamespace\MyClass();
/* testPartiallyQualifiedConstant */ $const = MyNamespace\MY_CONSTANT;
