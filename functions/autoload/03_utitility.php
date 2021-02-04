<?php
/**
 * Enable Title
 */
add_theme_support( 'title-tag' );

/**
 * Enable post thumbnail
 */
add_theme_support('post-thumbnails');


/**
 * encode
 */
function xss($str = null)
{
    return htmlentities($str, ENT_QUOTES, 'UTF-8');
}

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

/**
 * Include SVG Sprite
 */
function get_svg_sprite($name)
{
    return '<svg class="svg-sprited svg-' . $name . '" role="img"><use xlink:href="' . get_template_directory_uri() . '/assets/svg/sprite.svg#sprite-' . $name . '" xmlns:xlink="http://www.w3.org/1999/xlink"></use></svg>';
}

/**
 * return target="_blank"
 * $flg Boolean
 */
function is_blank(?bool $bool = false)
{
    return ($bool) ? ' target="_blank" rel="noopener noreferrer"' : '';
}

/**
 * return ' is-current'
 * $flg Boolean
 */
function is_current(?bool $bool = false)
{
    return ($bool) ? ' is-current' : '';
}

/**
 * Attach modifier class
 */
function get_modified_class(string $class_name,string $modifier)
{
    return (!empty($modifier)) ? $class_name . ' ' . $class_name . '--' . $modifier : $class_name;
}

/**
 * Modify body_class
 */
add_filter('body_class', function ($classes) {
    global $post;
    switch (true) {
        case is_front_page():
            unset($classes[array_search('blog', $classes)]);
            $classes[] = 'front-page';
            $classes[] = 'index';
            break;
        case is_page():
            unset($classes[array_search('page-id-' . $post->ID, $classes)]);
            $classes[] = 'page-' . $GLOBALS['post']->post_name;
            $parent = $post;
            while ($parent->post_parent) {
                unset($classes[array_search('parent-pageid-' . $parent->post_parent, $classes)]);
                $descendant = array_search('child-of-' . $parent->post_name, $classes);
                $parent = get_post($parent->post_parent);
                $classes[] = 'child-of-' . $parent->post_name;
                if ($descendant) $classes[] = 'descendant-of-' . $parent->post_name;
            }
            break;
    }
    return $classes;
});

/**
 * Return local environment or not
 */
function is_local()
{
    return (strpos($_SERVER['HTTP_HOST'], 'localhost') === 0);
}