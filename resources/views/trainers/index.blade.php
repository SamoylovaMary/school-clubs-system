@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Список тренеров</h1>
    <a href="{{ route('admin.trainers.create') }}" class="btn btn-success mb-3">Добавить тренера</a>
    <table class="table">
        <thead>
            <tr>
                <th>ФИО</th>
                <th>Город</th>
                <th>Школа</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($trainers as $trainer)
            <tr>
                <td>{{ $trainer->name }}</td>
                <td>{{ $trainer->city }}</td>
                <td>{{ $trainer->school }}</td>
                <td>{{ $trainer->email }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection