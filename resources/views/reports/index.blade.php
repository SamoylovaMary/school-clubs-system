@extends('layouts.app')

@section('content')
    <h1>Мои отчеты</h1>
    <a href="{{ route('reports.create') }}" class="btn btn-primary">Создать отчет</a>

    @foreach ($reports as $report)
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Отчет #{{ $report->id }}</h5>
                <p class="card-text">
                    Статус: {{ $report->status }}
                </p>
                <a href="{{ route('reports.show', $report) }}" class="btn btn-info">Просмотреть</a>
            </div>
        </div>
    @endforeach
@endsection