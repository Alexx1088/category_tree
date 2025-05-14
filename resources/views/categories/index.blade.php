@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Категории</h2>

        {{-- Create Form --}}
        <form method="POST" action="{{ route('categories.store') }}" class="mb-4">
            @csrf
            <input type="text" name="name" placeholder="Название категории" required>
            <button type="submit">➕ Создать</button>
            @error('name')
            <div style="color: red;">{{ $message }}</div>
            @enderror
        </form>

        {{-- Category Tree --}}
        <div class="dd" id="nestable">
            {!! buildTree($categories) !!}
        </div>

        <button id="save-order" style="margin-top: 15px;">💾 Сохранить порядок</button>
    </div>
@endsection

@section('scripts')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/nestable2@1.6.0/jquery.nestable.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/nestable2@1.6.0/jquery.nestable.min.css">

    <script>
        $('#nestable').nestable();

        $('#save-order').on('click', function () {
            let data = $('#nestable').nestable('serialize');
            let csrfToken = '{{ csrf_token() }}';

            $.ajax({
                url: '{{ route('categories.sort') }}',
                method: 'POST',
                data: {
                    _token: csrfToken,
                    tree: data
                },
                success: function (resp) {
                    alert('Сохранено!');
                },
                error: function (xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endsection
