# LIG WordPress Functions

**Contributors:** LIG inc  
**Version:** 0.2.0
**License:** GPLv2 or later  
**License URI:** http://www.gnu.org/licenses/gpl-2.0.html  
**Tags:** scratch

## Description

WordPress helper functions.

## Copyright

LIG WordPress Template, Copyright 2019 LIG inc
LIG WordPress Template is distributed under the terms of the GNU GPL.

LIG WordPress Template bundles the following third-party resources:

\_s, Copyright 2015-2018 Automattic, Inc.
**License:** GPLv2 or later
Source: https://github.com/Automattic/_s/

normalize.css, Copyright 2012-2016 Nicolas Gallagher and Jonathan Neal
**License:** MIT
Source: https://necolas.github.io/normalize.css/

---

# WordPress Functions

## Structure

```
├── autoload
│   ├── 00_laravel-mix-boilerplate.php // mix関数
│   ├── 01_constants.php // 定数を定義
│   ├── 02_import_functions.php // テンプレート読み込みを定義
│   ├── 03_utitility.php //
│   ├── 04_security.php //
│   ├── 05_posttype_taxonomy.php //
│   ├── 07_wp_head.php
│   ├── 09_mutibyte_patch.php
│   ├── 10_404.php
│   ├── 11_media.php
│   ├── 11_pagination.php
│   ├── 12_json-ld.php
│   ├── 20_disable_comment.php
│   ├── 25_admin_bar_menus.php
│   ├── 30_admin_utility.php
│   ├── 35_gutenberg.php
│   ├── 50_login.php
│   └── 99_acf_auto_export_import.php
├── class
│   └── LIG_YOAST_SETTINGS.php
├── config
│   └── LIG_YOAST_CONFIG.php
├── extra
│   ├── 04_utility_extra.php
│   ├── 06_query_hooks.php
│   ├── 31_disable_default_post_type.php
│   ├── 55_acf.php
│   ├── 55_yoast.php
│   ├── 60_admin_utility_extra.php
│   ├── 9999_dummy_post.php
│   ├── 99_category_pages.php
│   ├── 99_excerpt.php
│   ├── 99_html_compression.php
│   ├── 99_lightsail_cdn.php
│   ├── 99_mw_form.php
│   ├── 99_rewrite_hooks.php
│   └── 99_yoast_settings.php
├── lib
│   └── admin
│       ├── css
│       │   ├── gutenberg.css
│       │   └── gutenberg_hack.css
│       └── js
│           ├── gutenberg_filters.js
│           ├── lightsail_cdn.js
│           └── yoast_cache_clear.js
└── vender.php
```

## 00_laravel-mix-boilerplate.php

### mix

laravel-mix-boilerplate でのビルドが出力する manifest.json を元にキャッシュバスティングされたパスを返す

#### function mix($path, $manifestDirectory = '')

$path はプロトコルから指定する

#### resolve_uri($path, $manifestDirectory = '')

mix のショートハンド

$path にはテーマディレクトリからのパスを渡す

使用例

```php
<?= mix('/assets/images/logo.png') ?>
```

## 01_constants.php

各種定数を定義

init にフックしているため、それ以前の呼び出しではエラーになる

## 02_import_functions.php

テンプレート読み込みの関数・そのヘルパー関数を定義

#### import_template(string $tpl, array $vars = [])

$tpl はテーマからの相対パスを指定する

拡張子は自動で php がつくため不要

`$vars`にはパーツ内に渡したい変数を配列で指定する

キーが変数名、値が値となる

使用例

```php
<?php
import_template('modules/two-column',[
    'modifier' => 'wide',
    'post' => $post
]);
?>
```

#### import_part(string $tpl, array $vars = [])

`import_template()`のショートハンド

$tpl はテーマ直下の parts ディレクトリからの相対パスを指定する

拡張子は自動で php がつくため不要

使用例

```php
<?php import_part('article') ?>
```

#### import_vars_whitelist(array $vars, array $whitelist = [])

`$vars`のキーを`$whitelist`でフィルタリングする

`$whitelist`にはデフォルト値を指定する

主に、読み込まれたパーツ側で使用する

デフォルトで`modifier`と`additional`が付与される

使用例

```php
<?php
/**
 * parts/article.php
 *
 * 呼び出し元から$post, $taxonomyが渡される想定
 *
 * 定義されている変数をホワイトリストでフィルタリング
 * ホワイトリストに存在しない変数は$defaultに指定した値をセット
 * キー名を変数名として展開する
 */
$default = [
     'post' => $_GLOBALS['post'], // $postが空だった場合は$_GLOBALS['post']を参照する
     'taxonomy' => ''
];
extract(import_vars_whitelist(get_defined_vars(),$default));
?>
```

## 03_utitility.php

ユーティリティ関数群を定義

#### is_blank(?bool $bool = false)

