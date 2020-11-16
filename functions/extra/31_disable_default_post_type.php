<?php

add_action('init', 'remove_default_taxonomy', 99);
function remove_default_taxonomy()
{
    global $wp_rewrite;
    if (!empty($wp_rewrite->extra_permastructs["category"])) unset($wp_rewrite->extra_permastructs["category"]);
    if (!empty($wp_rewrite->extra_permastructs["post_tag"])) unset($wp_rewrite->extra_permastructs["post_tag"]);
    if (!empty(array_keys($wp_rewrite->queryreplace, 'category_name=')) && !empty($wp_rewrite->queryreplace[array_keys($wp_rewrite->queryreplace, 'category_name=')[0]])) unset($wp_rewrite->queryreplace[array_keys($wp_rewrite->queryreplace, 'category_name=')[0]]);
    if (!empty(array_keys($wp_rewrite->queryreplace, 'tag=')) && !empty($wp_rewrite->queryreplace[array_keys($wp_rewrite->queryreplace, 'tag=')[0]])) unset($wp_rewrite->queryreplace[array_keys($wp_rewrite->queryreplace, 'tag=')[0]]);
    if (!empty(array_keys($wp_rewrite->rewritecode, '%category%')) && !empty($wp_rewrite->rewritecode[array_keys($wp_rewrite->rewritecode, '%category%')[0]])) unset($wp_rewrite->rewritecode[array_keys($wp_rewrite->rewritecode, '%category%')[0]]);
    if (!empty(array_keys($wp_rewrite->rewritecode, '%post_tag%')) && !empty($wp_rewrite->rewritecode[array_keys($wp_rewrite->rewritecode, '%post_tag%')[0]])) unset($wp_rewrite->rewritecode[array_keys($wp_rewrite->rewritecode, '%post_tag%')[0]]);
    unregister_taxonomy_for_object_type('category', 'post');
    unregister_taxonomy_for_object_type('post_tag', 'post');
    return $wp_rewrite;
}

add_filter('rewrite_rules_array', 'delete_default_post_type_rewrite_rules');
function delete_default_post_type_rewrite_rules($rules)
{
    foreach ([
                 '([^/]+)/feed/(feed|rdf|rss|rss2|atom)/?$',
                 '([^/]+)/(feed|rdf|rss|rss2|atom)/?$',
                 '([^/]+)/page/?([0-9]{1,})/?$',
                 '([^/]+)/-([0-9]{1,})/?$',
                 '([^/]+)(?:/([0-9]+))?/?$'
             ] as $rule) if (array_key_exists($rule, $rules)) unset($rules[$rule]);
    return $rules;
}

add_action('template_redirect', 'redirect_default_post_type_404');
function redirect_default_post_type_404()
{
    global $wp_query;
    switch (true) {
        case is_post_type_archive('post'):
        case is_category():
        case is_tag():
        case is_singular('post'):
            $wp_query->set_404();
            status_header(404);
            break;
    }
}


add_action('admin_menu', 'hide_default_post_type_menus');
function hide_default_post_type_menus()
{
    remove_menu_page('edit.php');
}