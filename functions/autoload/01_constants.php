<?php

add_action('init', 'set_up_constants');

function set_up_constants()
{
    /**
     * General Settings
     */
    define('HOME_URL', home_url() . '/');
    define('SITE_NAME', get_bloginfo('name'));

    /**
     * ASSETS
     */
    define('URL_ASSETS', '/assets/');
    define('URL_IMAGES', URL_ASSETS . 'images/');
    define('PATH_IMAGES', STYLESHEETPATH . '/assets/images/');
    define('URL_JS', URL_ASSETS . 'js/');
    define('URL_CSS', URL_ASSETS . 'css/');
    define('URL_SVG', URL_ASSETS . 'svg/');

    define('URL_FAVICON', resolve_uri('/assets/images/favicon.ico'));
    define('URL_TOUCH_ICON', resolve_uri('/assets/images/apple-touch-icon-precomposed.png'));
    define('URL_APP_JS', resolve_uri('/assets/js/app.js'));
    define('URL_APP_CSS', resolve_uri('/assets/css/app.css'));
    define('URL_NO_IMAGE', resolve_uri('assets/images/noimage.png'));

    /**
     * CONTENTS
     */
    /*
    define('URL_ABOUT', HOME_URL . 'about/');
    define('URL_SERVICE', HOME_URL . 'service/');
    define('URL_CONTACT', HOME_URL . 'contact/');
    define('URL_CONFIRM', CONTACT . 'confirm/');
    define('URL_COMPLETE', CONTACT . 'complete/');
    */

    /**
     * SNS
     */
    /*
    define('URL_TWITTER', 'https://twitter.com/');
    define('URL_FACEBOOK', 'https://facebook.com/');
    define('URL_INSTAGRAM', 'https://instagram.com/');
    */

    /**
     * EXTERNAL LINKS
     */
    /*
    define('', '');
    */


    /**
     * IMAGE SIZES
     */
    define('RESIZE_IMAGE_SIZES', [
        414,
        828,
        1280,
        1600,
        2048
    ]);

    /*
     * キーはメディアクエリ、値は入れたい画像
     * 'default'=>'default'を入れると、imgタグは元画像のurlがセットされます
     * 'default'=>414にすると、imgタグに414のsrcsetが挿入されます
     */
    define('IMAGE_SIZES_FULL',[
        414 => 414,
        768 => 768,
//        1024 => 1024,
        1280 => 1280,
//        1440 => 1440,
        1600 => 1600,
        'default' => 'original'
    ]);
}