<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin | Dashboard')</title>

    @include('admin.includes.head')
    @yield('styles')
    @stack('styles')

</head>

<body>
    <div class="wrapper">

        @include('admin.layouts.topbar')
        @include('admin.layouts.left_sidebar')

        <div class="content-page">
            <div class="content">

                <div class="container-fluid">
                    @include('admin.includes.breadcumb')
                   
                    @yield('content')

                </div> 

            </div> 

            @include('admin.layouts.footer')
            @yield('scripts')

        </div>

    </div>
    <!-- END wrapper -->

    @include('admin.layouts.right_sidebar')

    
    @include('admin.includes.foot')
    @include('admin.includes.toastr')

    @yield('scripts')
    @stack('scripts')

</body>

</html>
