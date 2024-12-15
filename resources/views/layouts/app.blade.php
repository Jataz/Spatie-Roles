<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'Dashboard')</title>

  <!-- Favicons -->
  <link href="{{ asset('img/favicon.png') }}" rel="icon">
  <link href="{{ asset('img/apple-touch-icon.png') }}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  @section('header')
      @include('layouts.header')
  @show
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  @section('sidebar')
      @include('layouts.sidebar')
  @show
  <!-- End Sidebar -->

  <main id="main" class="main">
      @yield('content')
  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  @section('footer')
      @include('layouts.footer')
  @show
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{ asset('vendor/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/chart.js/chart.umd.js') }}"></script>
  <script src="{{ asset('vendor/echarts/echarts.min.js') }}"></script>
  <script src="{{ asset('vendor/quill/quill.js') }}"></script>
  <script src="{{ asset('vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('vendor/php-email-form/validate.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('js/main.js') }}"></script>


    <script>
        let warningTimeout = {{ config('session.lifetime') - 5 }} * 60 * 1000; // 5 minutes before timeout
        let logoutTimeout = {{ config('session.lifetime') }} * 60 * 1000; // Session timeout

        let warningTimer = setTimeout(() => {
            alert('You will be logged out soon due to inactivity.');
        }, warningTimeout);

        let logoutTimer = setTimeout(() => {
            window.location.href = "{{ route('logout') }}";
        }, logoutTimeout);

        document.body.addEventListener('mousemove', resetTimers); // Reset on user activity
        document.body.addEventListener('keypress', resetTimers);

        function resetTimers() {
            clearTimeout(warningTimer);
            clearTimeout(logoutTimer);

            warningTimer = setTimeout(() => {
                alert('You will be logged out soon due to inactivity.');
            }, warningTimeout);

            logoutTimer = setTimeout(() => {
                window.location.href = "{{ route('logout') }}";
            }, logoutTimeout);
        }
    </script>


  @stack('extra_scripts')

</body>

</html>
