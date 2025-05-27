<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Создание отчёта
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ step: 1 }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('reports.store') }}" enctype="multipart/form-data">
                @csrf
                
                <!-- Шаг 1: Основные данные -->
                <div x-show="step === 1">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Количество занимающихся в ШСК:
                        </label>
                        <input type="number" name="students_count" required
                               class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Виды спорта и количество участников:
                        </label>
                        <div id="sports-container">
                            <div class="sport-row mb-2 flex gap-2">
                                <input type="text" name="sports[0][name]" placeholder="Вид спорта" required
                                       class="shadow appearance-none border rounded py-2 px-3 text-gray-700">
                                <input type="number" name="sports[0][count]" placeholder="Количество" required
                                       class="shadow appearance-none border rounded py-2 px-3 text-gray-700">
                            </div>
                        </div>
                        <button type="button" onclick="addSportField()" 
                                class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">
                            + Добавить вид спорта
                        </button>
                    </div>

                    <button type="button" @click="step = 2" 
                            class="bg-blue-500 hover:bg-blue-700 text-gray-700 font-bold py-2 px-4 rounded">
                        Далее
                    </button>
                </div>

                <!-- Шаг 2: Мероприятия -->
                <div x-show="step === 2" x-cloak>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Мероприятия:
                        </label>
                        <div id="events-container">
                            <div class="event-row mb-4 p-4 border rounded">
                                <div class="mb-2">
                                    <input type="text" name="events[0][name]" placeholder="Название мероприятия" required
                                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                                </div>
                                <div class="mb-2">
                                    <input type="date" name="events[0][date]" required
                                           class="shadow appearance-none border rounded py-2 px-3 text-gray-700">
                                </div>
                                <div class="mb-2">
                                    <input type="file" name="events[0][document]"
                                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                </div>
                            </div>
                        </div>
                        <button type="button" onclick="addEventField()" 
                                class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">
                            + Добавить мероприятие
                        </button>
                    </div>

                    <div class="flex justify-between">
                        <button type="button" @click="step = 1" 
                                class="bg-green-500 hover:bg-green-700 text-gray-700 font-bold py-2 px-4 rounded">
                            Назад
                        </button>
                        <button type="submit" 
                                class="bg-green-500 hover:bg-green-700 text-gray-700 font-bold py-2 px-4 rounded">
                            Сохранить отчёт
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        
        function addSportField() {
            const container = document.getElementById('sports-container');
            const index = container.children.length;
            
            const div = document.createElement('div');
            div.className = 'sport-row mb-2 flex gap-2';
            div.innerHTML = `
                <input type="text" name="sports[${index}][name]" placeholder="Вид спорта" required
                       class="shadow appearance-none border rounded py-2 px-3 text-gray-700">
                <input type="number" name="sports[${index}][count]" placeholder="Количество" required
                       class="shadow appearance-none border rounded py-2 px-3 text-gray-700">
                <button type="button" onclick="this.parentElement.remove()" 
                        class="bg-red-100 hover:bg-red-200 px-2 rounded">×</button>
            `;
            
            container.appendChild(div);
        }
        
        function addEventField() {
            const container = document.getElementById('events-container');
            const index = container.children.length;
            
            const div = document.createElement('div');
            div.className = 'event-row mb-4 p-4 border rounded';
            div.innerHTML = `
                <div class="mb-2">
                    <input type="text" name="events[${index}][name]" placeholder="Название мероприятия" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700">
                </div>
                <div class="mb-2">
                    <input type="date" name="events[${index}][date]" required
                           class="shadow appearance-none border rounded py-2 px-3 text-gray-700">
                </div>
                <div class="mb-2">
                    <input type="file" name="events[${index}][document]"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
                <button type="button" onclick="this.parentElement.remove()" 
                        class="bg-red-100 hover:bg-red-200 px-2 rounded">Удалить</button>
            `;
            
            container.appendChild(div);
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-layout>