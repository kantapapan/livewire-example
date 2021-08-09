# Rendering Components

## Inline Components

Livewire コンポーネントをページ上にレンダリングする最も基本的な方法は、<livewire: タグの構文を使用することです。

```html
<div>
    <livewire:show-posts />
</div>
```

また、@livewire bladeディレクティブを使用することもできます。

```html
@livewire('show-posts')
```

独自の名前空間を持つサブフォルダの中にコンポーネントがある場合は、名前空間の前にドット（.）を付ける必要があります。

例えば、`app/Http/Livewire/Nav`フォルダの中に`ShowPosts`コンポーネントがある場合、このように表記します。

```html
<livewire:nav.show-posts />
```

### Parameters

#### パラメータの受け渡し

<livewire:タグに追加のパラメータを渡すことで、コンポーネントにデータを渡すことができます。

例えば、show-postコンポーネントがあるとします。ここでは、$postモデルを渡す方法を紹介します。

```html
<livewire:show-post :post="$post">
```

また、Bladeディレクティブを使用してパラメータを渡す方法は以下の通りです。

```html
@livewire('show-post', ['post' => $post])
```

#### 受信パラメータ

Livewire は、一致するパブリック・プロパティにパラメータを自動的に割り当てます。

例えば、`<livewire:show-post :post="$post">` の場合、show-post コンポーネントに $post というパブリック・プロパティがあれば、自動的にそれが割り当てられます。

```php
class ShowPost extends Component
{
    public $post;

    ...
}
```

何らかの理由でこの自動動作がうまくいかない場合は、mount()メソッドを使ってパラメータをインターセプトすることができます。

```php
class ShowPost extends Component
{
    public $title;
    public $content;

    public function mount($post)
    {
        $this->title = $post->title;
        $this->content = $post->content;
    }

    ...
}
```



Livewire のコンポーネントでは、クラスのコンストラクタ __construct() の代わりに mount() を使用します。

コントローラのように、渡されたパラメータの前にタイプヒンティングされたパラメータを追加することで、依存性を注入することができます。

```php
use \Illuminate\Session\SessionManager;

class ShowPost extends Component
{
    public $title;
    public $content;

    public function mount(SessionManager $session, $post)
    {
        $session->put("post.{$post->id}.last_viewed", now());

        $this->title = $post->title;
        $this->content = $post->content;
    }

    ...
}
```

## Full-Page Components

ページのメインコンテンツがLivewireのコンポーネントである場合、そのコンポーネントをコントローラーのようにLaravelのルートに直接渡すことができます。

```php
Route::get('/post', ShowPosts::class);
```

デフォルトでは、LivewireはShowPostsコンポーネントを、次の場所にあるブレード・レイアウト・コンポーネントの{{ $slot }}にレンダリングします。

```html
<head>
    @livewireStyles
</head>
<body>
    {{ $slot }}

    @livewireScripts
</body>
```

Laravelのコンポーネントの詳細については、Laravelのドキュメントをご覧ください。, [visit Laravel's documentation](https://laravel.com/docs/blade#components).

### Configuring The Layout Component

layouts.app以外のデフォルト・レイアウトを指定したい場合は、livewire.layout設定オプションを上書きします。

```php
'layout' => 'app.other_default_layout'
```

さらにコントロールが必要な場合は、render()から返されたビューのインスタンスに->layout()メソッドを使用することができます。

```php
class ShowPosts extends Component
{
    ...
    public function render()
    {
        return view('livewire.show-posts')
            ->layout('layouts.base');
    }
}
```

コンポーネントのデフォルト以外のスロットを使用している場合は、->slot()を連鎖させることもできます。

```php
public function render()
{
    return view('livewire.show-posts')
        ->layout('layouts.base')
        ->slot('main');
}
```

また、Livewire では従来の Blade のレイアウトファイルを @extends で使用することも可能です。

次のようなレイアウトファイルがあるとします。

```html
<head>
    @livewireStyles
</head>
<body>
    @yield('content')

    @livewireScripts
</body>
```

Livewire がそれを参照するように設定するには、 ->layout() の代わりに ->extends() を使用します。

```php
public function render()
{
    return view('livewire.show-posts')
        ->extends('layouts.app');
}
```

コンポーネントが使用する@sectionを設定する必要がある場合は、->section()メソッドでそれも設定することができます。

```php
public function render()
{
    return view('livewire.show-posts')
        ->extends('layouts.app')
        ->section('body');
}
```

コンポーネントからレイアウトにデータを渡す必要がある場合は、レイアウトメソッドと一緒にデータを渡すことができます。

```php
public function render()
{
    return view('livewire.show-posts')
        ->layout('layouts.base', ['title' => 'Show Posts'])
}
```

レイアウト名を渡す必要がない場合や、レイアウトデータを個別に渡したい場合には、layoutDataメソッドを使用できます。

```php
public function render()
{
    return view('livewire.show-posts')
        ->layoutData(['title' => 'Show Posts'])
}
```

### Route Parameters

コントローラのメソッド内でルートのパラメータにアクセスする必要がある場合がよくあります。もうコントローラは使わないので、Livewire は mount メソッドでこの動作を模倣しようとしています。例えば、以下のようになります。

```php
Route::get('/post/{id}', ShowPost::class);
class ShowPost extends Component
{
    public $post;

    public function mount($id)
    {
        $this->post = Post::find($id);
    }

    ...
}
```

ご覧のように、Livewire コンポーネントの mount メソッドは、パラメータに関してはコントローラのメソッドと同じように動作しています。post/123 にアクセスすると、mount メソッドに渡された $id 変数には 123 という値が入ります。

### Route Model Binding

当然のことながら、Livewire コンポーネントは、ルートモデルバインディングを含む、コントローラでよく使われるすべての機能を実装しています。例えば、以下のようになります。

```php
Route::get('/post/{post}', ShowPost::class);
class ShowPost extends Component
{
    public $post;

    public function mount(Post $post)
    {
        $this->post = $post;
    }
}
```

PHP 7.4 を使用している場合は、クラスのプロパティをタイプヒントとして入力することもでき、Livewire は自動的にそのプロパティにルート・モデル・バインドします。次のコンポーネントの $post プロパティは自動的に注入され、mount() メソッドは必要ありません。

```php
class ShowPost extends Component
{
    public Post $post;
}
```

## The Render Method

Livewire コンポーネントの render メソッドは、最初のページロード時と、その後のコンポーネントのアップデートごとに呼び出されます。



シンプルなコンポーネントでは、自分でレンダリングメソッドを定義する必要はありません。ベースとなるLivewireコンポーネントクラスには、ダイナミックなレンダリングメソッドが含まれています。



### Returning Blade Views

render()メソッドはBladeビューを返すことが期待されているため、コントローラのメソッドを書くのと同じように考えることができます。以下はその例です。

ブレードビューのルート要素が1つだけであることを確認してください。

```php
class ShowPosts extends Component
{
    public function render()
    {
        return view('livewire.show-posts', [
            'posts' => Post::all(),
        ]);
    }
}
<div>
    @foreach ($posts as $post)
        @include('includes.post', $post)
    @endforeach
</div>
```

### Returning Template Strings

Bladeビューに加えて、オプションでBladeテンプレート文字列をrender()から返すことができます。

```php
class DeletePost extends Component
{
    public Post $post;

    public function delete()
    {
        $this->post->delete();
    }

    public function render()
    {
        return <<<'blade'
            <div>
                <button wire:click="delete">Delete Post</button>
            </div>
        blade;
    }
}
```



上記のようなインラインコンポーネントの場合、作成時に --inline フラグを使用します： artisan make:livewire delete-post --inline

