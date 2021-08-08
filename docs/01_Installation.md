# Installation

## Requirements

1. PHP 7.2.5 or higher
2. Laravel 7.0 or higher

Visit the [composer.json file on Github](https://github.com/livewire/livewire/blob/master/composer.json) for the complete list of package requirements.

## Install The Package

```bash
composer require livewire/livewire
```

## Include The Assets

以下のBladeディレクティブを、テンプレートのheadタグ内とend bodyタグの前に追加します。

```html
<html>
<head>
    ...
    @livewireStyles
</head>
<body>
    ...
    @livewireScripts
</body>
</html>
```

代わりにタグ構文を使うこともできます。

```html
<livewire:styles />
...
<livewire:scripts />
```

以上です。これだけで Livewire を使い始めることができます。このページの他のすべてはオプションです。



## Publishing The Config File

Livewire はすぐに使える「ゼロコンフィグレーション」を目指していますが、ユーザーによってはより多くの設定オプションを必要とします。 以下のartisanコマンドでLivewireの設定ファイルを公開することができます。

```bash
php artisan livewire:publish --config
```

## Publishing Frontend Assets

JavaScriptのアセットをLaravelではなく、Webサーバーで提供したい場合は、livewire:publishコマンドを使用します。

```bash
php artisan livewire:publish --assets
```

アセットを最新に保ち、将来のアップデートでの問題を回避するために、composer.jsonファイルのpost-autoload-dumpスクリプトにこのコマンドを追加することを強くお勧めします。

```json
{
    "scripts": {
        "post-autoload-dump": [
            "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
            "@php artisan package:discover --ansi",
            "@php artisan vendor:publish --force --tag=livewire:assets --ansi"
        ]
    }
}
```

## Configuring The Asset Base URL

デフォルトでは、Livewire はその JavaScript 部分（livewire.js）を、アプリ内の以下のルートから提供します。/livewire/livewire.js.

生成される実際のスクリプトタグのデフォルトは
`<script src="/livewire/livewire.js"></script>`

このデフォルトの動作が崩れる原因として、2つのシナリオがあります。

1. Livewire のアセットをパブリッシュし、"assets" のようなサブフォルダから配信しています。
2. あなたのアプリは、あなたのドメインの非ルートパスにホストされています。たとえば、https://your-laravel-app.com/application のような場合です。この場合、実際のアセットは /application/livewire/livewire.js から提供されますが、生成された script タグは /livewire/livewire.js を取得しようとします。

これらの問題を解決するには、`config/livewire.php` の `asset_base_url` を設定して、src="" 属性の前に付加されるものをカスタマイズすることができます。

例えば、Livewireの設定ファイルを公開した後、上記2つの問題を解決するための設定は以下の通りです。

1. `'asset_base_url' => '/assets'`
2. `'asset_base_url' => '/application'`
