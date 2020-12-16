<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="" name="descriptison">
    <meta content="" name="keywords">
    <title>@yield('title')</title>
    
    @stack('prepend-style')
    @include('includes.style-login')
    @stack('addon-style')
  </head>
  <body>
    @yield('content')

    @stack('prepend-script')
    @include('includes.script')
    @stack('addon-script')
  </body>
</html>
