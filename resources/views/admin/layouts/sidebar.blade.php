@php
    $menu = config('menu');
@endphp
<div class="navigation">
    <h5 class="title">Navigation</h5>
    <ul class="menu js__accordion">
        @foreach ($menu['navigation'] as $item)
            <li>
                @if (isset($item['submenu']))
                    <a class="waves-effect parent-item js__control" href="#">
                        <i class="menu-icon {{ $item['icon'] }}"></i>
                        <span>{{ $item['title'] }}</span>
                        <span class="menu-arrow fa fa-angle-down"></span>
                    </a>
                    <ul class="sub-menu js__content">
                        @foreach ($item['submenu'] as $subitem)
                            <li><a href="{{ route($subitem['url']) }}">{{ $subitem['title'] }}</a></li>
                        @endforeach
                    </ul>
                @else
                    <a class="waves-effect" href="{{ route($item['url']) }}">
                        <i class="menu-icon {{ $item['icon'] }}"></i>
                        <span>{{ $item['title'] }}</span>
                    </a>
                @endif
            </li>
        @endforeach
    </ul>

    <h5 class="title">Components</h5>
    {{-- <ul class="menu js__accordion">
        @foreach ($menu['components'] as $item)
            <li>
                @if (isset($item['submenu']))
                    <a class="waves-effect parent-item js__control" href="#">
                        <i class="menu-icon {{ $item['icon'] }}"></i>
                        <span>{{ $item['title'] }}</span>
                        <span class="menu-arrow fa fa-angle-down"></span>
                    </a>
                    <ul class="sub-menu js__content">
                        @foreach ($item['submenu'] as $subitem)
                            <li><a href="{{ route($subitem['route']) }}">{{ $subitem['title'] }}</a></li>
                        @endforeach
                    </ul>
                @else
                    <a class="waves-effect" href="{{ route($item['route']) }}">
                        <i class="menu-icon {{ $item['icon'] }}"></i>
                        <span>{{ $item['title'] }}</span>
                    </a>
                @endif
            </li>
        @endforeach
    </ul> --}}
</div>
