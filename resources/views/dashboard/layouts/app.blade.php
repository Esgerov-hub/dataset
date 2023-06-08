<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>DataSet @yield('dashboard.title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    @yield('dashboard.css')
</head>

<body data-sidebar="dark" data-layout-mode="light">
<!-- Begin page -->
<div id="layout-wrapper">


    @include('dashboard.layouts.partials.header')

    <!-- ========== Left Sidebar Start ========== -->
    @include('dashboard.layouts.partials.leftSidebar')
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

       @yield('dashboard.content')
        @include('dashboard.layouts.partials.footer')
    </div>
    <!-- end main content-->

</div>
<!-- END layout-wrapper -->
<!-- JAVASCRIPT -->
@yield('dashboard.js')
</body>
</html>
