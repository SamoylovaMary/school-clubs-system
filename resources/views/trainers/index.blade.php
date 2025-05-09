

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Список тренеров</h1>
    
    @foreach($trainers as $trainer)
    <div class="card mb-3">
        <div class="card-body">
            <h5>{{ $trainer->name }}</h5>
            <p>Email: {{ $trainer->email }}</p>
            <a href="{{ route('reports.index', ['user_id' => $trainer->id]) }}" class="btn btn-primary">
                Просмотреть отчеты
            </a>
        </div>
    </div>
    @endforeach
</div>
@endsection
