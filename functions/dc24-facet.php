<?php 

add_filter( 'facetwp_facet_display_value', function( $label, $params ) {
  if ( 'partner_type' == $params['facet']['name'] ) {
      // Get the term object by term ID
      $term = get_term_by( 'id', $params['row']['term_id'], "partner-type" );
      
      if ( ! empty( $term ) ) {
          // Concatenate the term name and description with div tags around
          $label = '<h5 class="term-name">' . esc_html( $term->name ) . '</h5>';
          if ( ! empty( $term->description ) ) {
              $label .= '<div class="term-description font-light text-sm">' . esc_html( $term->description ) . '</div>';
          }
      }
  }
  return $label;
}, 10, 2 );