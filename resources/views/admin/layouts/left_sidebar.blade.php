@php
    $menu = config('menu');
@endphp
<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="{{ route('admin.home') }}" class="logo logo-light">
        <span class="logo-lg">
            <img src="https://iskconnepal.org/wp-content/uploads/2024/02/IN-logo.png" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="https://iskconnepal.org/wp-content/uploads/2024/02/IN-logo.png" alt="small logo">
        </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="{{ route('admin.home') }}" class="logo logo-dark">
        <span class="logo-lg">
            <img src="https://iskconnepal.org/wp-content/uploads/2024/02/IN-logo.png" alt="dark logo">
        </span>
        <span class="logo-sm">
            <img src="https://iskconnepal.org/wp-content/uploads/2024/02/IN-logo.png" alt="small logo">
        </span>
    </a>
    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!-- Leftbar User -->
        <div class="leftbar-user">
            <a href="pages-profile.html">
                <img src="assets/images/users/avatar-1.jpg" alt="user-image" height="42"
                    class="rounded-circle shadow-sm">
                <span class="leftbar-user-name mt-2">Michael Berndt</span>
            </a>
        </div>


        <!--- Sidemenu -->
        <ul class="side-nav">
            @foreach ($menu as $key => $value)
                <li class="side-nav-title text-uppercase">{{ $key }}</li>
                @foreach ($value as $item)
                    @if (isset($item['submenu']))
                        <li class="side-nav-item">
                            <a data-bs-toggle="collapse" href="#sidebar{{ $item['title'] }}" aria-expanded="false"
                                aria-controls="sidebar{{ $item['title'] }}" class="side-nav-link">
                                <i class="{{ $item['icon'] }}"></i>
                                <span> {{ $item['title'] }} </span>
                                <span class="menu-arrow"></span>
                            </a>
                            <div class="collapse" id="sidebar{{ $item['title'] }}">
                                <ul class="side-nav-second-level">
                                    @foreach ($item['submenu'] as $subitem)
                                        <li>
                                            <a href="{{ route($subitem['url']) }}">{{ $subitem['title'] }}</a>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </li>
                    @else
                        <li class="side-nav-item">
                            <a href="{{ route($item['url']) }}" class="side-nav-link">
                            <i class="{{ $item['icon'] }}"></i>
                            <span> {{ $item['title'] }} </span>
                        </a>
                        </li>
                    @endif
                @endforeach
            @endforeach

        </ul>

        <div class="clearfix"></div>
    </div>
</div>
