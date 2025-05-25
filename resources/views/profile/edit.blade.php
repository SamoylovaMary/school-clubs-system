@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Редактирование профиля</h1>
    
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')
        
        <div class="mb-3">
            <label>Имя</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>
    
    <form method="POST" action="{{ route('profile.destroy') }}" class="mt-5">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Удалить аккаунт</button>
    </form>
</div>
@endsection
