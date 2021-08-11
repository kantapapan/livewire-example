<form wire:submit.prevent="confirm">
@csrf
    <div>
        <div class="mt-8">
            <span class="text-sm font-bold text-gray-600 uppercase">ご要望その２（必須）</span>
            <div class="mt-2">
                @foreach ($requestList2 as $key => $request2)
                <div>
                    <label class="inline-flex items-center">
                        <input
                            wire:model="posts.request2.{{$key}}"
                            value="{{$key}}"
                            type="checkbox"
                            class="form-checkbox h-5 w-5">
                        <span class="ml-2">{{$request2}}</span>
                    </label>
                </div>
                @endforeach
            </div>
            @error('posts.request2') <span class="text-red-600 err-message">{{ $message }}</span> @enderror
        </div>

        <div class="mt-8">
            <button
                class="w-full p-3 text-sm font-bold tracking-wide text-gray-100 uppercase bg-green-500 rounded-lg focus:outline-none focus:shadow-outline">
                確認画面へ
            </button>
        </div>
    </div>
</form>
