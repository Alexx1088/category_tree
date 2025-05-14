
@extends('layouts.app')

@section('content')
    <h2>Редактировать категорию</h2>

    <form method="POST" action="{{ route('categories.update', $category) }}">
        @csrf
        @method('PUT')

        <label for="name">Название:</label>
        <input type="text" name="name" value="{{ old('name', $category->name) }}" placeholder="Название">

        <button type="submit">Сохранить</button>
    </form>

    <a href="{{ route('categories.index') }}">Назад</a>
@endsection
