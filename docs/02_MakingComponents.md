# Making Components

以下のartisanコマンドを実行して、新しいLivewireコンポーネントを作成します。

```bash
php artisan make:livewire ShowPosts
```

また、Livewire は新しいコンポーネントの「ケバブ」表記をサポートしています。

```bash
php artisan make:livewire show-posts
```

プロジェクトに2つの新しいファイルが作成されました。

- `app/Http/Livewire/ShowPosts.php`
- `resources/views/livewire/show-posts.blade.php`

サブフォルダー内にコンポーネントを作成したい場合は、以下の異なる構文を使用できます。

```bash
php artisan make:livewire Post\\Show
php artisan make:livewire Post/Show
php artisan make:livewire post.show
```

これで、作成した2つのファイルがサブフォルダに入ります。

- `app/Http/Livewire/Post/Show.php`
- `resources/views/livewire/post/show.blade.php`

## Inline Components

インラインコンポーネント（.blade.phpファイルのないコンポーネント）を作成したい場合は、コマンドに--inlineフラグを追加することができます。

```bash
php artisan make:livewire ShowPosts --inline
```

これで、ファイルは1つだけ作成されます。

- `app/Http/Livewire/ShowPosts.php`

こんな感じになります。

```php
class ShowPosts extends Component
{
    public function render()
    {
        return <<<'blade'
            <div></div>
        blade;
    }
}
```
