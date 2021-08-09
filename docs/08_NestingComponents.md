# Nesting Components

ivewire はコンポーネントのネスティングをサポートしています。コンポーネントのネストは非常に強力なテクニックですが、前もって言っておくべきいくつかの問題があります。

1. ネストされたコンポーネントは、親からデータパラメータを受け取ることができますが、Vueコンポーネントのpropsのようなリアクティブ性はありません。
2. Blade のスニペットを別のファイルに抽出するために、Livewire コンポーネントを使用してはいけません。このような場合には、Bladeのインクルードやコンポーネントを使用することをお勧めします。

ここでは、他のLivewireコンポーネントのビューからadd-user-noteというネストされたコンポーネントの例を紹介します。

```php
class UserDashboard extends Component
{
    public User $user;
}
<div>
    <h2>User Details:</h2>
    Name: {{ $user->name }}
    Email: {{ $user->email }}

    <h2>User Notes:</h2>
    <div>
        @livewire('add-user-note', ['user' => $user])
    </div>
</div>
```

## Keeping Track Of Components In A Loop

VueJs と同様に、ループの中でコンポーネントをレンダリングした場合、livewire はどれがどれであるかを追跡する方法がありません。この問題を解決するために、livewire は特別な「キー」構文を提供しています。

```html
<div>
    @foreach ($users as $user)
        @livewire('user-profile', ['user' => $user], key($user->id))
    @endforeach
</div>
```

Laravel 7以上であれば、タグ構文を使用することができます。

```html
<div>
    @foreach ($users as $user)
        <livewire:user-profile :user="$user" :wire:key="$user->id">
    @endforeach
</div>
```

### Sibling Components in a Loop

場合によっては、ループ内に兄弟コンポーネントを持つ必要があるかもしれませんが、その場合は`wire:key`の値をさらに考慮する必要があります。

各コンポーネントにはそれぞれ固有の `wire:key` が必要ですが、上記の方法では兄弟コンポーネントの両方が同じキーを持つことになり、予期しない問題が発生します。この問題を解決するには、例えば、`wire:key`の前にコンポーネント名を付けることで、各`wire:key`が一意になるようにします。

```html
<!-- user-profile component -->
<div>
    // Bad
    <livewire:user-profile-one :user="$user" :wire:key="$user->id">
    <livewire:user-profile-two :user="$user" :wire:key="$user->id">

    // Good
    <livewire:user-profile-one :user="$user" :wire:key="'user-profile-one-'.$user->id">
    <livewire:user-profile-two :user="$user" :wire:key="'user-profile-two-'.$user->id">
</div>
```
