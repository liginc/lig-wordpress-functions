<?php
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
});

/**
 * Register post_type and taxonomy
 */

//add_action('init', 'add_post_type_and_taxonomy');

function add_post_type_and_taxonomy()
{
    $default_post_type_args = array(
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => true,
        'show_in_rest' => true,
        'supports' => array('title', 'editor', 'author', 'thumbnail'),
    );

    $default_term_args = array(
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
    );

    $args = array_merge($default_post_type_args, array(
        'label' => 'POST TYPE NAME',
        'rewrite' => array('slug' => 'post_type_name')
    ));
    register_post_type("post_type_name", $args);


    $args = array_merge($default_term_args, array(
        'label' => 'TAXONOMY NAME',
        'rewrite' => array('slug' => 'taxonomy slug')
    ));
    register_taxonomy('taxonomy_name', array('post_type_name'), $args);
}


/**
 * Helper functions
 */

/**
 * Get first term object
 */
function get_first_term($post_id, $tax = 'category')
{
    $terms = get_the_terms($post_id, $tax);

    if (!empty($terms[0])) {
        return $terms[0];
    } else {
        return [];
    }
}
