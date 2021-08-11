<div>
<div>以下の内容を確認して、送信ボタンを押してください。</div>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <div class="border-t border-gray-200">
        <dl>
        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
            都道府県
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            {{ @$prefectures[ $posts['prefecture'] ] }}
            </dd>
        </div>
        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
            <dt class="text-sm font-medium text-gray-500">
            エリア
            </dt>
            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
            {{ $posts['area'] }}
            </dd>
        </div>
        </dl>
    </div>
    </div>
    <div class="mt-8">
        <button
        wire:click="submit"
        class="w-full p-3 text-sm font-bold tracking-wide text-gray-100 uppercase bg-green-500 rounded-lg focus:outline-none focus:shadow-outline">
        上記内容を送信
        </button>
    </div>
    <div class="mt-8">
        <button
        wire:click="back"
        class="w-full p-3 text-sm font-bold tracking-wide text-gray-100 uppercase bg-gray-500 rounded-lg focus:outline-none focus:shadow-outline">
        修正
        </button>
    </div>
</div>
