@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Добавить нового тренера</h1>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.trainers.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">ФИО тренера</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Город</label>
            <input type="text" name="city" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Школа</label>
            <input type="text" name="school" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Добавить тренера</button>
    </form>
</div>
@endsection
