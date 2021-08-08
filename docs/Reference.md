# Reference

https://laravel-livewire.com/docs/2.x/reference



すでにLivewireに精通していて、長い形式のドキュメントをスキップしたいですか？これがLivewireで利用可能なすべての巨大なリストです。

# Template Directives

これらは、Livewireコンポーネントテンプレート内の要素に追加されるディレクティブです。

```php+HTML
<button wire:click="save">...</button>
```



| Directive                         | Description                                                  |
| --------------------------------- | ------------------------------------------------------------ |
| `wire:key="foo"`                  | LivewireのDOM差分システムの参照ポイントとして機能します。要素の追加/削除、およびリストの追跡に役立ちます。 |
| `wire:click="foo"`                | 「クリック」イベントをリッスンし、コンポーネントで「foo」メソッドを起動します。 |
| `wire:click.prefetch="foo"`       | 「mouseenter」イベントをリッスンし、コンポーネントの「foo」メソッドの結果を「prefetch」します。次に、クリックされた場合、「prefetchされた」結果をスワップインし（追加のリクエストなしで）、クリックされなかった場合、キャッシュされた結果を破棄します。 |
| `wire:keydown.enter="foo"`        | コンポーネントの「foo」メソッドを起動するEnterキーのkeydownイベントをリッスンします。 |
| `wire:foo="bar"`                  | 「foo」と呼ばれるブラウザイベントをリッスンします。 （Livewireによって発生したイベントだけでなく、任意のブラウザーDOMイベントをリッスンできます）。 |
| `wire:model="foo"`                | `$ foo`がコンポーネントクラスのパブリックプロパティであるとすると、このディレクティブを持つ入力要素が更新されるたびに、プロパティはその値と同期します。 |
| `wire:model.debounce.100ms="foo"` | 要素によって発行された入力イベントを100ミリ秒ごとにデバウンスします。 |
| `wire:model.lazy="foo"`           | 入力を、静止している対応するコンポーネントプロパティと遅延同期します。 |
| `wire:model.defer="foo"`          | 「アクション」が実行されるまで、入力をLivewireプロパティと同期する延期。これにより、サーバーのラウンドトリップが大幅に節約されます。 |
| `wire:poll.500ms="foo"`           | 500ミリ秒ごとにコンポーネントクラスで「foo」メソッドを実行します。 |
| `wire:init="foo"`                 | コンポーネントがページにレンダリングされた直後に、コンポーネントに対して「foo」メソッドを実行します。 |
| `wire:loading`                    | デフォルトで要素を非表示にし、ネットワーク要求の転送中に要素を表示します。 |
| `wire:loading.class="foo"`        | ネットワーク要求の転送中に、要素にfooクラスを追加します。    |
| `wire:loading.class.remove="foo"` | ネットワーク要求の転送中にfooクラスを削除します。            |
| `wire:loading.attr="disabled"`    | ネットワーク要求の転送中にdisabled = "true"属性を追加します。 |
| `wire:dirty`                      | デフォルトで要素を非表示にし、要素の状態が「ダーティ」（バックエンドに存在するものとは異なる）の間、要素を表示します。 |
| `wire:dirty.class="foo"`          | ダーティな要素にfooクラスを追加します。                      |
| `wire:dirty.class.remove="foo"`   | 要素がダーティのときにfooクラスを削除します。                |
| `wire:dirty.attr="disabled"`      | 要素がダーティのときにdisabled = "true"属性を追加します。    |
| `wire:target="foo"`               | ワイヤー：ロードおよびワイヤー：ダーティ機能を特定のアクションにスコープします。 |
| `wire:ignore`                     | サーバー要求からDOMを更新するときに、要素またはその子を更新しないようにLivewireに指示します。 Livewireコンポーネント内でサードパーティのJavaScriptライブラリを使用する場合に便利です。 |
| `wire:ignore.self`                | 「self」修飾子は、要素自体の更新を制限しますが、その子の変更は許可します。 |



## Alpine Component Object (`$wire`)

これらは、Livewireテンプレート内のAlpineコンポーネントに提供される$ wireオブジェクトで使用可能なメソッドとプロパティです。

チュートリアル

https://readouble.com/livewire/2.x/ja/alpine-js.html

https://qiita.com/higemoja/items/20e681391fb18b20c341

