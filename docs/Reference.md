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
