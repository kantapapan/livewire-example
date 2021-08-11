<form wire:submit.prevent="confirm">
@csrf
    <div>
    <div><p>{{ $targetPref }}</p></div>
    <div class="flex flex-wrap m-6 mb-2 -mx-3">

        <div class="w-full px-3 mb-6 md:w-1/2 md:mb-0">
            <label class="block mb-2 text-sm font-bold tracking-wide text-gray-700 uppercase"
                for="grid-state">
                都道府県
            </label>

            <div class="relative">
                <select
                    wire:model="posts.prefecture"
                    wire:change="onChangePref"
                    class="block w-full px-4 py-3 pr-8 leading-tight text-gray-700 bg-white border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                    id="grid-state">
                    <option value="0">選択</option>
                @foreach($prefectures as $index => $name)
                    <option value="{{ $index }}">{{$name}}</option>
                @endforeach
                </select>
                @error('posts.prefecture') <span class="text-red-600 err-message">{{ $message }}</span> @enderror
                <div
                    class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 pointer-events-none">
                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                </div>
            </div>
        </div>

        <div class="w-full px-3 mb-6 md:w-1/2 md:mb-0">
            <label class="block mb-2 text-sm font-bold tracking-wide text-gray-700 uppercase"
                for="grid-state">
                エリア
            </label>

            <div class="relative">
                <select
                    wire:model="posts.area"
                    class="block w-full px-4 py-3 pr-8 leading-tight text-gray-700 bg-white border border-gray-200 rounded appearance-none focus:outline-none focus:bg-white focus:border-gray-500"
                    id="grid-state">
                    <option value="0">選択</option>
                @foreach($areas as $index => $name)
                    <option value="{{ $index }}">{{$name}}</option>
                @endforeach
                </select>
                @error('posts.area') <span class="text-red-600 err-message">{{ $message }}</span> @enderror
                <div
                    class="absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 pointer-events-none">
                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20">
                        <path
                            d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                        </svg>
                </div>
            </div>
        </div>

    </div>
    
        <div class="mt-8">
            <button
                class="w-full p-3 text-sm font-bold tracking-wide text-gray-100 uppercase bg-green-500 rounded-lg focus:outline-none focus:shadow-outline">
                内容確認
            </button>
        </div>
    </div>
</form>
