<?php



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
function get_modified_class(string $class_name, $modifier)
{
    $rtn = '';
    if (!empty($modifier)) {
        if (!is_array($modifier)) {
            $rtn = ' ' . $class_name . '--' . $modifier;
        } else {
            foreach ($modifier as $m) $rtn .= ' ' . $class_name . '--' . $m;
        }
    }
    return $class_name . $rtn;
}

/**
 * Attach addtional class
 */
function get_additional_class($additional)
{
    $rtn = '';
    if (!empty($additional)) {
        if (!is_array($additional)) {
            $rtn = ' ' . $additional;
        } else {
            foreach ($additional as $a) $rtn .= ' ' . $a;
        }
    }
    return $rtn;
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
    return (wp_get_environment_type() === 'local');
}

/**
 * Return develop environment or not
 */
function is_development()
{
    return (wp_get_environment_type() === 'development');
}


/**
 * Return staging environment or not
 */
function is_staging()
{
    return (wp_get_environment_type() === 'staging');
}


/**
 * Return production environment or not
 */
function is_production()
{
    return (wp_get_environment_type() === 'production');
}