```html
<div x-data>
    <span x-show="$wire.showMessage">...</span>

    <button x-on:click="$wire.toggleShowMessage()">...</button>
</div>
```

| API                                       | Description                                                  |
| ----------------------------------------- | ------------------------------------------------------------ |
| `$wire.foo`                               | Livewireコンポーネントの「foo」プロパティの値を取得します    |
| `$wire.foo = 'bar'`                       | Livewireコンポーネントの「foo」プロパティの値を設定します    |
| `$wire.bar(..args)`                       | Livewireコンポーネントで（paramsを使用して）「bar」メソッドを呼び出します |
| `let baz = await $wire.bar(..args)`       | 「bar」メソッドを呼び出しますが、応答を待ち、それにbazを設定します |
| `$wire.on('foo', (..args) => {})`         | 「foo」イベントが発行されたときに関数を呼び出す              |
| `$wire.emit('foo', ...args)`              | すべてのLivewireコンポーネントに「foo」イベントを発行します  |
| `$wire.emitUp('foo', ...args)`            | 親コンポーネントに「foo」イベントを発行します                |
| `$wire.emitSelf('foo', ...args)`          | このコンポーネントにのみ「foo」イベントを発行します          |
| `$wire.get('foo')`                        | 「foo」プロパティを取得します                                |
| `$wire.set('foo', 'bar')`                 | コンポーネントに「foo」プロパティを設定します                |
| `$wire.call('foo', ..args)`               | コンポーネントのパラメータを使用して「foo」メソッドを呼び出します |
| `x-data="{ foo: $wire.entangle('foo') }"` | LivewireとAlpineの間で「foo」の値を結び付ける                |
| `$wire.entangle('foo').defer`             | 次回Livewireリクエストが発生したときにのみ、Livewireの「foo」を更新します |



## Global Livewire JavaScript Object

これらは、フロントエンドの`window.Livewire`オブジェクトで使用できるメソッドです。これらは、Livewireの相互作用とカスタマイズを深めるためのものです



