# File Uploads

- Basic Upload
  - [Storing Uploaded Files](https://laravel-livewire.com/docs/2.x/file-uploads#storing-files)
- [Handling Multiple Files](https://laravel-livewire.com/docs/2.x/file-uploads#multiple-files)
- File Validation
  - [Real-time Validation](https://laravel-livewire.com/docs/2.x/file-uploads#real-time-validation)
- [Temporary Preview Urls](https://laravel-livewire.com/docs/2.x/file-uploads#preview-urls)
- [Testing File Uploads](https://laravel-livewire.com/docs/2.x/file-uploads#testing-uploads)
- Uploading Directly To Amazon S3
  - [Configuring Automatic File Cleanup](https://laravel-livewire.com/docs/2.x/file-uploads#auto-cleanup)
- [Loading Indicators](https://laravel-livewire.com/docs/2.x/file-uploads#loading-indicators)
- [Progress Indicators (And All JavaScript Events)](https://laravel-livewire.com/docs/2.x/file-uploads#js-hooks)
- [JavaScript Upload API](https://laravel-livewire.com/docs/2.x/file-uploads#js-api)
- Configuration
  - [Global Validation](https://laravel-livewire.com/docs/2.x/file-uploads#global-validation)
  - [Global Middleware](https://laravel-livewire.com/docs/2.x/file-uploads#global-middleware)
  - [Temporary Upload Directory](https://laravel-livewire.com/docs/2.x/file-uploads#temporary-upload-directory)

 

## Basic File Upload

> Note: この機能を使用するには、Livewire のバージョンが 1.2.0 以上である必要があります。

Livewireでは、ファイルのアップロードと保存が非常に簡単です。

まず、あなたのコンポーネントに `WithFileUploads` trait を追加します。これで、他の入力タイプと同じように `wire:model` をファイル入力に使うことができ、残りは Livewire が処理してくれます。

ここでは、写真のアップロードを処理するシンプルなコンポーネントの例を紹介します。

```php
use Livewire\WithFileUploads;

class UploadPhoto extends Component
{
    use WithFileUploads;

    public $photo;

    public function save()
    {
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);

        $this->photo->store('photos');
    }
}
<form wire:submit.prevent="save">
    <input type="file" wire:model="photo">

    @error('photo') <span class="error">{{ $message }}</span> @enderror

    <button type="submit">Save Photo</button>
</form>
```

開発者の視点では、ファイル入力の処理は、他の入力タイプの処理と変わりません。<input>タグに`wire:model`を追加するだけで、他のすべての処理が可能になります。

しかし、Livewire でファイルのアップロードを機能させるためには、フードの下でさらに多くのことが行われています。ここでは、ユーザーがアップロードするファイルを選択したときに何が行われているかを紹介します。

1. 新しいファイルが選択されると、LivewireのJavaScriptはサーバー上のコンポーネントに最初のリクエストを行い、一時的な「署名付き」アップロードURLを取得します。
2. URLを受信すると、JavaScriptは署名されたURLに実際に「アップロード」を行い、Livewireが指定した一時的なディレクトリにアップロードを保存し、新しい一時的なファイルのユニークなハッシュIDを返します。
3. ファイルがアップロードされ、ユニークなハッシュIDが生成されると、LivewireのJavaScriptはサーバー上のコンポーネントに最終的なリクエストを行い、新しい一時ファイルに希望のパブリックプロパティを「設定」するように指示します。
4. これで、パブリック・プロパティ（ここでは$photo）には、一時的にアップロードされたファイルが設定され、いつでも保存や検証ができるようになりました。

### Storing Uploaded Files

前述の例では、最も基本的なストレージのシナリオを示しています。一時的にアップロードされたファイルを、アプリのデフォルトファイルシステムディスク上の「photos」ディレクトリに移動させる。

しかし、保存されたファイルのファイル名をカスタマイズしたい場合や、ファイルを保存する特定のストレージ「ディスク」を指定したい場合もあるでしょう（例えば、S3バケットなど）。

LivewireはLaravelがアップロードされたファイルを保存するのに使用するのと同じAPIを採用していますので、Laravelのドキュメントを参照してください。しかし、ここではいくつかの一般的な保存シナリオを紹介します。

```php
// Store the uploaded file in the "photos" directory of the default filesystem disk.
$this->photo->store('photos');

// Store in the "photos" directory in a configured "s3" bucket.
$this->photo->store('photos', 's3');

// Store in the "photos" directory with the filename "avatar.png".
$this->photo->storeAs('photos', 'avatar');

// Store in the "photos" directory in a configured "s3" bucket with the filename "avatar.png".
$this->photo->storeAs('photos', 'avatar', 's3');

// Store in the "photos" directory, with "public" visibility in a configured "s3" bucket.
$this->photo->storePublicly('photos', 's3');

// Store in the "photos" directory, with the name "avatar.png", with "public" visibility in a configured "s3" bucket.
$this->photo->storePubliclyAs('photos', 'avatar', 's3');
```

上記の方法は、アップロードされたファイルを思い通りに保存するのに十分な柔軟性を備えています。

## Handling Multiple Files

Livewire は <input> タグの multiple 属性を検出することで、複数のファイルアップロードを自動的に処理します。

以下は、複数のアップロードを処理するファイルアップロードの例です。

```php
use Livewire\WithFileUploads;

class UploadPhotos extends Component
{
    use WithFileUploads;

    public $photos = [];

    public function save()
    {
        $this->validate([
            'photos.*' => 'image|max:1024', // 1MB Max
        ]);

        foreach ($this->photos as $photo) {
            $photo->store('photos');
        }
    }
}
<form wire:submit.prevent="save">
    <input type="file" wire:model="photos" multiple>

    @error('photos.*') <span class="error">{{ $message }}</span> @enderror

    <button type="submit">Save Photo</button>
</form>
```

## File Validation

これまでの例で見てきたように、Livewireでのファイルアップロードの検証は、Laravelの標準的なコントローラーからのファイルアップロードの処理と全く同じです。

Laravelのファイル検証ユーティリティーの詳細については、ドキュメントをご覧ください。

### Real-time Validation

ユーザーが「送信」を押す前に、ユーザーのアップロードをリアルタイムで検証することができます。

これも、Livewire の他の入力タイプと同じように行うことができます。

```php
use Livewire\WithFileUploads;

class UploadPhoto extends Component
{
    use WithFileUploads;

    public $photo;

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);
    }

    public function save()
    {
        // ...
    }
}
<form wire:submit.prevent="save">
    <input type="file" wire:model="photo">

    @error('photo') <span class="error">{{ $message }}</span> @enderror

    <button type="submit">Save Photo</button>
</form>
```

これで、ユーザーがファイルを選択すると（Livewireがファイルを一時ディレクトリにアップロードした後）、ファイルが検証され、ユーザーがフォームを送信する前にエラーが表示されるようになります。

## Temporary Preview Urls

ユーザーがファイルを選択した後、フォームを送信して実際にファイルを保存する前に、そのファイルのプレビューを表示したい場合があります。

Livewire では、アップロードされたファイルの ->temporaryUrl() メソッドを使って、これを簡単に行うことができます。

> Note: セキュリティ上の理由から、一時的なURLは画像のアップロードにのみ対応しています。

ここでは、画像プレビュー付きのファイルアップロードの例をご紹介します。

```php
use Livewire\WithFileUploads;

class UploadPhotoWithPreview extends Component
{
    use WithFileUploads;

    public $photo;

    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:1024',
        ]);
    }

    public function save()
    {
        // ...
    }
}
<form wire:submit.prevent="save">
    @if ($photo)
        Photo Preview:
        <img src="{{ $photo->temporaryUrl() }}">
    @endif

    <input type="file" wire:model="photo">

    @error('photo') <span class="error">{{ $message }}</span> @enderror

    <button type="submit">Save Photo</button>
</form>
```

Livewire は前述のように一時ファイルを非公開のディレクトリに保存するため、一時的な公開 URL をユーザーに公開して画像をプレビューする簡単な方法はありません。

Livewire は、アップロードされた画像を装った一時的な署名入り URL を提供することで、ユーザーに何かを見せることができるようにします。

この URL は、一時ディレクトリより上のディレクトリにあるファイルを表示しないように保護されており、一時的に署名されているため、ユーザーはこの URL を悪用してシステム上の他のファイルをプレビューすることはできません。

LivewireがS3を一時的なファイルストレージとして使用するように設定されている場合、->temporaryUrl()を呼び出すと、S3から一時的に署名されたURLが直接生成されるので、Laravelアプリのサーバーにこのプレビューがヒットすることは一切ありません。

## Testing File Uploads

Laravelのファイルアップロードテストヘルパーを使えば、Livewireでのファイルアップロードのテストは簡単です。

ここでは、"UploadPhoto "コンポーネントをLivewireでテストする完全な例を紹介します。

UploadPhotoTest.php

```php
/** @test */
public function can_upload_photo()
{
    Storage::fake('avatars');

    $file = UploadedFile::fake()->image('avatar.png');

    Livewire::test(UploadPhoto::class)
        ->set('photo', $file)
        ->call('upload', 'uploaded-avatar.png');

    Storage::disk('avatars')->assertExists('uploaded-avatar.png');
}
```

先ほどのテストをパスするために必要な「UploadPhoto」コンポーネントのスニペットです。

UploadPhoto.php

```php
class UploadPhoto extends Component
{
    use WithFileUploads;

    public $photo;

    // ...

    public function upload($name)
    {
        $this->photo->storeAs('/', $name, $disk = 'avatars');
    }
}
```

ファイルのアップロードのテストについての詳細は [Laravel's file upload testing documentation](https://laravel.com/docs/http-tests#testing-file-uploads).

## Uploading Directly To Amazon S3

前述したように、Livewire はアップロードされたすべてのファイルを、開発者が ファイルの永久保存を選択するまで一時的なディレクトリに保存します。

デフォルトでは、Livewire はデフォルトのファイルシステムのディスク構成（通常はローカル）を使用し、livewire-tmp/ というフォルダにファイルを保存します。

つまり、アップロードされたファイルは、後で S3 バケットに保存することを選択しても、常にサーバーにヒットするということです。

このシステムを回避して、Livewire の一時的なアップロードを S3 バケットに保存したい場合は、簡単にその動作を設定できます。

config/livewire.php ファイルで livewire.temporary_file_upload.disk を s3 (または s3 ドライバを使用するその他のカスタムディスク) に設定します。

www.DeepL.com/Translator（無料版）で翻訳しました。

```php
return [
    ...
    'temporary_file_upload' => [
        'disk' => 's3',
        ...
    ],
];
```

さて、ユーザーがファイルをアップロードしても、そのファイルは実際にはあなたのサーバーには届きません。ファイルは、S3バケットのサブディレクトリ: `livewire-tmp/`.

### Configuring Automatic File Cleanup

この一時ディレクトリはすぐにファイルでいっぱいになってしまうため、24時間以上前のファイルをクリーンアップするようにS3を設定することが重要です。

この動作を設定するには、S3バケットが設定されている環境で以下のartisanコマンドを実行するだけです。

```bash
php artisan livewire:configure-s3-upload-cleanup
```

これで、24時間以上前の一時ファイルは、S3によって自動的にクリーンアップされます。



S3を使用していない場合は、Livewireが自動的にファイルのクリーンアップを行います。このコマンドを実行する必要はありません。

## Loading Indicators

ファイル・アップロード用の `wire:model` は、他の `wire:model` 入力タイプとはボンネット内での動作が異なりますが、ローディング・インジケータを表示するインターフェイスは同じです。

ファイル・アップロードにスコープされたローディング・インジケータは、次のように表示できます。

```html
<input type="file" wire:model="photo">

<div wire:loading wire:target="photo">Uploading...</div>
```

これで、ファイルのアップロード中は「Uploading...」のメッセージが表示され、アップロードが終了すると非表示になります。

This works with the entire Livewire [Loading States API](https://laravel-livewire.com/docs/2.x/loading-states).

## Progress Indicators (And All JavaScript Events)

Livewire でファイルをアップロードすると、カスタム JavaScript が listen できるように <input> 要素に JavaScript イベントがディスパッチされます。

Here are the dispatched events:

| Event                      | Description                                                  |
| -------------------------- | ------------------------------------------------------------ |
| `livewire-upload-start`    | Dispatched when the upload starts                            |
| `livewire-upload-finish`   | Dispatches if the upload is successfully finished            |
| `livewire-upload-error`    | Dispatches if the upload fails in some way                   |
| `livewire-upload-progress` | Dispatches an event containing the upload progress percentage as the upload progresses |

ここでは、LivewireのファイルアップロードをAlpineJSコンポーネントでラップし、プログレスバーを表示する例を紹介します。

```html
<div
    x-data="{ isUploading: false, progress: 0 }"
    x-on:livewire-upload-start="isUploading = true"
    x-on:livewire-upload-finish="isUploading = false"
    x-on:livewire-upload-error="isUploading = false"
    x-on:livewire-upload-progress="progress = $event.detail.progress"
>
    <!-- File Input -->
    <input type="file" wire:model="photo">

    <!-- Progress Bar -->
    <div x-show="isUploading">
        <progress max="100" x-bind:value="progress"></progress>
    </div>
</div>
```

## JavaScript Upload API

サードパーティのファイルアップロードライブラリとの統合には、単純な <input type="file"> タグよりも細かな制御が必要になることがあります。

このような場合のために、Livewire は専用の JavaScript 関数を公開しています。

この関数は JavaScript コンポーネントオブジェクト上に存在し、Blade の便利なディレクティブを使ってアクセスすることができます。それが @this です。この@thisを見たことがない方は、こちらをご覧ください。

```html
<script>
    let file = document.querySelector('input[type="file"]').files[0]

    // Upload a file:
    @this.upload('photo', file, (uploadedFilename) => {
        // Success callback.
    }, () => {
        // Error callback.
    }, (event) => {
        // Progress callback.
        // event.detail.progress contains a number between 1 and 100 as the upload progresses.
    })

    // Upload multiple files:
    @this.uploadMultiple('photos', [file], successCallback, errorCallback, progressCallback)

    // Remove single file from multiple uploaded files
    @this.removeUpload('photos', uploadedFilename, successCallback)
</script>
```

## Configuration

Livewire はすべてのファイルアップロードを、開発者が検証したり保存したりする前に一時的に保存するため、すべてのファイルアップロードに対していくつかのデフォルト処理を想定しています。

### Global Validation

デフォルトでは、Livewire はすべての一時ファイルのアップロードを以下のルールで検証します: file|max:12288 (12MB 未満のファイルでなければなりません)。

これをカスタマイズしたい場合は、config/livewire.php ですべての一時ファイルアップロードに対して実行するバリデーションルールを正確に設定することができます。

```php
return [
    ...
    'temporary_file_upload' => [
        ...
        'rules' => 'file|mimes:png,jpg,pdf|max:102400', // (100MB max, and only pngs, jpegs, and pdfs.)
        ...
    ],
];
```

### Global Middleware

一時ファイルアップロードエンドポイントには、デフォルトでスロットリングミドルウェアが搭載されています。このエンドポイントがどのミドルウェアを使用するかは、以下の設定変数で正確にカスタマイズできます。

```php
return [
    ...
    'temporary_file_upload' => [
        ...
        'middleware' => 'throttle:5,1', // Only allow 5 uploads per user per minute.
    ],
];
```

### Temporary Upload Directory

指定されたディスク上の livewire-tmp/ ディレクトリに一時ファイルがアップロードされます。以下の設定キーでカスタマイズできます。

```php
return [
    ...
    'temporary_file_upload' => [
        ...
        'directory' => 'tmp',
    ],
];
```
