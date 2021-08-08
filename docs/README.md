# Livewire Quickstart

## Install Livewire

Include the PHP.

```php
composer require livewire/livewire
```

JavaScriptを含めます（Livewireを使用するすべてのページに）。

```html
...
    @livewireStyles
</head>
<body>
    ...

    @livewireScripts
</body>
</html>
```

## Create a component



次のコマンドを実行して、`counter`と呼ばれる新しいLivewireコンポーネントを生成します。

```php
php artisan make:livewire counter
```



このコマンドを実行すると、次の2つのファイルが生成されます。

app/Http/Livewire/Counter.php

```php
namespace App\Http\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public function render()
    {
        return view('livewire.counter');
    }
}
```

ビューにテキストを追加して、ブラウザで具体的なものを確認できるようにします。

### Livewireコンポーネントには、単一のルート要素が必要です。

resources/views/livewire/counter.blade.php

```html
<div>
    <h1>Hello World!</h1>
</div>
```



# Include the component

Bladeに含まれるようなLivewireコンポーネントについて考えてみてください。ブレードビューの任意の場所に<livewire：some-component />を挿入すると、レンダリングされます。

```html
<head>
    ...
    @livewireStyles
</head>
<body>
    <livewire:counter />

    ...

    @livewireScripts
</body>
</html>
```



# View it in the browser

Livewireを組み込んだページをブラウザーにロードします。 「HelloWorld！」が表示されます。

---

# Add "counter" functionality

カウンターコンポーネントクラスとビューの生成されたコンテンツを次のものに置き換えます。

app/Http/Livewire/Counter.php

```php
class Counter extends Component
{
    public $count = 0;

    public function increment()
    {
        $this->count++;
    }

    public function render()
    {
        return view('livewire.counter');
    }
}
```

---

# View it in the browser

ブラウザでページをリロードすると、カウンタコンポーネントがレンダリングされているはずです。 「+」ボタンをクリックすると、ページをリロードせずにページが自動的に更新されます。マジック🧙‍♂.️

```
一般に、この「カウンター」のような些細なものは、AlpineJSのようなものに適していますが、Livewireの動作を簡単に理解するための最良の方法の1つです。
```


