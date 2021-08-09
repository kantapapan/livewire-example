# Validation

ivewire のバリデーションは、Laravel の標準的なフォームバリデーションに似ています。つまり、Livewireでは、コンポーネントごとにバリデーションルールを設定する$rulesプロパティと、そのルールを使ってコンポーネントのプロパティを検証する$this->validate()メソッドが用意されています。

ここでは、Livewire のフォームを検証する簡単な例を示します。

```php
class ContactForm extends Component
{
    public $name;
    public $email;

    protected $rules = [
        'name' => 'required|min:6',
        'email' => 'required|email',
    ];

    public function submit()
    {
        $this->validate();

        // Execution doesn't reach here if validation fails.

        Contact::create([
            'name' => $this->name,
            'email' => $this->email,
        ]);
    }
}
<form wire:submit.prevent="submit">
    <input type="text" wire:model="name">
    @error('name') <span class="error">{{ $message }}</span> @enderror

    <input type="text" wire:model="email">
    @error('email') <span class="error">{{ $message }}</span> @enderror

    <button type="submit">Save Contact</button>
</form>
```

検証が失敗した場合、標準的な ValidationException がスローされ (Livewire がこれをキャッチ)、標準的な $errors オブジェクトがコンポーネントのビュー内で利用可能になります。このため、アプリケーションの他の部分でバリデーションを処理するための既存のコード（おそらくBladeのインクルード）があれば、ここでも適用されます。

また、カスタムキーとメッセージのペアをエラーバッグに追加することもできます。

```php
$this->addError('key', 'message')
```

ルールを動的に定義する必要がある場合は、$rules プロパティをコンポーネントの rules() メソッドの代わりに使用することができます。

```php
class ContactForm extends Component
{
    public $name;
    public $email;

    protected function rules()
    {
        return [
            'name' => 'required|min:6',
            'email' => ['required', 'email', 'not_in:' . auth()->user()->email],
        ];
    }
}
```

## Real-time Validation

ユーザーがフォームに入力したときに、フォームフィールドのバリデーションを行いたい場合があります。Livewire では、$this->validateOnly() メソッドを使って「リアルタイム」のバリデーションを簡単に行うことができます。

更新のたびに入力フィールドを検証するには、Livewire の更新フックを使います。

```php
class ContactForm extends Component
{
    public $name;
    public $email;

    protected $rules = [
        'name' => 'required|min:6',
        'email' => 'required|email',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function saveContact()
    {
        $validatedData = $this->validate();

        Contact::create($validatedData);
    }
}
<form wire:submit.prevent="saveContact">
    <input type="text" wire:model="name">
    @error('name') <span class="error">{{ $message }}</span> @enderror

    <input type="text" wire:model="email">
    @error('email') <span class="error">{{ $message }}</span> @enderror

    <button type="submit">Save Contact</button>
</form>
```

この例で何が起こっているのか、具体的に説明しましょう。

- ユーザーが "name "フィールドに入力する
- ユーザーが自分の名前を入力すると、6文字未満の場合は検証メッセージが表示されます。
- ユーザーがEメールの入力に切り替えても、名前の検証メッセージは
- ユーザーがフォームを送信すると、最終的な検証チェックが行われ、データが永続化されます。

もしあなたが、「なぜ validateOnly が必要なのか？validateを使うだけではダメなの？ そうでなければ、どのフィールドを更新しても、すべてのフィールドが検証されてしまうからです。これは、ユーザーにとっては不愉快なことです。 validateOnlyはそのような事態を防ぎ、現在更新されているフィールドのみを検証します。

## Validating with rules outside of the `$rules` property

何らかの理由で $rules プロパティで定義したルール以外のルールを使用して検証したい場合は、 validate() メソッドや validateOnly() メソッドに直接ルールを渡すことで対応できます。

```php
class ContactForm extends Component
{
    public $name;
    public $email;

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, [
            'name' => 'min:6',
            'email' => 'email',
        ]);
    }

    public function saveContact()
    {
        $validatedData = $this->validate([
            'name' => 'required|min:6',
            'email' => 'required|email',
        ]);

        Contact::create($validatedData);
    }
}
```

## Customize Error Message & Attributes

Livewire コンポーネントが使用する検証メッセージをカスタマイズしたい場合は、$messages プロパティを使用してカスタマイズできます。

