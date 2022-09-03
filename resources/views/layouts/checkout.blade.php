<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{$title}} | {{$subtitle}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('prepend-style')
    @include('includes.style')
    @stack('addon-style')
</head>

<body>
    <!-- Semantic elements -->
    <!-- https://www.w3schools.com/html/html5_semantic_elements.asp -->

    <!-- Bootstrap navbar example -->
    <!-- https://www.w3schools.com/bootstrap4/bootstrap_navbar.asp -->
    @include('includes.navbar-alternate')
    @yield('content')
    @include('includes.footer')
    @stack('prepend-script')
    @include('includes.script')
    @stack('addon-script')
</body>

</html>