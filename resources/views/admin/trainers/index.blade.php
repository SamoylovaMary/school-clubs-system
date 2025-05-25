<x-admin.layout title="Управление тренерами">
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold">Список тренеров</h2>
            <a href="{{ route('admin.trainers.create') }}" 
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Добавить тренера
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Имя</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Школа</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($trainers as $trainer)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $trainer->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $trainer->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $trainer->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $trainer->school }}</td>
                        <td class="px-6 py-4 whitespace-nowrap flex space-x-2">
                            <a href="{{ route('admin.trainers.edit', $trainer->id) }}" 
                               class="text-blue-600 hover:text-blue-900">Редактировать</a>
                            <form action="{{ route('admin.trainers.destroy', $trainer->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-900"
                                        onclick="return confirm('Удалить тренера?')">Удалить</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $trainers->links() }}
        </div>
    </div>
</x-admin.layout>