# Redirecting

Livewire コンポーネントの内部からアプリ内の別のページにリダイレクトしたい場合があります。Livewire は、Laravel コントローラでお馴染みの標準的なリダイレクトレスポンス構文をサポートしています。

```php
class ContactForm extends Component
{
    public $email;

    public function addContact()
    {
        Contact::create(['email' => $this->email]);

        return redirect()->to('/contact-form-success');
    }
}
<div>
    Email: <input wire:model="email">

    <button wire:click="addContact">Submit</button>
</div>
```

ユーザーが "Submit "をクリックし、連絡先がデータベースに追加されると、成功ページ(/contact-form-success)にリダイレクトされます。

                      

              

        LivewireはLaravelのリダイレクトシステムと連動しているので、redirect('/foo')、redirect()->to('/foo')、redirect()->route('foo')など、慣れ親しんだ記法を使うことができます。
