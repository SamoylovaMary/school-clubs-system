@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Создать новый отчет</h1>
    
    <form action="{{ route('reports.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="content">Содержание отчета:</label>
            <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-success">Сохранить отчет</button>
    </form>
</div>
@endsection
