<x-admin.layout title="Все отчеты">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-xl font-semibold mb-6">Все отчеты</h1>
        
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Тренер</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Статус</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Дата</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Действия</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($reports as $report)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $report->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $report->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $report->status }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $report->created_at->format('d.m.Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('reports.show', $report) }}" class="text-blue-600 hover:text-blue-900">Просмотреть</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $reports->links() }}
        </div>
    </div>
</x-admin.layout>