<div class="row">
    <div class="col-12">
        <div class="bg-flower">
            <img src="{{ asset('assets/images/flowers/img-3.png') }}">
        </div>

        <div class="bg-flower-2">
            <img src="{{ asset('assets/images/flowers/img-1.png') }}">
        </div>

        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    @foreach ($breadcumbs as $breadcumb)
                        @if ($loop->last)
                            <li class="breadcrumb-item"><a href="#" class="active">
                                    @if (isset($breadcumb['icon']))
                                        <i class="{{ $breadcumb['icon'] }}"></i>
                                    @endif {{ $breadcumb['name'] }}
                                </a>
                            </li>
                        @else
                            <li class="breadcrumb-item"><a href="{{ $breadcumb['url'] }}">
                                    @if (isset($breadcumb['icon']))
                                        <i class="{{ $breadcumb['icon'] }}"></i>
                                    @endif {{ $breadcumb['name'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                  
                </ol>
            </div>
        </div>
    </div>
</div>
