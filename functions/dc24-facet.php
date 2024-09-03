<?php

add_filter( 'facetwp_preload_url_vars', function( $url_vars ) {
    if ( 'winbiz' == FWP()->helper->get_uri() ) { 
      if ( empty( $url_vars['partner_type'] ) ) { 
        $url_vars['partner_type'] = [ 'succursale' ]; 
      }
      // add more facet selections
    //   if ( empty( $url_vars['partner_type'] ) ) { 
    //     $url_vars['partner_type'] = [ 'succursale' ];
    //   }
    }
    return $url_vars;
  } );




add_filter('facetwp_map_marker_args', function ($args, $post_id) {
    // Commencez la mise en tampon de sortie pour capturer le contenu personnalisé
    ob_start();

    // Récupération des champs nécessaires
    $title = get_the_title($post_id);
    $address = get_field('address', $post_id);
    $url = get_field('url', $post_id);
    $url_nice =  preg_replace('/^(https?:\/\/)/', '', $url);
    $email = get_field('email', $post_id);
    $phone = get_field('Phone', $post_id);
    $categories = get_the_term_list($post_id, 'partner-type', "", ", ", "");

    // Création du contenu personnalisé pour l'infobulle du marqueur
?>
    <div class="pt-0 p-4 ">
        <p class="text-primary font-bold uppercase pb-3 text-sm"><?php echo $categories ?></p>
        <h3 class="text-xl mt-0 font-bold text-gray-800"><?php echo esc_html($title); ?></h3>
        <div class="">
            <p class="text-sm">
                <?php echo esc_html($address["street"]); ?> <?php echo esc_html($address["street_num"]); ?><br>
                <?php echo esc_html($address["npa"]); ?> <?php echo esc_html($address["city"]); ?> 
            </p>
            <div class="flex flex-col gap-2 pt-2 font-medium">
                <?php if ($email): ?>
                    <a href="mailto:<?php echo esc_attr($email); ?>" class="flex gap-2 items-center p-2 py-1 bg-gray-200 rounded-full hover:bg-primary hover:text-white transition-all"><i class="fa-solid text-white fa-envelope"></i> <?php echo esc_html($email); ?></a< /p>
                    <?php endif; ?>
                    <?php if ($url): ?>
                        <a href="<?php echo esc_url($url); ?>" target="_blank" class="flex gap-2 items-center p-2 py-1 bg-gray-200 rounded-full hover:bg-primary hover:text-white transition-all"><i class="fa-solid text-white fa-link "></i> <?php echo esc_html($url_nice); ?></a>
                    <?php endif; ?>
                    <?php if ($phone): ?>
                        <a href="tel:<?php echo esc_url($phone); ?>" class="flex gap-2 items-center p-2 py-1 bg-gray-200 rounded-full hover:bg-primary hover:text-white transition-all"><i class="fa-solid text-white fa-phone"></i> <?php echo esc_html($phone); ?></a>
                    <?php endif; ?>
            </div>
        </div>
    </div>
<?php

    // Capture du contenu généré et le définir dans l'argument 'content'
    $args['content'] = ob_get_clean();

    return $args;
}, 10, 2);



// custom cluster class
add_filter('facetwp_map_init_args', function ($args) {
    if (isset($args['config']['cluster'])) {
        $args['config']['cluster']['cssClass'] = 'dc-cluster-class';
    }
    return $args;
});

// custom marker icon
add_filter('facetwp_map_marker_args', function ($args, $post_id) {
    $args['icon'] = [
        'url' => get_stylesheet_directory_uri() . '/assets/pin.svg', // set your theme image path here
        'scaledSize' => [
            'width' => 24,
            'height' => 24
        ]
    ];
    return $args;
}, 10, 2);

add_filter( 'get_terms_args', function( $args, $taxonomies ) {
  if ( isset( $args['term_order'] ) && 'order' !== $args['meta_key'] ) { // The second condition is needed to preserve WooCommerce ordering for product categories, by a termmeta field named "order".
    $args['orderby'] = 'term_order';
  }
  return $args;
}, 10, 2 );
 
add_filter( 'get_terms_orderby', function( $orderby, $query_vars, $taxonomies ) {
  return 'term_order' === $query_vars['orderby'] ? 'term_order' : $orderby;
}, 10, 3 );

add_filter('facetwp_facet_display_value', function ($label, $params) {
    if ('partner_type' == $params['facet']['name']) {
        // Get the terms ordered by 'term_order'
        $terms = get_terms(array(
            'taxonomy' => 'partner-type',
            'include' => array($params['row']['term_id']),
            'orderby' => 'term_order',
            'order' => 'ASC',
            'hide_empty' => false,
        ));

        if (!empty($terms) && !is_wp_error($terms)) {
            $term = $terms[0]; // Since we're only getting one term by ID

            // Concatenate the term name and description with div tags around
            $label = '<h5 class="term-name">' . esc_html($term->name) . ' </h5>';
            if (! empty($term->description)) {
                $label .= '<div class="term-description font-light text-sm">' . esc_html($term->description) . '</div>';
            }
        }
    }
    return $label;
}, 10, 2);






add_filter('facetwp_i18n', function ($string) {
    if (isset(FWP()->facet->http_params['lang'])) {
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

        if (isset($translations[$lang][$string])) {
            return $translations[$lang][$string];
        }
    }

    return $string;
});
