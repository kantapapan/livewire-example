# Lifecycle Hooks

     **Be amazing at Livewire**  with our in-depth screencasts.     [                  ](https://laravel-livewire.com/screencasts)

[           Watch Now     ](https://laravel-livewire.com/screencasts) 

## Class Hooks

Livewire の各コンポーネントにはライフサイクルがあります。ライフサイクルフックを使うと、コンポーネントのライフサイクルのどの部分でも、または特定のプロパティが更新される前にコードを実行することができます。



| Hooks          | Description                                                  |
| -------------- | ------------------------------------------------------------ |
| mount          | コンポーネントがインスタンス化された直後、render()が呼ばれる前に一度だけ実行されます。 |
| hydrate        | コンポーネントがハイドレートされた後、アクションが実行される前、または render() が呼び出される前に、すべてのリクエストで実行されます。 |
| hydrateFoo     | $fooというプロパティが水和した後に実行されます。             |
| dehydrate      | コンポーネントが脱水される前、ただしrender()が呼ばれた後に、すべてのリクエストで実行されます。 |
| dehydrateFoo   | $fooというプロパティが脱水される前に実行する                 |
| updating       | Livewire コンポーネントのデータが更新される前に実行される (wire:model を使用しており、直接 PHP 内部ではない) |
| updated        | Livewire コンポーネントのデータが更新された後に実行される (wire:model を使用しており、PHP 内部では直接実行されない) |
| updatingFoo    | $foo というプロパティが更新される前に実行されます。          |
| updatedFoo     | $foo というプロパティが更新された後に実行されます。          |
| updatingFooBar | foo プロパティのネストされたプロパティ・バー、または $fooBar や $foo_bar などのマルチワード・プロパティを更新する前に実行されます。 |
| updatedFooBar  | foo プロパティのネストされたプロパティ・バー、または $fooBar や $foo_bar などのマルチワード・プロパティの更新後に実行されます。 |

                      

              

         なお、Livewire のコンポーネントクラス内で直接プロパティを変更しても、更新/更新されたフックは作動しません。

```php
class HelloWorld extends Component
{
    public $foo;

    public function mount()
    {
        //
    }

    public function hydrateFoo($value)
    {
        //
    }

    public function dehydrateFoo($value)
    {
        //
    }

    public function hydrate()
    {
        //
    }

    public function dehydrate()
    {
        //
    }

    public function updating($name, $value)
    {
        //
    }

    public function updated($name, $value)
    {
        //
    }

    public function updatingFoo($value)
    {
        //
    }

    public function updatedFoo($value)
    {
        //
    }

    public function updatingFooBar($value)
    {
        //
    }

    public function updatedFooBar($value)
    {
        //
    }
}
```

## Javascript Hooks

Livewireでは、特定のイベント時にjavascriptを実行することができます。

| Hooks                 | Description                                                  |
| --------------------- | ------------------------------------------------------------ |
| component.initialized | Livewireによってコンポーネントがページ上で初期化されたときに呼び出される |
| element.initialized   | Livewire が個々の要素を初期化する際に呼び出されます。        |
| element.updating      | ネットワークラウンドトリップ後のDOM差分サイクルでLivewireが要素を更新する前に呼び出される |
| element.updated       | ネットワークラウンドトリップ後、LivewireがDOM差分サイクルで要素を更新した後に呼び出される |
| element.removed       | LivewireがDOM拡散サイクル中に要素を削除した後に呼び出されます。 |
| message.sent          | Livewire のアップデートにより、AJAX を介してサーバーに送信されるメッセージがトリガーされたときに呼び出される |
| message.failed        | 何らかの理由でメッセージ送信に失敗した場合に呼び出される     |
| message.received      | LivewireがDOMを更新する前に、メッセージがルートトリップを終えたときに呼び出される |
| message.processed     | Livewireがメッセージからの副作用（DOM差分を含む）をすべて処理した後に呼び出されます。 |

```js
<script>
    document.addEventListener("DOMContentLoaded", () => {
        Livewire.hook('component.initialized', (component) => {})
        Livewire.hook('element.initialized', (el, component) => {})
        Livewire.hook('element.updating', (fromEl, toEl, component) => {})
        Livewire.hook('element.updated', (el, component) => {})
        Livewire.hook('element.removed', (el, component) => {})
        Livewire.hook('message.sent', (message, component) => {})
        Livewire.hook('message.failed', (message, component) => {})
        Livewire.hook('message.received', (message, component) => {})
        Livewire.hook('message.processed', (message, component) => {})
    });
</script>
```
