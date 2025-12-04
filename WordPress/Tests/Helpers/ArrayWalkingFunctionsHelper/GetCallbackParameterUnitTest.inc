<?php

// Test cases for get_callback_parameter().

/* testArrayMapWithCallback */
array_map( 'sanitize_text_field', $array );

/* testArrayMapWithCallbackFullyQualified */
\array_map( 'esc_html', $array );

/* testMapDeepWithCallback */
map_deep( $array, 'sanitize_text_field' );

/* testMapDeepWithCallbackFullyQualified */
\map_deep( $array, 'esc_attr' );

/* testArrayMapNoCallback */
array_map( $array );

/* testNotArrayWalkingFunction */
array_filter( 'callback', $array );

/* testArrayMapWithClosureCallback */
array_map( function( $item ) { return sanitize_text_field( $item ); }, $array );

/* testArrayMapWithArrowFunctionCallback */
array_map( fn( $item ) => esc_html( $item ), $array );