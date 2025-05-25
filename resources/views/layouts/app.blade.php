<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>@yield('title', 'Dashboard')</title>

  {{-- Fonts and Icons --}}
  <link href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,800" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

  {{-- CSS --}}
  <link href="{{ asset('assets/css/soft-ui-dashboard.css') }}" rel="stylesheet" />
  @stack('styles')
</head>
<body class="g-sidenav-show bg-gray-100">
  @include('layouts.sidebar')

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    @include('layouts.navbar')

    <div class="container-fluid py-4">
      @yield('content')
    </div>

    @include('layouts.footer')
  </main>

  @stack('scripts')
</body>
</html>
