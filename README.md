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
svgスプライトの指定された箇所をuseで返却する

第一引数にsvg-sprite.svgのid名を指定する


```php
// svg-sprite.svg#logoを出力
<?= get_svg_sprite('logo') ?>
```