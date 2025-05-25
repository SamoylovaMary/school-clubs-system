<x-admin.layout title="Редактирование тренера">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-6">Редактировать тренера</h2>
        
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 text-red-600 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 text-green-600 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        
        <form action="{{ route('admin.trainers.update', $trainer->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">ФИО *</label>
                    <input type="text" name="name" id="name" 
                           value="{{ old('name', $trainer->name) }}" 
                           required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email *</label>
                    <input type="email" name="email" id="email" 
                           value="{{ old('email', $trainer->email) }}" 
                           required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Новый пароль</label>
                    <input type="password" name="password" id="password"
                           placeholder="Оставьте пустым, если не нужно менять"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <p class="mt-1 text-sm text-gray-500">Минимум 8 символов</p>
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Подтверждение пароля</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="school" class="block text-sm font-medium text-gray-700">Школа *</label>
                    <input type="text" name="school" id="school" 
                           value="{{ old('school', $trainer->school) }}" 
                           required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700">Город *</label>
                    <input type="text" name="city" id="city" 
                           value="{{ old('city', $trainer->city) }}" 
                           required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Телефон</label>
                    <input type="tel" name="phone" id="phone" 
                           value="{{ old('phone', $trainer->phone) }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Статус</label>
                    <select name="status" id="status"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="active" {{ old('status', $trainer->status) == 'active' ? 'selected' : '' }}>Активен</option>
                        <option value="inactive" {{ old('status', $trainer->status) == 'inactive' ? 'selected' : '' }}>Неактивен</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-8 pt-6 border-t border-gray-200 flex justify-end space-x-4">
                <a href="{{ route('admin.trainers.index') }}" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                    Отмена
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Сохранить изменения
                </button>
            </div>
        </form>
    </div>
</x-admin.layout>