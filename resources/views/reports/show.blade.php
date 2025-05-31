@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card">
        <div class="card-header">
            <h2>Отчет #{{ $report->id }}</h2>
        </div>
        
        <div class="card-body">
            <!-- Основная информация -->
            <div class="mb-4">
                <h4>Основные данные</h4>
                <p><strong>Статус:</strong> 
                    <span class="badge bg-{{ $report->status === 'approved' ? 'success' : 'warning' }}">
                        {{ $report->status === 'approved' ? 'Одобрен' : 'На рассмотрении' }}
                    </span>
                </p>
                <p><strong>Количество участников:</strong> {{ $report->data['students_count'] ?? 'Нет данных' }}</p>
            </div>

            <!-- Виды спорта -->
            <div class="mb-4">
                <h4>Виды спорта</h4>
                @if(!empty($report->data['sports']))
                    <ul class="list-group">
                        @foreach($report->data['sports'] as $sport)
                            <li class="list-group-item">
                                {{ $sport['name'] }}: {{ $sport['count'] }} участников
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>Нет данных о видах спорта</p>
                @endif
            </div>

            <!-- Мероприятия -->
            <div class="mb-4">
                <h4>Мероприятия</h4>
                @if(!empty($report->data['events']))
                    <div class="row">
                        @foreach($report->data['events'] as $event)
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>{{ $event['name'] }}</h5>
                                        <p><strong>Дата:</strong> {{ $event['date'] }}</p>
                                        @if(!empty($event['document_path']))
                                            <a href="{{ Storage::url($event['document_path']) }}" 
                                               target="_blank"
                                               class="btn btn-sm btn-outline-primary">
                                                Скачать документ
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>Нет данных о мероприятиях</p>
                @endif
            </div>

            <!-- Кнопка одобрения -->
            @if($report->status !== 'approved')
                <form action="{{ route('admin.reports.approve', $report) }}" method="POST" class="mt-4">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        Одобрить отчет
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection