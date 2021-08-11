ありがとうございます。

■お名前
{{ Arr::get($posts, 'name') }}

■メールアドレス
{{ Arr::get($posts, 'mail') }}

■ご要望
@foreach ($posts['request'] as $request)
{{$requestList[$request]}}
@endforeach

■郵便番号
{{ Arr::get($posts, 'zipcode', '-') }}


■都道府県
{{ @$prefectures[ $posts['prefecture'] ] }}

■ご希望・ご質問
{{ Arr::get($posts, 'comment', '-') }}

■ご要望2
@foreach ($posts['request2'] as $request2)
{{$requestList2[$request2]}}
@endforeach
