# Events

- Firing Events
  - [From The Template](https://laravel-livewire.com/docs/2.x/events#from-template)
  - [From The Component](https://laravel-livewire.com/docs/2.x/events#from-component)
  - [From Global JavaScript](https://laravel-livewire.com/docs/2.x/events#from-js)
- [Event Listeners](https://laravel-livewire.com/docs/2.x/events#event-listeners)
- [Passing Parameters](https://laravel-livewire.com/docs/2.x/events#passing-parameters)
- Scoping Events
  - [Scoping To Parent Listeners](https://laravel-livewire.com/docs/2.x/events#scope-to-parents)
  - [Scoping To Components By Name](https://laravel-livewire.com/docs/2.x/events#scope-by-name)
  - [Scoping To Self](https://laravel-livewire.com/docs/2.x/events#scope-to-self)
- [Listening For Events In JavaScript](https://laravel-livewire.com/docs/2.x/events#in-js)
- [Dispatching Browser Events](https://laravel-livewire.com/docs/2.x/events#browser)

 

     **Be amazing at Livewire**  with our in-depth screencasts.     [                  ](https://laravel-livewire.com/screencasts)

[           Watch Now     ](https://laravel-livewire.com/screencasts) 

Livewire コンポーネントは、グローバルイベントシステムを通じて相互に通信することができます。2 つの Livewire コンポーネントが同じページに存在する限り、イベントとリスナーを使って通信することができます。

## Firing Events

Livewire コンポーネントからイベントを発生させるには複数の方法があります。

### 方法A: テンプレートから

```html
<button wire:click="$emit('postAdded')">
```

### 方法B：コンポーネントから

```php
$this->emit('postAdded');
```

### メソッドC: グローバルJavaScriptから

```javascript
<script>
    Livewire.emit('postAdded')
</script>
```

## Event Listeners

イベントリスナーは、Livewire コンポーネントの $listeners プロパティに登録されます。

リスナーはkey->valueのペアで、keyには listenするイベント、valueにはコンポーネント上で呼び出すメソッドを指定します。

```php
class ShowPosts extends Component
{
    public $postCount;

    protected $listeners = ['postAdded' => 'incrementPostCount'];

    public function incrementPostCount()
    {
        $this->postCount = Post::count();
    }
}
```

これで、ページ上の他のコンポーネントがpostAddedイベントを発すると、このコンポーネントがそれを拾って、自分自身にincrementPostCountメソッドを実行します。

                      

              

        イベントの名前と呼び出すメソッドの名前が一致する場合は、キーを省略することができます。

例：`protected $listeners = ['postAdded'];` は、`postAdded`イベントが発行されたときに`postAdded`メソッドを呼び出します。   

イベント・リスナーの名前を動的に指定する必要がある場合は、$listeners プロパティをコンポーネントの getListeners() プロテクテッド・メソッドに置き換えることができます。

```php
class ShowPosts extends Component
{
    public $postCount;

    protected function getListeners()
    {
        return ['postAdded' => 'incrementPostCount'];
    }

    ...
}
```

## Passing Parameters

また、イベント・エミッションでパラメータを送信することもできます。

```php
$this->emit('postAdded', $post->id);
class ShowPosts extends Component
{
    public $postCount;
    public $recentlyAddedPost;

    protected $listeners = ['postAdded'];

    public function postAdded(Post $post)
    {
        $this->postCount = Post::count();
        $this->recentlyAddedPost = $post;
    }
}
```

## Scoping Events

### Scoping To Parent Listeners

When dealing with [nested components](https://laravel-livewire.com/docs/2.x/nesting-components)

ネストしたコンポーネントを扱うとき、イベントを親だけに発行し、子や兄弟のコンポーネントには発行したくない場合があります。

このような場合には、emitUp機能を使用することができます。

```php
$this->emitUp('postAdded');
<button wire:click="$emitUp('postAdded')">
```

### Scoping To Components By Name

同じタイプの他のコンポーネントに対してのみイベントを発信したい場合があります。

このような場合には、emitToを使用することができます。

```php
$this->emitTo('counter', 'postAdded');
<button wire:click="$emitTo('counter', 'postAdded')">
```

(これで、ボタンがクリックされると、"postAdded "イベントがカウンターコンポーネントにのみ発せられるようになりました）。)

### Scoping To Self

時には、イベントを発生させたコンポーネントに対してのみイベントをエミットしたい場合があります。

このような場合には、emitSelfを使用することができます。

```php
$this->emitSelf('postAdded');
<button wire:click="$emitSelf('postAdded')">
```

(これで、ボタンがクリックされた場合、"postAdded "イベントは、そのイベントが発せられたコンポーネントのインスタンスにのみ発せられるようになります)

## Listening For Events In JavaScript

Livewireでは、以下のようにJavaScriptでイベントリスナーを登録することができます。

```javascript
<script>
Livewire.on('postAdded', postId => {
    alert('A post was added with the id of: ' + postId);
})
</script>
```

                      

              

        この機能は実際には非常に強力です。例えば、リスナーを登録して、Livewire が特定のアクションを行ったときに、アプリ内にトースター（ポップアップ）を表示させることができます。これは、Livewire を使って PHP と JavaScript の間のギャップを埋める多くの方法の一つです。    

## Dispatching Browser Events

Livewireでは、以下のようにブラウザウィンドウのイベントを発生させることができます。

```php
$this->dispatchBrowserEvent('name-updated', ['newName' => $value]);
```

このウィンドウイベントをJavaScriptでリッスンすることができます。

```javascript
<script>
window.addEventListener('name-updated', event => {
    alert('Name updated to: ' + event.detail.newName);
})
</script>
```

AlpineJSでは、これらのウィンドウイベントをHTMLの中で簡単にリッスンすることができます。

```html
<div x-data="{ open: false }" @name-updated.window="open = false">
    <!-- Modal with a Livewire name update form -->
</div>
```
