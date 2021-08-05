<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.2/tailwind.min.css">
<title>Contact form sample</title>
    @livewireStyles
</head>
<body class="antialiased overflow-x-hidden">

<div class="grid max-w-screen-xl grid-cols-1 gap-8 px-8 py-16 mx-auto mt-6 text-gray-900 bg-gray-100 md:grid-cols-2 md:px-12 lg:px-16 xl:px-16">
    <div class="flex flex-col justify-between">
        <div>
            <h2 class="text-4xl font-bold leading-tight lg:text-5xl">ContactUs</h2>
            <p class="mt-1 text-xl text-gray-700 text-semibold">
               お問い合わせフォーム
            </p>
        </div>
    </div>
    {{ $slot }}
</div>

    @livewireScripts
</body>


