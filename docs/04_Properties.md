# Properties

- Introduction
  - [Important Notes](https://laravel-livewire.com/docs/2.x/properties#important-notes)
- [Initializing Properties](https://laravel-livewire.com/docs/2.x/properties#initializing-properties)
- Data Binding
  - [Binding Nested Data](https://laravel-livewire.com/docs/2.x/properties#binding-nested-data)
  - [Debouncing Input](https://laravel-livewire.com/docs/2.x/properties#debouncing-input)
  - [Lazy Updating](https://laravel-livewire.com/docs/2.x/properties#lazy-updating)
  - [Deferred Updating](https://laravel-livewire.com/docs/2.x/properties#deferred-updating)
- [Binding Directly To Model Properties](https://laravel-livewire.com/docs/2.x/properties#binding-models)
- [Computed Properties](https://laravel-livewire.com/docs/2.x/properties#computed-properties)

 

**Be amazing at Livewire** with our in-depth screencasts.[Watch Now](https://laravel-livewire.com/screencasts)

## Introduction

Livewire コンポーネントは、コンポーネントクラスのパブリックプロパティとしてデータを保存、追跡します。

```php
class HelloWorld extends Component
{
    public $message = 'Hello World!';
    ...
```

Livewire のパブリックプロパティは、自動的にビューで利用可能になります。明示的にビューに渡す必要はありません（必要であれば渡すこともできますが）。

```php
class HelloWorld extends Component
{
    public $message = 'Hello World!';
}
<div>
    <h1>{{ $message }}</h1>
    <!-- Will output "Hello World!" -->
</div>
```

### Important Notes

ここでは、Livewireの旅に出る前に、パブリック・プロパティについて注意すべき3つの重要な点を紹介します。

1. プロパティ名は、Livewireで予約されているプロパティ名（例：ルールやメッセージ）と衝突してはいけません。 (e.g. `rules` or `messages`)
2. パブリックプロパティに保存されたデータは、フロントエンドのJavaScriptから見えるようになります。そのため、機密性の高いデータを格納すべきではありません。
3. プロパティは、JavaScriptに適したデータ型（string、int、array、boolean）、または以下のPHP型のいずれかのみです。Stringable, Collection, DateTime, Model, EloquentCollection.

protected と private のプロパティは、Livewire のアップデートの間は保存されません。一般的に、これらのプロパティを状態の保存に使用することは避けるべきです。



## Initializing Properties

コンポーネントのmountメソッドを使って、プロパティを初期化することができます。

```php
class HelloWorld extends Component
{
    public $message;

    public function mount()
    {
        $this->message = 'Hello World!';
    }
}
```

また、Livewireでは、たくさんのプロパティを設定しなければならず、視覚的なノイズを除去したい場合のために、$this->fill()メソッドを用意しています。

```php
public function mount()
{
    $this->fill(['message' => 'Hello World!']);
}
```

さらに、Livewire では $this->reset() を使って、パブリックプロパティの値をプログラムで初期状態に戻すことができます。これは、アクションを実行した後に入力フィールドをクリーニングするのに便利です。

```php
public $search = '';
public $isActive = true;

public function resetFilters()
{
    $this->reset('search');
    // Will only reset the search property.

    $this->reset(['search', 'isActive']);
    // Will reset both the search AND the isActive property.
}
```

## Data Binding

Vue や Angular などのフロントエンドフレームワークを使用したことがある人は、このコンセプトにすでに慣れていることでしょう。しかし、この概念を初めて知った場合は、LivewireはあるHTML要素の現在の値をコンポーネントの特定のプロパティに「バインド」（または「同期」）することができます。

```php
class HelloWorld extends Component
{
    public $message;
}
<div>
    <input wire:model="message" type="text">

    <h1>{{ $message }}</h1>
</div>
```

ユーザーがテキスト・フィールドに何かを入力すると、$message プロパティの値が自動的に更新されます。

内部的には、Livewireは要素の入力イベントを待ち、トリガーされるとAJAXリクエストを送信して、新しいデータでコンポーネントを再レンダリングします。



`wire:model`は、入力イベントを発信するあらゆる要素に追加することができます。カスタム要素やサードパーティのJavaScriptライブラリであってもです。

`wire:model`を使用する一般的な要素には以下のようなものがあります。

| Element Tag               |
| ------------------------- |
| `<input type="text">`     |
| `<input type="radio">`    |
| `<input type="checkbox">` |
| `<select>`                |
| `<textarea>`              |

### Binding Nested Data

Livewire はドット記法を使った配列内のネストされたデータへのバインディングをサポートしています。

```html
<input type="text" wire:model="parent.message">
```

### Debouncing Input

デフォルトでは、Livewire はテキスト入力に 150ms のデバウンスを適用します。これにより、ユーザーがテキストフィールドに文字を入力する際に、多くのネットワークリクエストが送信されるのを防ぐことができます。

このデフォルトを無効にしたい（あるいは、テキスト以外の入力にも適用したい）場合、Livewire には「debounce」モディファイアがあります。入力に半秒のデバウンスを適用したい場合は、以下のようにモディファイアを入れます。

```html
<input type="text" wire:model.debounce.500ms="name">
```

### Lazy Updating

デフォルトでは、Livewire はすべての入力イベント（場合によっては変更）の後にサーバにリクエストを送信します。<select> 要素のように、通常は急激な更新が行われない場合にはこの方法で問題ありませんが、ユーザーが入力するたびに更新されるテキストフィールドでは、この方法は不要な場合が多いです。

そのような場合には、lazy directive修飾子を使用して、ネイティブの変更イベントを待ちます。

```html
<input type="text" wire:model.lazy="message">
```

これで、ユーザーが入力フィールドをクリックしたときにのみ、$message プロパティが更新されるようになりました。

### Deferred Updating

データの更新をライブで行う必要がない場合は、Livewireには次のネットワークリクエストでデータの更新をバッチ処理する.deferモディファがあります。

例えば、次のようなコンポーネントがあるとします。

```html
<input type="text" wire:model.defer="query">
<button wire:click="search">Search</button>
```

ユーザーが<input>フィールドに入力しても、ネットワークリクエストは送信されません。ユーザーが入力フィールドをクリックしてページ内の他のフィールドに移動しても、リクエストは送信されません。

ユーザーが「検索」を押すと、Livewire は新しい「クエリ」の状態と、実行する「検索」アクションの両方を含むネットワークリクエストを1つ送信します。

これにより、必要のない時のネットワーク使用量を大幅に削減することができます。

## Binding Directly To Model Properties

Eloquent モデルが Livewire コンポーネントのパブリックプロパティとして保存されている場合、そのプロパティに直接バインドすることができます。以下にコンポーネントの例を示します。

```php
use App\Post;

class PostForm extends Component
{
    public Post $post;

    protected $rules = [
        'post.title' => 'required|string|min:6',
        'post.content' => 'required|string|max:500',
    ];

    public function save()
    {
        $this->validate();

        $this->post->save();
    }
}
<form wire:submit.prevent="save">
    <input type="text" wire:model="post.title">

    <textarea wire:model="post.content"></textarea>

    <button type="submit">Save</button>
</form>
```

上のコンポーネントでは、"title "と "content "のモデル属性に直接バインドしていることに注目してください。Livewire は、リクエストの間に、現在の非永続的なデータを使ってモデルの水分補給と水分除去を行います。



注意: この機能を使用するには、$rules プロパティにバインドしたいモデル属性の検証項目を設定する必要があります。そうしないと、エラーが発生します。

さらに、Eloquent Collection内のモデルにバインドすることもできます。

```php
use App\Post;

class PostForm extends Component
{
    public $posts;

    protected $rules = [
        'posts.*.title' => 'required|string|min:6',
        'posts.*.content' => 'required|string|max:500',
    ];

    public function mount()
    {
        $this->posts = auth()->user()->posts;
    }

    public function save()
    {
        $this->validate();

        foreach ($this->posts as $post) {
            $post->save();
        }
    }
}
<form wire:submit.prevent="save">
    @foreach ($posts as $index => $post)
        <div wire:key="post-field-{{ $post->id }}">
            <input type="text" wire:model="posts.{{ $index }}.title">

            <textarea wire:model="posts.{{ $index }}.content"></textarea>
        </div>
    @endforeach

    <button type="submit">Save</button>
</form>
```

## Computed Properties

Livewire は、ダイナミックプロパティにアクセスするための API を提供しています。これは、データベースやキャッシュのような永続的なストアからプロパティを導き出す場合に特に役立ちます。

```php
class ShowPost extends Component
{
    // Computed Property
    public function getPostProperty()
    {
        return Post::find($this->postId);
    }
```

これで、コンポーネントのクラスやBladeビューから$this->postにアクセスできるようになりました。

```php
class ShowPost extends Component
{
    public $postId;

    public function getPostProperty()
    {
        return Post::find($this->postId);
    }

    public function deletePost()
    {
        $this->post->delete();
    }
}
<div>
    <h1>{{ $this->post->title }}</h1>
    ...
    <button wire:click="deletePost">Delete Post</button>
</div>
```



計算されたプロパティは、個々の Livewire リクエストのライフサイクルに対してキャッシュされます。つまり、コンポーネントのブレードビューで$this->postを5回呼んだとしても、そのたびに別のデータベースクエリを実行することはありません。
