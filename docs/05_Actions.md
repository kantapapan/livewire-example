# Actions

- [Introduction](https://laravel-livewire.com/docs/2.x/actions#introduction)
- [Passing Action Parameters](https://laravel-livewire.com/docs/2.x/actions#action-parameters)
- Event Modifiers
  - [Keydown Modifiers](https://laravel-livewire.com/docs/2.x/actions#keydown-modifiers)
- [Magic Actions](https://laravel-livewire.com/docs/2.x/actions#magic-actions)

 

     **Be amazing at Livewire**  with our in-depth screencasts.     [                  ](https://laravel-livewire.com/screencasts)

[           Watch Now     ](https://laravel-livewire.com/screencasts) 

## Introduction

Livewire のアクションの目的は、ページのインタラクションを簡単に聞き取り、Livewire コンポーネントのメソッドを呼び出すことです（コンポーネントは再レンダリングされます）。

基本的な使い方をご紹介します。

```php
class ShowPost extends Component
{
    public Post $post;

    public function like()
    {
        $this->post->addLikeBy(auth()->user());
    }
}
<div>
    <button wire:click="like">Like Post</button>
</div>
```

Livewire は現在、ブラウザのイベントを聞くためのいくつかのディレクティブを提供しています。これらすべてに共通するフォーマットは: `wire:[dispatched browser event]="[action]"`.

ここでは、一般的なイベントをご紹介します。

| Event   | Directive      |
| ------- | -------------- |
| click   | `wire:click`   |
| keydown | `wire:keydown` |
| submit  | `wire:submit`  |

それぞれのHTMLでの例をご紹介します。

```html
<button wire:click="doSomething">Do Something</button>
<input wire:keydown.enter="doSomething">
<form wire:submit.prevent="save">
    ...

    <button>Save</button>
</form>
```

                      

              

        バインディングしている要素でディスパッチされるあらゆるイベントをリッスンすることができます。例えば、"foo "というブラウザのイベントをディスパッチする要素があるとすると、次のようにしてそのイベントをリッスンすることができます。: `<button wire:foo="someAction">`     

## Passing Action Parameters

Livewire のアクションには、次のように式の中で直接追加のパラメータを渡すことができます。

```html
<button wire:click="addTodo({{ $todo->id }}, '{{ $todo->name }}')">
    Add Todo
</button>
```

アクションに渡された追加のパラメータは、PHPの標準的なパラメータとしてコンポーネントのメソッドに渡されます。

```php
public function addTodo($id, $name)
{
    ...
}
```

アクションパラメータは、タイプヒントを使ってモデルのキーを直接解決することもできます。

```php
public function addTodo(Todo $todo, $name)
{
    ...
}
```

アクションがLaravelの依存性注入コンテナを介して解決すべきサービスを必要とする場合、アクションのシグネチャーの中で、追加のパラメータの前にそれらを列挙することができます。

```php
public function addTodo(TodoService $todoService, $id, $name)
{
    ...
}
```

## Event Modifiers

キーダウンの例で見たように、Livewire のディレクティブには、イベントに追加機能を与える「修飾子」が用意されていることがあります。以下は、どのイベントにも使用できる修飾子です。

| Modifier       | Description                                                  |
| -------------- | ------------------------------------------------------------ |
| stop           | `event.stopPropagation()`と同等の機能です。                  |
| prevent        | `event.preventDefault()`と同等の機能です                     |
| self           | イベントが自分自身でトリガーされた場合にのみ、アクションをトリガーします。これにより、子要素からトリガーされたイベントを外側の要素がキャッチすることを防ぎます。(モーダルバックドロップのリスナーを登録する場合などによく使われます) |
| debounce.150ms | Xmsのデバウンスをアクションの処理に追加します。              |

### Keydown Modifiers

キーダウンイベントで特定のキーをリッスンするには、キーの名前を修飾子として渡すことができます。KeyboardEvent.keyで公開されている有効なキー名をkebab-caseに変換して修飾子として直接使用できます。.

ここでは、一般的に必要とされるものを簡単にご紹介します。

| Native Browser Event | Livewire Modifier |
| -------------------- | ----------------- |
| Backspace            | backspace         |
| Escape               | escape            |
| Shift                | shift             |
| Tab                  | tab               |
| ArrowRight           | arrow-right       |

```html
<input wire:keydown.page-down="foo">
```

上記の例では、event.keyが'PageDown'になった場合にのみ、ハンドラが呼び出されます。

## Magic Actions

Livewireでは、いくつかの「マジック」アクションがあり、通常「$」記号が前に付きます。

| Function                      | Description                                                  |
| ----------------------------- | ------------------------------------------------------------ |
| $refresh                      | アクションを起こさずにコンポーネントを再レンダリングします。 |
| $set('*property*', *value*)   | プロパティの値を更新するショートカット                       |
| $toggle('*property*')         | ブーリアンプロパティのオン/オフを切り替えるショートカット    |
| $emit('*event*', *...params*) | グローバル・イベント・バスに、指定されたパラメータでイベントを発行します。 |
| $event                        | アクションのトリガーとなって発生したイベントの値を保持する特別な変数です。使用例: `wire:change="setSomeProperty($event.target.value)"` |

これらをイベントリスナーの値として渡すことで、Livewire で特別なことができます。

例えば、$set()を例にとってみましょう。これを使って、コンポーネントのプロパティの値を手動で設定することができます。Counter コンポーネントのビューを考えてみましょう。

**Before**

```php
<div>
    {{ $message }}
    <button wire:click="setMessageToHello">Say Hi</button>
</div>
```

**After**

```php
<div>
    {{ $message }}
    <button wire:click="$set('message', 'Hello')">Say Hi</button>
</div>
```

もはやsetMessageToHello関数を呼び出しているのではなく、データの設定内容を直接指定していることに注目してください。
