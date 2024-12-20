<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel App')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="/">Products</a></li>
                <li><a href="/cart">Cart</a></li>
                <li><a href="/orders">Orders</a></li>
            </ul>
        </nav>
    </header>
    <main>
        @yield('content')
    </main>
    <footer>
        <p>&copy; 2024 My Laravel App</p>
    </footer>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