Laravelのデフォルトの検証メッセージはそのままに、メッセージの:attribute部分だけをカスタマイズしたい場合は、$validationAttributesプロパティでカスタム属性名を指定します。

```php
class ContactForm extends Component
{
    public $email;

    protected $rules = [
        'email' => 'required|email',
    ];

    protected $messages = [
        'email.required' => 'The Email Address cannot be empty.',
        'email.email' => 'The Email Address format is not valid.',
    ];

    protected $validationAttributes = [
        'email' => 'email address'
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function saveContact()
    {
        $validatedData = $this->validate();

        Contact::create($validatedData);
    }
}
```

グローバルな $rules 検証プロパティを使用していない場合は、 独自のメッセージや属性を validate() に直接渡すことができます。

```php
class ContactForm extends Component
{
    public $email;

    public function saveContact()
    {
        $validatedData = $this->validate(
            ['email' => 'required|email'],
            [
                'email.required' => 'The :attribute cannot be empty.',
                'email.email' => 'The :attribute format is not valid.',
            ],
            ['email' => 'Email Address']
        );

        Contact::create($validatedData);
    }
}
```

## Direct Error Message Manipulation

ほとんどの場合は validate() と validateOnly() メソッドで対応できますが、Livewire の内部 ErrorBag を直接コントロールしたい場合もあるでしょう。

Livewire には、ErrorBag を直接操作するためのいくつかのメソッドがあります。

Livewire コンポーネントクラス内のどこからでも、以下のメソッドを呼び出すことができます。

```php
// Quickly add a validation message to the error bag.
$this->addError('email', 'The email field is invalid.');

// These two methods do the same thing, they clear the error bag.
$this->resetErrorBag();
$this->resetValidation();

// If you only want to clear errors for one key, you can use:
$this->resetValidation('email');
$this->resetErrorBag('email');

// This will give you full access to the error bag.
$errors = $this->getErrorBag();
// With this error bag instance, you can do things like this:
$errors->add('some-key', 'Some message');
```

## Testing Validation

Livewire には検証シナリオのための便利なテストユーティリティが用意されています。 それでは、オリジナルの「お問い合わせフォーム」コンポーネントの簡単なテストを書いてみましょう。

```php
/** @test  */
public function name_and_email_fields_are_required_for_saving_a_contact()
{
    Livewire::test('contact-form')
        ->set('name', '')
        ->set('email', '')
        ->assertHasErrors(['name', 'email']);
}
```

これは便利ですが、さらに一歩進んで、特定の検証ルールに対して実際にテストすることができます。

```php
/** @test  */
public function name_and_email_fields_are_required_for_saving_a_contact()
{
    Livewire::test('contact-form')
        ->set('name', '')
        ->set('email', '')
        ->assertHasErrors([
            'name' => 'required',
            'email' => 'required',
        ]);
}
```

また、Livewireでは、assertHasErrorsの逆バージョン→assertHasNoErrors()も用意されています。

```php
/** @test  */
public function name_field_is_required_for_saving_a_contact()
{
    Livewire::test('contact-form')
        ->set('name', '')
        ->set('email', 'foo')
        ->assertHasErrors(['name' => 'required'])
        ->assertHasNoErrors(['email' => 'required']);
}
```

これら2つのメソッドでサポートされている構文の詳細な例は、Testing Docsをご覧ください。

## Custom validators

Livewire で独自のバリデーションシステムを使用したい場合も、問題ありません。Livewire は ValidationException をキャッチして、$this->validate() を使うのと同じようにビューにエラーを提供します。

For example:

```php
use Illuminate\Support\Facades\Validator;

class ContactForm extends Component
{
    public $email;

    public function saveContact()
    {
        $validatedData = Validator::make(
            ['email' => $this->email],
            ['email' => 'required|email'],
            ['required' => 'The :attribute field is required'],
        )->validate();

        Contact::create($validatedData);
    }
}
<div>
    Email: <input wire:model.lazy="email">

    @if($errors->has('email'))
        <span>{{ $errors->first('email') }}</span>
    @endif

    <button wire:click="saveContact">Save Contact</button>
</div>
```

                      

              

         Laravelの "FormRequest "が使えるかどうか気になりますよね。 Livewireの性質上、httpリクエストにフックするのは意味がありません。今のところ、この機能は実現できませんし、お勧めできません。    
