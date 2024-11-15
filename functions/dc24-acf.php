<?php
/**
 * Here comes the ACF related php code
 */

 add_action( 'init', 'dc24_register_meta', 15 );

 function dc24_register_meta() {
     if (!function_exists('acf_get_field_groups')) {
         return;
     }
 
     // Get all ACF field groups
     $field_groups = acf_get_field_groups();
     
     // Get all public post types
     $post_types = get_post_types(['public' => true]);
     
     if (!empty($field_groups)) {
         foreach ($field_groups as $field_group) {
             // Debug check
             if (!isset($field_group['key'])) {
                 continue;
             }
 
             $fields = acf_get_fields($field_group['key']);
             
             if (!empty($fields) && is_array($fields)) {
                 foreach ($fields as $field) {
                     // Skip if no name
                     if (!isset($field['name']) || empty($field['name'])) {
                         continue;
                     }
 
                     // Skip if no type
                     if (!isset($field['type']) || empty($field['type'])) {
                         continue;
                     }

                    // Skip gallery fields
                    if ($field['type'] === 'gallery') {
                        continue;
                    }
 
                     $meta_args = array(
                         'object_subtype'    => false,
                         'show_in_rest'      => true,
                         'single'            => true,
                         'type'              => get_acf_field_type($field['type']),
                         'auth_callback'     => '__return_true',
                         'sanitize_callback' => 'sanitize_text_field',
                     );
 
                     // Register for post type 'post' first
                     register_post_meta('post', $field['name'], $meta_args);
 
                     // Then register for other post types if needed
                     foreach ($post_types as $post_type) {
                         if ($post_type !== 'post') {
                             register_post_meta($post_type, $field['name'], $meta_args);
                         }
                     }
                 }
             }
         }
     }
 }
 
 // Simplified field type mapping
 function get_acf_field_type($acf_type) {
     $type_map = array(
         'text'     => 'string',
         'textarea' => 'string',
         'number'   => 'number',
         'range'    => 'number',
         'email'    => 'string',
         'url'      => 'string',
         'password' => 'string',
         'image'    => 'integer',
         'file'     => 'integer',
         'wysiwyg'  => 'string',
         'select'   => 'string',
         'checkbox' => 'boolean',
         'radio'    => 'string',
         'true_false' => 'boolean',
     );
 
     return isset($type_map[$acf_type]) ? $type_map[$acf_type] : 'string';
 }