| Method                                                       | Description                                                  |
| ------------------------------------------------------------ | ------------------------------------------------------------ |
| `Livewire.first()`                                           | ページ上の最初のLivewireコンポーネントのJSオブジェクトを取得します |
| `Livewire.find(componentId)`                                 | IDでLivewireコンポーネントを取得します                       |
| `Livewire.all()`                                             | ページ上のすべてのLivewireコンポーネントを取得します         |
| `Livewire.directive(directiveName, (el, directive, component) => {})` | 新しいLivewireディレクティブを登録します（wire：custom-directive） |
| `Livewire.hook(hookName, (...) => {})`                       | JSライフサイクルフックが起動されたときにメソッドを呼び出します。[Read more](https://laravel-livewire.com/docs/2.x/reference#js-hooks) |
| `Livewire.onLoad(() => {})`                                  | Livewireが最初にページへの読み込みを完了したときに発生します |
| `Livewire.onError((message, statusCode) => {})`              | Livewireリクエストが失敗したときに発生します。 Livewireのデフォルトの動作を防ぐために、コールバックからfalseを返すことができます |
| `Livewire.emit(eventName, ...params)`                        | ページをリッスンしているすべてのLivewireコンポーネントにイベントを発行します |
| `Livewire.emitTo(componentName, eventName, ...params)`       | 特定のコンポーネント名にイベントを発行する                   |
| `Livewire.on(eventName, (...params) => {})`                  | コンポーネントから発行されるイベントをリッスンします         |
| `Livewire.start()`                                           | ページ上でLivewireを起動します（@livewireScriptsを介して自動的に実行されます） |
| `Livewire.stop()`                                            | ページからLivewireを分解します                               |
| `Livewire.restart()`                                         | 停止してから、ページでLivewireを開始します                   |
| `Livewire.rescan()`                                          | 新しく追加されたLivewireコンポーネントのDOMを再スキャンします |



## JavaScript Hooks

これらは、JavaScriptでリッスンできる「フック」です。これらを使用すると、LivewireコンポーネントのJavaScriptライフサイクルの非常に特定の部分にフックして、サードパーティのパッケージや詳細なカスタマイズを行うことができます。ここで解き放たれる能力は計り知れません。 Livewireのコアの重要な部分は、これらのフックを使用して機能を提供します。

```php
Livewire.hook('component.initialized', component => {
    //
})
```



| Name                    | Params                      | Description                                                 |
| ----------------------- | --------------------------- | ----------------------------------------------------------- |
| `component.initialized` | `(component)`               | 新しいコンポーネントが初期化されました                      |
| `element.initialized`   | `(el, component)`           | 新しい要素が初期化されました                                |
| `element.updating`      | `(fromEl, toEl, component)` | Livewireリクエストの後に要素が更新されようとしています      |
| `element.updated`       | `(el, component)`           | Livewireリクエストから要素が更新されました                  |
| `element.removed`       | `(el, component)`           | Livewireリクエスト後に要素が削除されました                  |
| `message.sent`          | `(message, component)`      | 新しいLivewireメッセージがサーバーに送信されました          |
| `message.failed`        | `(message, component)`      | Livewire ajaxリクエスト（メッセージ）が失敗しました         |
| `message.received`      | `(message, component)`      | メッセージを受信しました（ただし、DOMには影響していません） |
| `message.processed`     | `(message, component)`      | メッセージが完全に受信され、実装されました（DOMの更新など） |



## Component Class Lifecycle Hooks

これらは、バックエンドのライフサイクルの特定の時間にコードを実行するためにLivewireコンポーネントクラスで宣言できるメソッドです。

[Read Full Documentation](https://laravel-livewire.com/docs/2.x/lifecycle-hooks)

```php
class ShowPost extends Component
{
    public function mount()
    {
        //
    }
}
```



| Name                         | Description                                                  |
| ---------------------------- | ------------------------------------------------------------ |
| `mount(...$params)`          | Livewireコンポーネントが新しくなったときに呼び出されます（コンストラクターのように考えてください） |
| `hydrate()`                  | コンポーネントがハイドレイトされた後、他のアクションが発生する前に、後続のLivewireリクエストで呼び出されます |
| `hydrateFoo()`               | $ fooというプロパティがハイドレイトされた後に実行されます    |
| `dehydrate()`                | render() の後、コンポーネントが脱水(dehydrated)されてフロントエンドに送信される前に呼び出されます |
| `dehydrateFoo()`             | $ fooというプロパティが脱水(dehydrated)される前に実行されます |
| `updating()`                 | Livewireコンポーネントのデータが更新される前に実行されます（PHP内ではなくwire：modelを使用） |
| `updated($field, $newValue)` | プロパティが更新された後に呼び出されます                     |
| `updatingFoo()`              | $ fooというプロパティが更新される前に実行されます            |
| `updatedFoo($newValue)`      | 「foo」プロパティが更新された後に呼び出されます              |
| `updatingFooBar()`           | $ fooプロパティのネストされたプロパティバーを更新する前に実行されます |
| `updatedFooBar($newValue)`   | 「foo」プロパティのネストされた「bar」キーが更新された後に呼び出されます |
| `render()`                   | 脱水(dehydrated)の前に呼び出され、コンポーネントのBlade Viewをレンダリングします |



## Component Class Protected Properties

Livewireは、コンポーネントのクラスの保護されたプロパティを通じてコア機能を提供します。プロパティとして宣言するのではなく、メソッドで値を返す場合は、これらのほとんどに同じ名前の対応するメソッドがあります。

```php
class ShowPost extends Component
{
    protected $rules = ['foo' => 'required|min:6'];
}
```



| Name               | Description                                                  |
| ------------------ | ------------------------------------------------------------ |
| `$queryString`     | クエリスティングに「バインド」するプロパティを宣言します。 [Read Docs](https://laravel-livewire.com/docs/2.x/query-string) |
| `$rules`           | 呼び出し時にプロパティに適用される検証ルールを指定します `$this->validate()`. [Read Docs](https://laravel-livewire.com/docs/2.x/input-validation) |
| `$listeners`       | 他のコンポーネントによって発行されるリッスンするイベントを指定します。 [Read Docs](https://laravel-livewire.com/docs/2.x/events) |
| `$paginationTheme` | ページネーションテーマにTailwindとBootstrapのどちらを使用するかを指定します。 [Read Docs](https://laravel-livewire.com/docs/2.x/pagination) |



## Component Class Traits












