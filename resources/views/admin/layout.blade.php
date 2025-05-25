<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админпанель | {{ $title ?? 'ШСК' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    @include('admin.partials.header')
    
    <div class="flex">
        @include('admin.partials.sidebar')
        
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>
    </div>
</body>
</html>