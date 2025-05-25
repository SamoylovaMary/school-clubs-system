@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Добавить нового тренера</h1>
    
    @if (->any())
        <div class="alert alert-danger">
            <ul>
                @foreach (->all() as )
                    <li>{{  }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('trainers.store') }}">
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
