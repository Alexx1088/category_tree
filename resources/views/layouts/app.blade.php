<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Категории</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Optionally include Bootstrap or your own CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    @yield('head')
</head>
<body>
<div class="container mt-4">
    @yield('content')
</div>

@yield('scripts')
</body>
</html>
