<nav class="w-64 bg-white shadow h-screen p-4">
    <ul class="space-y-2">
        <li>
            <a href="{{ route('admin.dashboard') }}" 
               class="block px-4 py-2 rounded hover:bg-gray-100">Дашборд</a>
        </li>
        <li>
            <a href="{{ route('admin.trainers.index') }}" 
               class="block px-4 py-2 rounded bg-blue-50 text-blue-600 font-medium">Тренеры</a>
        </li>
        <li>
            <a href="{{ route('admin.reports.index') }}" 
               class="block px-4 py-2 rounded hover:bg-gray-100">Отчеты</a>
        </li>
    </ul>
</nav>