`$bool`に`true`を渡すと`target="_blank" rel="noopener noreferrer"`が返却される

使用例

```php
<a href="https://example.com"<?= is_blank(true) ?>>google</a>
```

#### is_current(?bool $bool = false)

`$bool`に`true`を渡すと` is-current`が返却される

使用例

```php
<?php
// TOPページだったらis-currentを付与する
?>
<a href="<?= URL_HOME ?>" class="<?= is_current(is_front_page()) ?>">TOP</a>
```

#### get_modified_class(string $class_name, $modifier)

`$class_name`にベースとなるクラス名、`$modifier`にモディファイヤを文字列または配列で指定する

使用例

```php
<p class="<?= get_modified_class('text', 'blue') ?>">hoge</p>
<?php
// 出力結果
// <p class="text text--blue">hoge</p>
?>

<p class="<?= get_modified_class('text', ['red','bold']) ?>">fuga</p>
<?php
// 出力結果
// <p class="text text--red text--bold">fuga</p>
?>
```

#### get_additional_class($additional)

`$additional`に追加したいクラス名を文字列または配列で指定する

主にインポートされたパーツの中で使用する

使用例

```php
<p class="<?= get_additional_class('hoge') ?>">hoge</p>
<?php
// 出力結果
// <p class="hoge">hoge</p>
?>

<p class="<?= get_additional_class(['hoge','fuga']) ?>">fuga</p>
<?php
// 出力結果
// <p class="hoge fuga">fuga</p>
?>
```

#### add_filter('body_class', クロージャ)

`body_class`にフィルターをかける

### 環境判定

`wp-config.php`に定義した定数`WP_ENVIRONMENT_TYPE`を判定し、ブール値を返却する

#### is_local()

`WP_ENVIRONMENT_TYPE`が`local`の場合 true を返却

#### is_development()

`WP_ENVIRONMENT_TYPE`が`development`の場合 true を返却

#### is_staging()

`WP_ENVIRONMENT_TYPE`が`staging`の場合 true を返却

#### is_production()

`WP_ENVIRONMENT_TYPE`が`production`の場合 true を返却

## 04_security.php

セキュリティ周りのヘルパー関数軍、及びフックなど

#### xss($str = null)

`$str`を HTML エンティティして返却

#### header_register_callback(closure)

レスポンスヘッダーから PHP バージョンを削除

#### add_filter('wp_headers',closure)

レスポンスヘッダーから、X-Pingback を削除

#### remove_action('template_redirect', 'rest_output_link_header', 11, 0)

レスポンスヘッダーから REST API のエンドポイントを削除 Ï

#### remove_action('wp_head', 'wp_generator');

`wp_head`から WordPress のバージョン情報を削除

#### add_filter('xmlrpc_enabled', '\_\_return_false');

XML-RPC 機能を無効化

#### remove_action('template_redirect', 'wp_redirect_admin_locations', 1000)

ログイン URL の自動リダイレクトを禁止

#### remove_action('template_redirect'、'\_\_return_empty_array')

著者アーカイブページを無効化

#### define('AUTOMATIC_UPDATER_DISABLED', false);

開発版、マイナー、メジャー、すべての WordPress の自動更新を無効化

## 05_posttype_taxonomy.php

投稿タイプやタクソノミーの登録など

#### add_action('after_setup_theme',closure)

カスタム投稿タイプで title-tag とアイキャッチを有効化させる

#### add_post_type_and_taxonomy()

カスタム投稿タイプ・カスタムタクソノミーを追加する

## 07_wp_head.php
wp_headのフィルター用


## 11_media.php

### SVG

#### get_svg(string $name);

`/assets/svg/`内の svg ファイルをインラインで返却

```php
// /assets/svg/logo.svg をインラインで出力
<?= get_svg('logo') ?>
```

#### get_svg_img(string $name, array $opt = []);

`/assets/svg/`内の svg ファイルを img タグとして返却

$opt に`'base64'=>true`を渡すことにより`src="{base64化されたsvg}"`として出力することもできる

`width`と`height`を指定しないと、svg の viewBox から取得しようと試みる

$opt のデフォルト

```php
$default_opt = [
        'base64' => false,
        'alt' => '',
        'class' => '',
        'id' => '',
        'widht' => '',
        'height' => '',
    ];
```

```php
// /assets/svg/logo.svg をimgタグとして出力
// svgはbase64化することによりhttpリクエストを発生させない
<?= get_svg_img('logo',[
    'base64' => true,
    'alt' => 'ロゴ',
    'class' => 'logo-img',
    'id' => 'logo',
    'widht' => '200'
    'height' => '100',
]) ?>
```

#### get_svg_sprite(string $name);

svg スプライトの指定された箇所を use で返却する

第一引数に svg-sprite.svg の id 名を指定する

```php
// svg-sprite.svg#logoを出力
<?= get_svg_sprite('logo') ?>
```
