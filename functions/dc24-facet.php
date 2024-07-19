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


add_filter( 'facetwp_i18n', function( $string ) {
    if ( isset( FWP()->facet->http_params['lang'] ) ) {
        $lang = FWP()->facet->http_params['lang'];

        $translations = [];
        
        // Page numbers
        $translations['fr']['« Prev'] = 'Précédent';
        $translations['fr']['Next »'] = 'Suivant';
        $translations['fr']['…'] = '-';
        
        $translations['it']['« Prev'] = 'Precedente';
        $translations['it']['Next »'] = 'Successivo';
        $translations['it']['…'] = '-';
        
        $translations['de']['« Prev'] = 'Vorherige';
        $translations['de']['Next »'] = 'Nächste';
        $translations['de']['…'] = '-';
        
        // Result counts
        $translations['fr']['[lower] - [upper] of [total] results'] = '[lower] - [upper] de [total] résultats';
        $translations['fr']['1 result'] = '1 résultat';
        $translations['fr']['No results'] = 'Aucun résultat';
        
        $translations['it']['[lower] - [upper] of [total] results'] = '[lower] - [upper] di [total] risultati';
        $translations['it']['1 result'] = '1 risultato';
        $translations['it']['No results'] = 'Nessun risultato';
        
        $translations['de']['[lower] - [upper] of [total] results'] = '[lower] - [upper] von [total] Ergebnissen';
        $translations['de']['1 result'] = '1 Ergebnis';
        $translations['de']['No results'] = 'Keine Ergebnisse';
        
        // Load more
        $translations['fr']['Load more'] = 'Charger plus';
        $translations['fr']['Loading...'] = 'Charger...';
        
        $translations['it']['Load more'] = 'Carica di più';
        $translations['it']['Loading...'] = 'Caricamento...';
        
        $translations['de']['Load more'] = 'Mehr laden';
        $translations['de']['Loading...'] = 'Lädt...';
        
        // Per page
        $translations['fr']['Per page'] = 'Par page';
        $translations['fr']['Show all'] = 'Afficher tout';
        
        $translations['it']['Per page'] = 'Per pagina';
        $translations['it']['Show all'] = 'Mostra tutto';
        
        $translations['de']['Per page'] = 'Pro Seite';
        $translations['de']['Show all'] = 'Alle anzeigen';
        
        if ( isset( $translations[ $lang ][ $string ] ) ) {
            return $translations[ $lang ][ $string ];
        }
    }
   
    return $string;
  });